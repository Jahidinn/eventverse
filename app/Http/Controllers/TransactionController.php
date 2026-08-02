<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\CustomForm;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TransactionService;

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
		]);

		if ($transaction->status === 'Paid') {
			return redirect()->route(
				'transaction.invoice',
				$transaction->transaction_code
			);
		}

		return view('transaction.show', [
			'transaction' => $transaction,
			'paymentDisplay' => $this->buildPaymentDisplay($transaction),
		]);
	}

	private function buildPaymentDisplay(Transaction $transaction): array
	{
		$payload = is_array($transaction->payment_payload)
			? $transaction->payment_payload
			: json_decode($transaction->payment_payload ?? '{}', true);

		$display = [
			'type' => 'default',
			'title' => $transaction->paymentGatewayMethod->name,
			'qr_value' => null,
			'va_number' => null,
			'deeplink_url' => null,
		];

		foreach ($payload['actions'] ?? [] as $action) {

			switch ($action['type'] ?? null) {

				case 'PRESENT_TO_CUSTOMER':

					$display['type'] = 'qris';
					$display['qr_value'] = $action['value'] ?? null;

					break;

				case 'DEEPLINK':

				case 'MOBILE_PAYMENT':

					$display['type'] = 'redirect';
					$display['deeplink_url'] = $action['value'] ?? null;

					break;
			}
		}

		if (
			isset($payload['account_number']) ||
			isset($payload['va_number'])
		) {

			$display['type'] = 'virtual_account';

			$display['va_number'] = $payload['account_number']
				?? $payload['va_number'];
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
			'redirect_url' => route('transaction.invoice', $transaction->transaction_code),
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

}
