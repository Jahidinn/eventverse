<?php

namespace App\Services;

use App\Models\CustomForm;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\PaymentGateway;
use App\Models\Reservation;
use App\Models\PaymentGatewayMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Services\Payment\XenditService;
use App\Services\Payment\MidtransService;
use App\Services\EmailService;
use App\Models\FeeRule;
use App\Models\TransactionForm;
use App\Models\TransactionParticipant;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class TransactionService
{
    public function __construct(
        protected XenditService $xenditService,
        protected MidtransService $midtransService,
        protected TicketService $ticketService,
        protected EmailService $emailService,
    ) {}
    
    public function validateCheckout(Request $request): array
    {
        // $event = Event::findOrFail(
        //     $request->event_id
        // );

        // $ticket = Ticket::where('id', $request->ticket_id)
        //     ->where('event_id', $event->id)
        //     ->firstOrFail();
        $reservation = Reservation::with([
            'event',
            'ticket',
        ])->where(
            'reservation_code',
            $request->reservation_code
        )->firstOrFail();

        if ($reservation->status !== 'Reserved') {
            throw ValidationException::withMessages([
                'reservation' => 'Reservation sudah tidak aktif.',
            ]);
        }

        if ($reservation->expired_at->isPast()) {

            app(ReservationService::class)
                ->expire($reservation->reservation_code);

            throw ValidationException::withMessages([
                'reservation' => 'Reservation telah berakhir.',
            ]);
        }

        $event = $reservation->event;
        $ticket = $reservation->ticket;
        $quantity = $reservation->quantity;

        $quantity = count(
            $request->participants
        );

        // Sudah check saat reservasi
        // $this->ticketService->validateAvailability(
        //     $ticket,
        //     $quantity
        // );

        $this->validateParticipants(
            $request,
            $event
        );

        return $this->buildSummary(
            $event,
            $ticket,
            $quantity,
            $request
        );
    }

    private function validateParticipants(
        Request $request,
        Event $event
    ): void {

        $forms = CustomForm::where('event_id', $event->id)
            ->where('field_status', true)
            ->orderBy('sort_order')
            ->get();

        $rules = [];
        $messages = [];

        foreach ($request->participants as $participantIndex => $participant) {

            foreach ($forms as $form) {

                $field = "participants.$participantIndex.customForm.$form->id";

                $rule = [];

                /*
                |--------------------------------------------------------------------------
                | Required
                |--------------------------------------------------------------------------
                */

                $rule[] = $form->field_required
                    ? 'required'
                    : 'nullable';

                /*
                |--------------------------------------------------------------------------
                | Type
                |--------------------------------------------------------------------------
                */

                switch ($form->field_type) {

                    case 'text':
                    case 'textarea':

                        $rule[] = 'string';

                        if (!empty($form->field_validation['min_length'])) {
                            $rule[] = 'min:'.$form->field_validation['min_length'];
                        }

                        if (!empty($form->field_validation['max_length'])) {
                            $rule[] = 'max:'.$form->field_validation['max_length'];
                        }

                        break;

                    case 'email':

                        $rule[] = 'email';

                        break;

                    case 'phone':

                        $rule[] = 'string';
                        $rule[] = 'max:25';
                        $rule[] = 'regex:/^\+[1-9]\d{7,14}$/';

                        break;

                    case 'number':

                        $rule[] = 'numeric';

                        if (isset($form->field_validation['min'])) {
                            $rule[] = 'min:'.$form->field_validation['min'];
                        }

                        if (isset($form->field_validation['max'])) {
                            $rule[] = 'max:'.$form->field_validation['max'];
                        }

                        break;

                    case 'date':

                        $rule[] = 'date';

                        break;

                    case 'time':

                        $rule[] = 'date_format:H:i';

                        break;

                    case 'select':
                    case 'radio':

                        $rule[] = Rule::in($form->field_options ?? []);

                        break;

                    case 'checkbox':

                        $rule[] = 'array';

                        if ($form->field_required) {
                            $rule[] = 'min:1';
                        }

                        $rules[$field.'.*'] = [
                            Rule::in($form->field_options ?? [])
                        ];

                        break;

                    case 'image':

                        $rule[] = 'image';

                        // Maksimal 5 MB
                        $rule[] = 'max:5120';

                        if (!empty($form->field_validation['extensions'])) {

                            $rule[] = 'mimes:' . implode(
                                ',',
                                $form->field_validation['extensions']
                            );

                        }

                        break;

                    case 'file':

                        $rule[] = 'file';

                        // Maksimal 10 MB
                        $rule[] = 'max:10240';

                        if (!empty($form->field_validation['extensions'])) {

                            $rule[] = 'mimes:' . implode(
                                ',',
                                $form->field_validation['extensions']
                            );

                        }

                        break;
                }

                $rules[$field] = $rule;

                /*
                |--------------------------------------------------------------------------
                | Custom Message
                |--------------------------------------------------------------------------
                */

                $messages["$field.required"] =
                    "{$form->field_label} wajib diisi.";

                $messages["$field.email"] =
                    "{$form->field_label} harus berupa email.";

                $messages["$field.numeric"] =
                    "{$form->field_label} harus berupa angka.";

                $messages["$field.date"] =
                    "{$form->field_label} tidak valid.";

                $messages["$field.image"] =
                    "{$form->field_label} harus berupa gambar.";

                $messages["$field.file"] =
                    "{$form->field_label} harus berupa file.";

                $messages["$field.in"] =
                    "{$form->field_label} tidak valid.";

                $messages["$field.*.in"] =
                    "{$form->field_label} memiliki pilihan yang tidak valid.";

                $messages["$field.max"] =
                    "{$form->field_label} melebihi ukuran maksimum.";
                $messages["$field.regex"] =
                    "{$form->field_label} harus berupa nomor telepon yang valid.";

            }

        }

        Validator::make(
            $request->all(),
            $rules,
            $messages
        )->validate();
    }

    private function buildSummary(
        Event $event,
        Ticket $ticket,
        int $quantity,
        Request $request
    ): array
    {
        $subtotal = $ticket->ticket_price * $quantity;

        $platformFee = $this->calculateFeeRule(
            'platform_fee',
            $subtotal
        );

        $paymentFee = 0;

        return [

            'event' => [
                'id'    => $event->id,
                'title' => $event->title,
                'image' => $event->image,
                'location' => $event->location_jenis,
            ],

            'ticket' => [
                'id'    => $ticket->id,
                'name'  => $ticket->ticket_name,
                'price' => $ticket->ticket_price,
            ],

            'buyer' => [
                'name'  => $request->buyer['name'],
                'email' => $request->buyer['email'],
                'phone' => $request->buyer['phone'],
            ],

            'participants' => $this->buildParticipantSummary(
                $request->participants,
                $request->buyer
            ),

            'payment_categories' => $this->getPaymentMethods(),

            'quantity'      => $quantity,

            'subtotal'      => $subtotal,
            'platform_fee'  => $platformFee,
            'payment_fee'   => $paymentFee,
            'grand_total'   => $subtotal + $platformFee + $paymentFee,

        ];
    }

    private function buildParticipantSummary(array $participants, array $buyer): array
    {
        return collect($participants)
            ->values()
            ->map(function ($participant, $index) use ($buyer) {

                if (!empty($participant['same_as_buyer'])) {

                    return [
                        'number' => $index + 1,
                        'name' => $buyer['name'],
                        'email' => $buyer['email'],
                        'phone' => $buyer['phone'],
                        'same_as_buyer' => true,
                    ];
                }

                $summary = [
                    'number' => $index + 1,
                    'name' => null,
                    'email' => null,
                    'phone' => null,
                    'same_as_buyer' => false,
                ];

                foreach ($participant['fieldKey'] as $fieldId => $fieldKey) {

                    $value = $participant['customForm'][$fieldId] ?? null;

                    switch ($fieldKey) {

                        case 'full_name':
                            $summary['name'] = $value;
                            break;

                        case 'email':
                            $summary['email'] = $value;
                            break;

                        case 'phone':
                            $summary['phone'] = $value;
                            break;

                    }

                }

                return $summary;

            })
            ->all();
    }

    public function getPaymentMethods(
        ?int $exceptPaymentGatewayMethodId = null
    ): array
    {
        $active_payment_gateway = config('payment.payment_gateway');
        $gateway = PaymentGateway::where('slug', $active_payment_gateway)->firstOrFail();

        return PaymentGatewayMethod::query()
            ->with([
                'method.category',
            ])
            ->where('payment_gateway_id', $gateway->id)
            ->where('is_active', true)
            ->when($exceptPaymentGatewayMethodId, function ($query) use ($exceptPaymentGatewayMethodId) {
                $query->where('id', '!=', $exceptPaymentGatewayMethodId);
            })
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn ($item) => $item->method->category->id)
            ->map(function ($methods) {

                $category = $methods->first()->method->category;

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'icon' => $category->icon,
                    'methods' => $methods->map(function ($gatewayMethod) {

                        return [
                            'payment_gateway_method_id' => $gatewayMethod->id,
                            'name' => $gatewayMethod->method->name,
                            'icon' => $gatewayMethod->method->icon_url,
                            'description' => $gatewayMethod->method->description,
                            'fee_type' => $gatewayMethod->fee_type,
                            'fee_value' => (float) $gatewayMethod->fee_value,
                        ];

                    })->values(),
                ];

            })
            ->filter(fn ($category) => $category['methods']->isNotEmpty())
            ->values()
            ->toArray();
    }



    // PROSES TRANSAKSI

    public function checkout(Request $request): Transaction
    {
        // $this->ticketService->validateCheckout([
        //     'ticket_id' => $request->ticket_id,
        //     'quantity'  => (int) $request->quantity,
        // ]);

        $transaction = $this->storeTransaction($request);

        /*
        |--------------------------------------------------------------------------
        | Free Transaction
        |--------------------------------------------------------------------------
        */

        if ($transaction->grand_total == 0) {

            DB::transaction(function () use ($transaction) {

                $this->ticketService->sell(
                    $transaction->ticket_id,
                    $transaction->quantity
                );

                $transaction->update([
                    'status'  => 'Paid',
                    'paid_at' => now(),
                ]);

            });

            $this->emailService->sendPaid($transaction);

            return $transaction;
        }

        /*
        |--------------------------------------------------------------------------
        | Paid Transaction
        |--------------------------------------------------------------------------
        */

        $transaction = $this->createPayment($transaction);

        $this->emailService->sendTransaction($transaction);

        return $transaction;

    }
    

    private function storeTransaction(Request $request): Transaction
    {
        return DB::transaction(function () use ($request) {

            $transaction = $this->createTransaction($request);

            $participants = $this->createParticipants(
                $transaction,
                $request
            );

            $this->createCustomForms(
                $participants,
                $request
            );

            return $transaction;

        });
    }

    private function validateMinimumAmount(
        PaymentGatewayMethod $paymentGatewayMethod,
        float $grandTotal
    ): void
    {
        if (
            $paymentGatewayMethod->fee_min !== null &&
            $grandTotal < $paymentGatewayMethod->fee_min
        ) {
            throw ValidationException::withMessages([
                'payment_gateway_method_id' => sprintf(
                    'Minimal pembayaran menggunakan %s adalah Rp %s.',
                    $paymentGatewayMethod->method->name,
                    number_format(
                        $paymentGatewayMethod->fee_min,
                        0,
                        ',',
                        '.'
                    ),
                ),
            ]);
        }
    }

    // private function createPayment(
    //     Transaction $transaction
    // ): Transaction
    // {
    //     $transaction->load(
    //         'paymentGatewayMethod',
    //         'ticket',
    //     );

    //     $payment = $this->xenditService
    //         ->createPaymentRequest($transaction);

    //     if (
    //         empty($payment['payment_request_id']) ||
    //         empty($payment['status'])
    //     ) {
    //         throw new Exception(
    //             'Invalid Xendit payment request response.'
    //         );
    //     }

    //     $expiredAt = data_get(
    //         $payment,
    //         'channel_properties.expires_at'
    //     );

    //     $transaction->update([

    //         'payment_reference' => $payment['payment_request_id'],

    //         'payment_payload' => $payment,

    //         'expired_at' => $expiredAt
    //             ? Carbon::parse($expiredAt)
    //             : $transaction->expired_at,

    //     ]);

    //     return $transaction->fresh();
    // }

    private function createPayment(
    Transaction $transaction
): Transaction {

    /*
    |--------------------------------------------------------------------------
    | LOAD RELATION
    |--------------------------------------------------------------------------
    */

    $transaction->load([
        'paymentGatewayMethod.gateway',
        'paymentGatewayMethod.method',
        'ticket',
        'reservation',
    ]);


    /*
    |--------------------------------------------------------------------------
    | GATEWAY AKTIF
    |--------------------------------------------------------------------------
    */

    $gateway = config('payment.payment_gateway');


    /*
    |--------------------------------------------------------------------------
    | PASTIKAN PAYMENT METHOD SESUAI GATEWAY
    |--------------------------------------------------------------------------
    */

    $methodGateway =
        $transaction->paymentGatewayMethod
            ?->gateway
            ?->slug;

    if ($methodGateway !== $gateway) {

        throw new Exception(
            "Payment method menggunakan gateway [{$methodGateway}], " .
            "sedangkan gateway aktif adalah [{$gateway}]."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PAYMENT
    |--------------------------------------------------------------------------
    */

    $payment = match ($gateway) {

        'xendit' =>
            $this->xenditService
                ->createPaymentRequest($transaction),

        'midtrans' =>
            $this->midtransService
                ->createPaymentRequest($transaction),

        default =>
            throw new Exception(
                "Payment gateway [{$gateway}] tidak didukung."
            ),
    };


    /*
    |--------------------------------------------------------------------------
    | XENDIT
    |--------------------------------------------------------------------------
    */

    if ($gateway === 'xendit') {

        if (
            empty($payment['payment_request_id']) ||
            empty($payment['status'])
        ) {
            throw new Exception(
                'Invalid Xendit payment request response.'
            );
        }


        $expiredAt = data_get(
            $payment,
            'channel_properties.expires_at'
        );


        $transaction->update([
            'payment_reference' =>
                $payment['payment_request_id'],

            'payment_payload' =>
                $payment,

            'expired_at' =>
                $expiredAt
                    ? Carbon::parse($expiredAt)
                    : $transaction
                        ->reservation
                        ->expired_at,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MIDTRANS
    |--------------------------------------------------------------------------
    */

    if ($gateway === 'midtrans') {

        if (
            empty($payment['transaction_id']) ||
            empty($payment['transaction_status'])
        ) {

            throw new Exception(
                'Invalid Midtrans payment response: ' .
                json_encode($payment)
            );
        }


        /*
        |--------------------------------------------------------------------------
        | MIDTRANS
        |--------------------------------------------------------------------------
        |
        | transaction_id -> payment_reference
        | order_id       -> transaction_code
        |
        */

        $transaction->update([
            'payment_reference' =>
                $payment['transaction_id'],

            'payment_payload' =>
                $payment,

            'expired_at' =>
                $transaction
                    ->reservation
                    ->expired_at,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | RETURN
    |--------------------------------------------------------------------------
    */

    return $transaction->fresh([
        'paymentGatewayMethod.gateway',
        'paymentGatewayMethod.method',
        'ticket',
        'reservation',
    ]);
}



    private function createTransaction(Request $request): Transaction
    {
        // $ticket = Ticket::findOrFail(
        //     $request->ticket_id
        // );

        $reservation = Reservation::with('ticket')
            ->where(
                'reservation_code',
                $request->reservation_code
            )
            ->firstOrFail();

        $ticket = $reservation->ticket;

        $paymentGatewayMethod = PaymentGatewayMethod::with([
            'gateway',
            'method'
        ])->findOrFail(
            $request->payment_gateway_method_id
        );

        $subtotal = $ticket->ticket_price * $reservation->quantity;

        $platformFee = $this->calculateFeeRule(
            'platform_fee',
            $subtotal
        );

        $paymentFee = $this->calculatePaymentFee(
            $paymentGatewayMethod,
            $subtotal
        );

        $grandTotal = $subtotal
            + $platformFee
            + $paymentFee;

        $this->validateMinimumAmount(
            $paymentGatewayMethod,
            $grandTotal
        );


        $transaction_data = [
            'transaction_code' => $this->generateUniqueCode(),
            'ticket_id' => $ticket->id,
            'reservation_id' => $reservation->id,
            'event_id' => $ticket->event_id,
            'buyer_name' => $request->buyer['name'],
            'buyer_phone' => $request->buyer['phone'],
            'buyer_email' => $request->buyer['email'],
            'quantity' => $reservation->quantity,
            'subtotal' => $subtotal,
            'platform_fee' => $platformFee,
            'payment_fee' => $paymentFee,
            'grand_total' => $grandTotal,
            'currency' => 'IDR',
            'environment' => 'sandbox',
            'status' => 'Pending',
            'payment_gateway_method_id' => $paymentGatewayMethod->id,
            'user_id' => $request->is_login
                ? $request->user_login_id
                : null,

        ];

        return Transaction::create($transaction_data);
    }

    private function createParticipants(
        Transaction $transaction,
        Request $request
    ): Collection
    {
        $participants = collect();

        foreach ($request->participants as $index => $participant) {

            $name  = null;
            $email = null;
            $phone = null;

            foreach ($participant['fieldKey'] ?? [] as $formId => $fieldKey) {

                $value = $participant['customForm'][$formId] ?? null;

                match ($fieldKey) {
                    'full_name' => $name = $value,
                    'email'     => $email = $value,
                    'phone'     => $phone = $value,
                    default     => null,
                };
            }

            $participants->push(
                TransactionParticipant::create([

                    'transaction_id'   => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,

                    'ticket_code' => sprintf(
                        '%s-%03d',
                        $transaction->transaction_code,
                        $index + 1
                    ),

                    'name'  => $name,
                    'email' => $email,
                    'phone' => $phone,

                ])
            );
        }

        return $participants;
    }
    private function createCustomForms(
            Collection $participants,
            Request $request
        ): void
        {
            $formIds = collect($request->participants)
                ->pluck('customForm')
                ->flatMap(fn ($forms) => array_keys($forms))
                ->unique()
                ->values();

            $customForms = CustomForm::whereIn('id', $formIds)
                ->get()
                ->keyBy('id');

            foreach ($participants as $index => $transactionParticipant) {

                foreach (
                    $request->participants[$index]['customForm']
                    as $formId => $value
                ) {

                    if (
                        $value instanceof UploadedFile &&
                        isset($customForms[$formId])
                    ) {

                        $value = $this->storeCustomFormFile(
                            $value,
                            $customForms[$formId],
                            $transactionParticipant
                        );

                    }

                    TransactionForm::create([

                        'participant_id' => $transactionParticipant->id,

                        'form_id' => $formId,

                        'form_value' => $value,

                    ]);

                }

            }
        }

    private function storeCustomFormFile(
        UploadedFile $file,
        CustomForm $customForm,
        TransactionParticipant $participant
    ): string
    {
        $directory = match ($customForm->field_type) {
            'image' => 'form-images',
            'file'  => 'form-files',
            default => throw new Exception(
                "Field {$customForm->id} bukan tipe upload."
            ),
        };

        $filename = sprintf(
            '%s-%s.%s',
            $participant->ticket_code,
            $customForm->id,
            $file->extension()
        );

        return $file->storeAs(
            $directory,
            $filename,
            'public'
        );
    }

    private function calculateFeeRule(
        string $code,
        float $subtotal
    ): float
    {
        $feeRule = FeeRule::where(
            'code',
            $code
        )
        ->where(
            'is_active',
            true
        )
        ->first();

        if (!$feeRule) {
            return 0;
        }

        if ($feeRule->fee_type === 'fixed') {
            return (float) $feeRule->fee_value;
        }

        $fee = ($subtotal * $feeRule->fee_value) / 100;

        if (
            $feeRule->fee_min !== null &&
            $fee < $feeRule->fee_min
        ) {
            $fee = $feeRule->fee_min;
        }

        if (
            $feeRule->fee_max !== null &&
            $fee > $feeRule->fee_max
        ) {
            $fee = $feeRule->fee_max;
        }

        return (float) $fee;
    }

    public function changePaymentMethod(
    Transaction $transaction,
    int $paymentGatewayMethodId
): Transaction {

    /*
    |--------------------------------------------------------------------------
    | LOAD DATA
    |--------------------------------------------------------------------------
    */

    $transaction->load([
        'paymentGatewayMethod.gateway',
        'paymentGatewayMethod.method',
        'reservation',
    ]);


    /*
    |--------------------------------------------------------------------------
    | VALIDASI TRANSAKSI
    |--------------------------------------------------------------------------
    */

    if ($transaction->status !== 'Pending') {
        throw ValidationException::withMessages([
            'transaction' => 'Transaksi tidak dapat diubah.',
        ]);
    }

    if (
        $transaction->expired_at &&
        now()->greaterThanOrEqualTo($transaction->expired_at)
    ) {
        throw ValidationException::withMessages([
            'transaction' => 'Transaksi telah kedaluwarsa.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GATEWAY AKTIF
    |--------------------------------------------------------------------------
    */

    $activeGateway = config('payment.payment_gateway');


    /*
    |--------------------------------------------------------------------------
    | METHOD BARU
    |--------------------------------------------------------------------------
    */

    $newPaymentGatewayMethod = PaymentGatewayMethod::with([
        'gateway',
        'method',
    ])->findOrFail($paymentGatewayMethodId);


    /*
    |--------------------------------------------------------------------------
    | PASTIKAN METHOD SESUAI GATEWAY AKTIF
    |--------------------------------------------------------------------------
    */

    $newGateway = $newPaymentGatewayMethod->gateway?->slug;

    if ($newGateway !== $activeGateway) {
        throw ValidationException::withMessages([
            'payment_gateway_method_id' =>
                'Metode pembayaran tidak sesuai dengan gateway aktif.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | METHOD SAMA
    |--------------------------------------------------------------------------
    */

    if (
        (int) $transaction->payment_gateway_method_id ===
        (int) $newPaymentGatewayMethod->id
    ) {
        return $transaction->fresh([
            'paymentGatewayMethod.gateway',
            'paymentGatewayMethod.method',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL PAYMENT LAMA
    |--------------------------------------------------------------------------
    |
    | WAJIB BERHASIL DAHULU.
    |
    */

    if ($activeGateway === 'xendit') {

        if ($transaction->payment_reference) {

            $this->xenditService->cancelPaymentRequest(
                $transaction->payment_reference
            );
        }

    } elseif ($activeGateway === 'midtrans') {

        /*
        |--------------------------------------------------------------------------
        | MIDTRANS
        |--------------------------------------------------------------------------
        |
        | payment_reference = transaction_id Midtrans
        | transaction_code  = order_id Midtrans
        |
        | Cancel menggunakan ORDER ID.
        |
        */

        $this->midtransService->cancelPaymentRequest(
            $transaction->transaction_code
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG PAYMENT FEE BARU
    |--------------------------------------------------------------------------
    */

    $paymentFee = $this->calculatePaymentFee(
        $newPaymentGatewayMethod,
        $transaction->subtotal
    );


    /*
    |--------------------------------------------------------------------------
    | HITUNG GRAND TOTAL BARU
    |--------------------------------------------------------------------------
    */

    $grandTotal =
        (float) $transaction->subtotal
        + (float) $transaction->platform_fee
        + (float) $paymentFee;


    /*
    |--------------------------------------------------------------------------
    | VALIDASI MINIMUM PAYMENT
    |--------------------------------------------------------------------------
    */

    $this->validateMinimumAmount(
        $newPaymentGatewayMethod,
        $grandTotal
    );


    /*
    |--------------------------------------------------------------------------
    | UPDATE PAYMENT METHOD
    |--------------------------------------------------------------------------
    */

    $transaction->update([
        'payment_gateway_method_id' => $newPaymentGatewayMethod->id,
        'payment_fee' => $paymentFee,
        'grand_total' => $grandTotal,

        /*
        | Payment lama sudah dibatalkan.
        | createPayment() akan mengisi kembali.
        */
        'payment_reference' => null,
        'payment_payload' => null,
    ]);


    /*
    |--------------------------------------------------------------------------
    | CREATE PAYMENT BARU
    |--------------------------------------------------------------------------
    */

    return $this->createPayment(
        $transaction->fresh()
    );
}

    private function calculatePaymentFee(
        PaymentGatewayMethod $paymentGatewayMethod,
        float $subtotal
    ): float
    {
        if ($paymentGatewayMethod->fee_type === 'fixed') {
            return $paymentGatewayMethod->fee_value;
        }

        $fee = ($subtotal * $paymentGatewayMethod->fee_value) / 100;

        if (
            $paymentGatewayMethod->fee_min &&
            $fee < $paymentGatewayMethod->fee_min
        ) {
            $fee = $paymentGatewayMethod->fee_min;
        }

        if (
            $paymentGatewayMethod->fee_max &&
            $fee > $paymentGatewayMethod->fee_max
        ) {
            $fee = $paymentGatewayMethod->fee_max;
        }

        return ceil($fee);
    }

    public function generateUniqueCode()
	{
		do {
			$randomStr = 'EV' . Str::random(15);
			$uniqueCode = strtoupper($randomStr);
		} while (
            Transaction::where(
                'transaction_code',
                $uniqueCode
            )->exists()
        );

		return $uniqueCode;
	}

}