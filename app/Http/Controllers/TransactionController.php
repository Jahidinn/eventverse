<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\CustomForm;
use App\Models\Transaction;
use App\Models\TransactionForm;
use App\Models\TransactionParticipant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\TransactionService;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionController extends Controller
{
	public function __construct(
        protected TransactionService $transactionService,
    ) {}

	public function checkoutPreview(Request $request)
	{
		if (!$request->event || !$request->ticket) {
			return redirect('/search');
		}

		$detailEvent = Event::with('penyelenggara')->where('event_id', $request->event)->first();
		$detailTicket = Ticket::where('id', $request->ticket)->where('event_id', $detailEvent->id)->first();
		$customForms = CustomForm::where('event_id', $detailEvent->id)->get();
		$today = Carbon::now()->format('Y-m-d');

		$ticketUsed = count(Transaction::where('event_id', $request->event)->where('status', '==', 'Paid')->where('ticket_id', $request->ticket)->get());
		$ticketAvailable = $detailTicket->ticket_quota - $ticketUsed;

		if (!$detailEvent || !$detailTicket || !$customForms) {
			return redirect('/search');
		}

		//Jika tiket sudah deadlin, belum mulai, atau quota full
		if ($ticketAvailable <= 0 || $detailTicket->ticket_end < $today || $detailTicket->ticket_start > $today) {
			return redirect('/' . $detailEvent->slug);
		}

		return view('transaction.checkout', [
			'detailEvent' => $detailEvent,
			'detailTicket' => $detailTicket,
			'customForms' => $customForms,
		]);
	}

    // App/Http/Controllers/TransactionController.php

public function show(Transaction $transaction)
{
    $transaction->load([
        'event',
        'ticket',
        'paymentGatewayMethod.method',
        'paymentGatewayMethod.gateway',
        'reservation',
    ]);

    /*
    |--------------------------------------------------------------------------
    | PAID
    |--------------------------------------------------------------------------
    */

    if ($transaction->status === 'Paid') {
        return redirect()->route(
            'transaction.ticket',
            $transaction->transaction_code
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENDING TAPI SUDAH EXPIRED
    |--------------------------------------------------------------------------
    |
    | Jangan biarkan halaman pembayaran tetap bisa dibuka
    | setelah waktu pembayaran habis.
    |
    */

    if (
        $transaction->status === 'Pending' &&
        $transaction->expired_at &&
        now()->greaterThanOrEqualTo($transaction->expired_at)
    ) {

        DB::transaction(function () use ($transaction) {

            /*
            |--------------------------------------------------------------------------
            | Update transaction
            |--------------------------------------------------------------------------
            */

            $transaction->update([
                'status' => 'Expired',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Expire reservation
            |--------------------------------------------------------------------------
            |
            | Endpoint reservation.expire juga sebaiknya idempotent,
            | sehingga aman dipanggil lebih dari sekali.
            |
            */

            $reservation = $transaction->reservation;

            if (
                $reservation &&
                $reservation->status !== 'expired'
            ) {

                $reservation->update([
                    'status' => 'expired',
                ]);

                /*
                |--------------------------------------------------------------------------
                | Kembalikan stock
                |--------------------------------------------------------------------------
                |
                | Sesuaikan bagian ini dengan struktur stock
                | yang digunakan saat checkout.
                |
                */

                // Contoh jika reservation memiliki detail ticket:
                //
                // foreach ($reservation->items as $item) {
                //     $item->ticket->increment(
                //         'stock',
                //         $item->quantity
                //     );
                // }

            }

        });

        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE EVENT
        |--------------------------------------------------------------------------
        */

        return redirect()->to(
            url($transaction->event->slug)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT DISPLAY
    |--------------------------------------------------------------------------
    */

    return view('transaction.show', [
        'transaction' => $transaction,
        'paymentDisplay' => $this->buildPaymentDisplay($transaction),
    ]);
}

private function buildPaymentDisplay(
    Transaction $transaction
): array {
    $payload = is_array($transaction->payment_payload)
        ? $transaction->payment_payload
        : json_decode(
            $transaction->payment_payload ?? '{}',
            true
        );

    $gateway = $transaction
        ->paymentGatewayMethod
        ->gateway
        ->slug ?? null;

    $display = [
        'type' => 'default',

        'title' => $transaction
            ->paymentGatewayMethod
            ->name,

        'qr_value' => null,

        'va_number' => null,

        'deeplink_url' => null,
    ];

    /*
    |--------------------------------------------------------------------------
    | XENDIT
    |--------------------------------------------------------------------------
    */
    if ($gateway === 'xendit') {

        foreach ($payload['actions'] ?? [] as $action) {

            switch ($action['type'] ?? null) {

                case 'PRESENT_TO_CUSTOMER':

                    $display['type'] = 'qris';

                    $display['qr_value'] =
                        $action['value'] ?? null;

                    break;

                case 'DEEPLINK':
                case 'MOBILE_PAYMENT':
                case 'REDIRECT_CUSTOMER':

                    $display['type'] = 'redirect';

                    $display['deeplink_url'] =
                        $action['value'] ?? null;

                    break;
            }
        }

        if (
            isset($payload['account_number']) ||
            isset($payload['va_number'])
        ) {
            $display['type'] = 'virtual_account';

            $display['va_number'] =
                $payload['account_number']
                ?? $payload['va_number'];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MIDTRANS
    |--------------------------------------------------------------------------
    */
    elseif ($gateway === 'midtrans') {

        $paymentType = $payload['payment_type'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Virtual Account
        |--------------------------------------------------------------------------
        */
        if ($paymentType === 'bank_transfer') {

            $vaNumber = data_get(
                $payload,
                'va_numbers.0.va_number'
            );

            $vaNumber ??=
                $payload['permata_va_number'] ?? null;

            if ($vaNumber) {
                $display['type'] = 'virtual_account';

                $display['va_number'] = $vaNumber;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | QRIS
        |--------------------------------------------------------------------------
        */
        elseif ($paymentType === 'qris') {

            $qrValue = $payload['qr_string'] ?? null;

            if ($qrValue) {
                $display['type'] = 'qris';

                $display['qr_value'] = $qrValue;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GoPay / ShopeePay
        |--------------------------------------------------------------------------
        */
        elseif (
            $paymentType === 'gopay' ||
            $paymentType === 'shopeepay'
        ) {

            foreach ($payload['actions'] ?? [] as $action) {

                if (
                    ($action['name'] ?? null)
                    === 'deeplink-redirect'
                ) {
                    $display['type'] = 'redirect';

                    $display['deeplink_url'] =
                        $action['url'] ?? null;

                    break;
                }
            }
        }
    }

    return $display;
}

	/**
	 * Endpoint JSON untuk polling status transaksi via AJAX
	 */
	public function checkStatus(Transaction $transaction)
	{
		return response()->json([
			'status' => strtolower($transaction->status), // 'pending', 'paid', 'expired', dsb.
			'redirect_url' => route('transaction.ticket', $transaction->transaction_code),
			//ganti invoice
		]);
	}

	public function changePayment(
		Request $request,
		Transaction $transaction
	) {
		$request->validate([
			'payment_gateway_method_id' => [
				'required',
				'exists:payment_gateway_methods,id',
			],
		]);

		$transaction = $this->transactionService
			->changePaymentMethod(
				transaction: $transaction,
				paymentGatewayMethodId: $request->payment_gateway_method_id,
			);

		return response()->json([
			'success' => true,
			'redirect_url' => route(
				'transaction.show',
				$transaction->transaction_code
			),
		]);
	}


	public function paymentMethods(
		Transaction $transaction
	) {
		return response()->json([

			'success' => true,

			'payment_categories' => $this->transactionService
				->getPaymentMethods(
					$transaction->payment_gateway_method_id
				),

		]);
	}

    public function detail(Transaction $transaction)
    {
        if ($transaction->status !== 'Paid') {
            return redirect('/');
        }

        $transaction->load([
            'event',
            'ticket',
            'participants',
            'participants.forms.form',
            'paymentGatewayMethod.method',
            'paymentGatewayMethod.gateway',
        ]);

        return view('reports.transaction-detail', [
            'transaction' => $transaction,
            'event' => $transaction->event,
            'ticket' => $transaction->ticket,
            'participants' => $transaction->participants,
            'paymentGatewayMethod' => $transaction->paymentGatewayMethod,
        ]);
    }


	public function ticket(Transaction $transaction)
	{
		if ($transaction->status !== 'Paid') {
			return redirect('/');
		}

		$transaction->load([
			'event',
			'ticket',
			'participants',
		]);

		return view('apps.ticket', [
			'transaction' => $transaction,
			'event' => $transaction->event,
			'ticket' => $transaction->ticket,
			'participant' => $transaction->participants,
		]);
	}

	public function downloadTicket(Transaction $transaction)
	{
		if ($transaction->status !== 'Paid') {
			return redirect('/');
		}

		$transaction->load([
			'event.org',
			'event.individual',
			'ticket',
			'participants',
		]);

		$event = $transaction->event;
		$ticket = $transaction->ticket;

		// Event Banner Path
		$bannerPath = 'storage/event-images/' . $event->image;
		if (!empty($event->image) && file_exists(public_path($bannerPath))) {
			$img = public_path($bannerPath);
		} else {
			$img = public_path('assets/default-img/event-images/def-no-img.png');
		}

		// Generate QR Code untuk setiap peserta
		$participantQrcodes = [];
		foreach ($transaction->participants as $participant) {
			$ticketCode = $participant->ticket_code ?? $transaction->ticket_code ?? $transaction->transaction_code;
			
			$participantQrcodes[$participant->id] = base64_encode(
				QrCode::format('svg')
					->backgroundColor(255, 255, 255)
					->color(15, 23, 42)
					->size(110)
					->errorCorrection('H')
					->generate($ticketCode)
			);
		}

		$data = [
			'title'              => 'Digital Ticket - ' . $event->title,
			'transaction'        => $transaction,
			'event'              => $event,
			'ticket'             => $ticket,
			'participants'       => $transaction->participants,
			'participantQrcodes' => $participantQrcodes,
			'img'                => $img,
		];

		$pdf = Pdf::loadView('apps.ticket-pdf', $data);

		return $pdf->download('ticket-' . $transaction->transaction_code . '.pdf');
	}

    public function invoice(Transaction $transaction)
    {
        if ($transaction->status !== 'Paid') {
            return redirect('/');
        }

        $transaction->load([
            'event',
            'ticket',
            'participants',
            'paymentGatewayMethod.method',
            'paymentGatewayMethod.gateway',
        ]);

        return view('reports.invoice', [
            'transaction' => $transaction,
            'event' => $transaction->event,
            'ticket' => $transaction->ticket,
            'participant' => $transaction->participants,
            'paymentGatewayMethod' => $transaction->paymentGatewayMethod,
        ]);
    }

    public function downloadInvoice(Transaction $transaction)
    {
        if ($transaction->status !== 'Paid' || !$transaction->invoice_number) {
            return redirect('/');
        }

        $transaction->load([
            'event',
            'ticket',
            'participants',
            'paymentGatewayMethod.method',
            'paymentGatewayMethod.gateway',
        ]);

        $pdf = Pdf::loadView('reports.invoice-pdf', [
            'transaction' => $transaction,
            'event' => $transaction->event,
            'ticket' => $transaction->ticket,
            'participant' => $transaction->participants,
            'paymentGatewayMethod' => $transaction->paymentGatewayMethod,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download(
            $transaction->invoice_number . '.pdf'
        );
    }

    public function checkRegistration(Request $request)
    {
        $validated = $request->validate([
            'code'  => 'required|string|max:100',
            'email' => 'required|email',
        ]);

        $code  = trim($validated['code']);
        $email = strtolower(trim($validated['email']));

        // ─── 1. Transaction code ───
        $transaction = Transaction::with(['event', 'ticket', 'participants'])
            ->where('transaction_code', $code)
            ->first();

        if ($transaction) {
            if (strtolower($transaction->buyer_email) !== $email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak sesuai dengan data pemesanan.',
                ], 404);
            }

            // ✅ Set session
            $request->session()->put(
                'edit_access_' . $transaction->transaction_code,
                now()
            );

            return response()->json([
                'success' => true,
                'type'    => 'transaction',
                'data'    => [
                    'code'         => $transaction->transaction_code,
                    'name'         => $transaction->buyer_name,
                    'email'        => $transaction->buyer_email,
                    'phone'        => $transaction->buyer_phone,
                    'event_title'  => $transaction->event->title,
                    'event_slug'   => $transaction->event->slug,
                    'ticket_name'  => $transaction->ticket->ticket_name,
                    'quantity'     => $transaction->quantity,
                    'status'       => $transaction->status,
                    'status_valid' => $transaction->status === 'Paid',

                    // ✅ INI YANG DIUBAH — arahkan ke edit-participants
                    'edit_url'     => ($transaction->status === 'Paid' && $transaction->event->allow_edit_form == 1)
                        ? route('transaction.edit-participants', $transaction->transaction_code)
                        : null,
                ],
            ]);
        }

        // ─── 2. Ticket code ───
        $participant = TransactionParticipant::with([
                'transaction.event',
                'transaction.ticket',
            ])
            ->where('ticket_code', $code)
            ->first();

        if ($participant) {
            if (strtolower($participant->email) !== $email) {
                #Email tidak sesuai dengan data peserta
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan. Periksa kembali kode dan email Anda.',
                ], 404);
            }

            $parentCode = $participant->transaction->transaction_code;

            // ✅ Set session untuk transaction parent
            $request->session()->put('edit_access_' . $parentCode, now());

            return response()->json([
                'success' => true,
                'type'    => 'ticket',
                'data'    => [
                    'code'         => $participant->ticket_code,
                    'name'         => $participant->name,
                    'email'        => $participant->email,
                    'phone'        => $participant->phone,
                    'event_title'  => $participant->transaction->event->title,
                    'event_slug'   => $participant->transaction->event->slug,
                    'ticket_name'  => $participant->transaction->ticket->ticket_name,
                    'quantity'     => 1,
                    'status'       => $participant->transaction->status,
                    'status_valid' => $participant->transaction->status === 'Paid',

                    // ✅ Arahkan ke edit-participants pakai PARENT transaction code
                    'edit_url'     => ($participant->transaction->status === 'Paid'
                                        && $participant->transaction->event->allow_edit_form == 1)
                        ? route('transaction.edit-participants', $parentCode)
                        : null,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan. Periksa kembali kode dan email Anda.',
        ], 404);
    }

   public function editParticipants(Request $request, Transaction $transaction)
{
    // ─── Cek session flag ───
    $sessionKey = 'edit_access_' . $transaction->transaction_code;
    $verifiedAt = $request->session()->get($sessionKey);

    if (!$verifiedAt) {
        return redirect()
            ->route('home')
            ->with('error', 'Sesi verifikasi tidak ditemukan. Silakan cek registrasi ulang.');
    }

    $verifiedAt = \Carbon\Carbon::parse($verifiedAt);

    if ($verifiedAt->addMinutes(30)->isPast()) {
        $request->session()->forget($sessionKey);
        return redirect()
            ->route('home')
            ->with('error', 'Sesi verifikasi telah berakhir. Silakan cek registrasi ulang.');
    }

    if ($transaction->status !== 'Paid') {
        abort(403, 'Hanya transaksi dengan status Paid yang dapat diedit.');
    }

    if ($transaction->event->allow_edit_form != 1) {
        abort(403, 'Event ini tidak mengizinkan perubahan data peserta.');
    }

    // ─── Load relasi ───
    $transaction->load([
        'event',
        'ticket',
        'participants',
        'participants.forms',
        'participants.forms.form',
    ]);

    return view('transaction.edit-participants', compact('transaction'));
}

    public function updateParticipants(Request $request, Transaction $transaction)
{
    // ─── Cek session flag ───
    $sessionKey = 'edit_access_' . $transaction->transaction_code;
    $verifiedAt = $request->session()->get($sessionKey);

    if (!$verifiedAt || now()->diffInMinutes(\Carbon\Carbon::parse($verifiedAt)) > 30) {
        return response()->json([
            'success' => false,
            'message' => 'Sesi verifikasi telah berakhir. Silakan cek registrasi ulang.',
        ], 403);
    }

    if ($transaction->status !== 'Paid') {
        return response()->json([
            'success' => false,
            'message' => 'Hanya transaksi dengan status Paid yang dapat diedit.',
        ], 403);
    }

    if ($transaction->event->allow_edit_form != 1) {
        return response()->json([
            'success' => false,
            'message' => 'Event ini tidak mengizinkan perubahan data peserta.',
        ], 403);
    }

    // ─── Validasi input ───
    $request->validate([
        'forms'   => 'array',
        'files'   => 'array',
        'files.*' => 'nullable|file|max:10240',
    ]);

    // ─── Ambil semua form milik transaksi ini (guard + eager load) ───
    $allowedForms = TransactionForm::with(['form', 'participant'])
        ->whereIn('participant_id', $transaction->participants->pluck('id'))
        ->get()
        ->keyBy('id');

    DB::beginTransaction();

    try {
        // ─── 1. Update form values (non-file) ───
        foreach ($request->input('forms', []) as $formId => $value) {
            $form = $allowedForms->get((int) $formId);
            if (!$form) continue;

            $formType = $form->form->field_type ?? null;

            // Skip file/image — ditangani di loop kedua
            if (in_array($formType, ['file', 'image'])) continue;

            // Khusus checkbox: value array → simpan sebagai JSON
            if ($formType === 'checkbox' && is_array($value)) {
                $value = json_encode($value);
            }

            $form->form_value = $value;
            $form->save();
        }

        // ─── 2. Handle file/image replacement ───
        foreach ($request->file('files', []) as $formId => $file) {
            $form = $allowedForms->get((int) $formId);

            if (
                !$form
                || !($file instanceof \Illuminate\Http\UploadedFile)
                || !$file->isValid()
            ) {
                continue;
            }

            $formType = $form->form->field_type ?? null;
            if (!in_array($formType, ['file', 'image'])) continue;

            // ─── Hapus file lama ───
            if ($form->form_value) {
                $oldPath = public_path('storage/' . $form->form_value);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // ─── Tentukan folder berdasarkan tipe ───
            $folder = $formType === 'image' ? 'form-images' : 'form-files';

            // ─── Generate nama file baru ───
            $extension  = $file->getClientOriginalExtension();
            $ticketCode = $form->participant->ticket_code ?? ('form-' . $form->id);
            $filename   = $ticketCode . '-' . $form->form_id . '.' . $extension;

            // ─── Pastikan folder tujuan ada ───
            $destination = public_path('storage/' . $folder);
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // ─── Pindahkan file ───
            $file->move($destination, $filename);

            // ─── Update value di DB ───
            $form->form_value = $folder . '/' . $filename;
            $form->save();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data peserta berhasil diperbarui.',
        ]);

    } catch (\Throwable $e) {
        DB::rollBack();

        // Log::error('updateParticipants error: ' . $e->getMessage(), [
        //     'file' => $e->getFile(),
        //     'line' => $e->getLine(),
        // ]);

        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan: ' . $e->getMessage(),
        ], 500);
    }
}

}
