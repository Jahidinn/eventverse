<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\CustomForm;
use App\Models\Transaction;
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

}
