<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\SnapToken;
use App\Models\CustomForm;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\TransactionEmail;
use App\Models\TransactionForm;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Diff\Diff;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionController extends Controller
{
	public function checkoutPreview(Request $request)
	{
		if (!$request->event || !$request->ticket) {
			return redirect('/search');
		}

		$detailEvent = Event::with('penyelenggara')->where('id', $request->event)->first();
		$detailTicket = Ticket::where('id', $request->ticket)->where('event_id', $request->event)->first();
		$customForms = CustomForm::where('event_id', $request->event)->get();

		if (!$detailEvent || !$detailTicket || !$customForms) {
			return redirect('/search');
		}

		return view('apps.transaction', [
			'detailEvent' => $detailEvent,
			'detailTicket' => $detailTicket,
			'customForms' => $customForms,
		]);
	}

	public function transaction(Request $request)
	{
		$validasi = Validator::make($request->all(), [
			'fullName' => 'required',
			'email' => 'required|email',
			'nomorHp' => 'required|min:10',
			'idEvent' => 'required',
			'idTicket' => 'required',
			'quantity' => 'required',
			'totalPrice' => 'required',
		]);

		if ($validasi->fails()) {
			return response()->json(['error' => $validasi->errors()->first()]);
		} else {
			$biayaAdmin = config('app.biaya_admin');

			$data = [
				'ticket_id' => $request->idTicket,
				'event_id' => $request->idEvent,
				'name' => $request->fullName,
				'phone' => $request->nomorHp,
				'email' => $request->email,
				'is_login' => $request->is_login,
				'user_login_id' => $request->user_login_id,
				'quantity' => $request->totalPrice / $request->quantity,
				'total_price' => $request->totalPrice + $biayaAdmin,
				'transaction_id' => $this->generateUniqueCode(),
				'status' => 'Unpaid',
			];

			//Keamanan beli tiket dari sisi backend
			$ticketQuota = Ticket::where('event_id', $request->idEvent)->first();
			$ticketUsed = count(Transaction::where('event_id', $request->idEvent)->where('status', '!=', 'Expired')->where('ticket_id', $request->idTicket)->get());
			$ticketAvailable = $ticketQuota->ticket_quota - $ticketUsed;
			$today = Carbon::now()->format('Y-m-d');

			if ($ticketAvailable <= 0) {
				return response()->json(['error' => 'Ticket habis gusy!']);
			} elseif ($ticketQuota->ticket_deadline < $today) {
				return response()->json(['error' => 'Ticket expired!']);
			}

			$transaction = Transaction::create($data);

			// insert custom form data
			if ($request->customForm) {
				if ($transaction || $request->customForm) {

					foreach ($request->customForm as $key => $customForm) {
						$dataForm[] = [
							"transaction_id" => $transaction->id,
							"form_id" => $key,
							"form_value" => $customForm
						];
					}
					TransactionForm::insert($dataForm);
				}
			}

			// Set your Merchant Server Key
			Config::$serverKey = config('midtrans.server_key');
			// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
			Config::$isProduction = config('midtrans.is_production');
			// Set sanitization on (default)
			Config::$isSanitized = true;
			// Set 3DS transaction for credit card to true
			Config::$is3ds = true;

			$params = array(
				'transaction_details' => array(
					'order_id' => $transaction->transaction_id,
					'gross_amount' => $transaction->total_price,
				),
				'customer_details' => array(
					'first_name' => $request->fullName,
					'last_name' => '',
					'email' => $request->email,
					'phone' => $request->nomorHp,
				),
			);

			$event = Event::with('penyelenggara')->find($request->idEvent);
			$ticket = Ticket::find($request->idTicket);

			$snapToken = Snap::getSnapToken($params);

			$dataToken = [
				'transaction_id' => $transaction->id,
				'token' => $snapToken,
			];
			SnapToken::create($dataToken);

			return response()->json(['transaction' => $transaction, 'token' => $snapToken, 'event' => $event, 'ticket' => $ticket]);
		}
	}

	public function generateUniqueCode()
	{
		do {
			$randomStr = 'EC-' . Str::random(10);
			$uniqueCode = strtoupper($randomStr);
		} while (Transaction::where("transaction_id", "=", $uniqueCode)->first());

		return $uniqueCode;
	}


	public function continueTransaction(Request $request)
	{
		$transaction = Transaction::find($request->id);
		$event = Event::with('penyelenggara')->find($transaction->event_id);
		$ticket = Ticket::find($transaction->ticket_id);
		$snapToken = SnapToken::where('transaction_id', $request->id)->first();

		if (!$transaction || !$event || !$ticket || !$snapToken) {
			return response()->json(['error' => 'Gagal!!']);
		}

		$now = Carbon::now();
		$postCreatedAt = new Carbon($transaction->created_at);

		//Jika transaksi lebih dari 12 jam maka tidak bisa di pay
		if ($now->diffInHours($postCreatedAt) > 12) {
			$editTransaction = Transaction::where('id', $request->id)->first();
			$editTransaction->update(['status' => 'Expired']);
			return response()->json(['expired' => 'Transaksi ini expired, gabisa dilanjutin guys!']);
		}

		return response()->json(['transaction' => $transaction, 'token' => $snapToken->token, 'event' => $event, 'ticket' => $ticket]);
	}


	public function callback(Request $request)
	{
		$serverKey = config('midtrans.server_key');
		$hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
		if ($hashed == $request->signature_key) {
			if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
				$transaction = Transaction::where('transaction_id', $request->order_id)->first();
				$transaction->update(['status' => 'Paid']);
			} elseif ($request->transaction_status == 'pending') {
				$transaction = Transaction::where('transaction_id', $request->order_id)->first();
				$transaction->update(['status' => 'Pending']);
			} else {
				// $request->transaction_status == 'expire'
				$transaction = Transaction::where('transaction_id', $request->order_id)->first();
				$transaction->update(['status' => 'Expired']);
			}

			$paymentMethod = Transaction::where('transaction_id', $request->order_id)->first();
			$paymentMethod->update(['payment_type' => $request->payment_type]);

			$transaction_code = $request->order_id;
			$this->sendEmail($transaction_code);
			return response()->json(['success' => 'Sukses kirim email'], 200);
		}
	}

	public function redirectInvoice($id)
	{
		// Render view tanpa langsung redirect
		return view('apps.redirect-to-invoice', ['invoiceId' => $id]);
		//return redirect('/event/invoice/' . $id);
	}


	public function invoice($id)
	{
		$transaction = Transaction::find($id);

		//jika tidak ada transaksi alihkan halaman (proteksi invoice)
		if (!$transaction) {
			return redirect('/');
		}

		$event = Event::with('penyelenggara')->find($transaction->event_id);
		$ticket = Ticket::find($transaction->ticket_id);

		return view('apps.invoice', [
			'transaction' => $transaction,
			'event' => $event,
			'ticket' => $ticket,
			'qrcode' => QrCode::size(200)->generate($transaction->transaction_id),
		]);
	}

	public function deleteTransaction(Request $request)
	{
		//Mengamankan delete dengan akses url ajax
		$transaksi = Transaction::where('id', $request->id)->where('email', $request->email)->first();
		if (!$transaksi) {
			return response()->json('Gagal');
		}
		//Proses delete
		$deleteTransaction = Transaction::where('id', $request->id)->where('is_login', 0)->where('user_login_id', 0)->where('status', 'Unpaid')->delete();
		//Delete snap token
		if ($deleteTransaction) {
			SnapToken::where('transaction_id', $request->id)->delete();
			TransactionForm::where('transaction_id', $request->id)->delete();
		}
		return response()->json('Sukses hapus');
	}

	public function sendEmail($transaction_code)
	{
		$transaction = Transaction::where('transaction_id', $transaction_code)->first();
		$event = Event::with('penyelenggara')->find($transaction->event_id);
		$ticket = Ticket::find($transaction->ticket_id);

		$mailData = [
			'subjek' => $transaction->status,
			'transaction' => $transaction,
			'event' => $event,
			'ticket' => $ticket,
		];

		Mail::to($transaction->email)->send(new TransactionEmail($mailData));

		return response()->json('Sukses kirim email');
	}
}
