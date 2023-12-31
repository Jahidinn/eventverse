<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\SnapToken;
use App\Models\CustomForm;
use App\Models\Transaction;
use App\Models\WithdrawData;
use Illuminate\Http\Request;
use App\Models\TransactionForm;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
	public function index()
	{
		return view('dashboard.index');
	}

	//My event
	public function myEvent(Request $request)
	{
		$search = $request->key;

		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}
		$user_id = auth()->user()->id;
		$transaction = Transaction::with(['event', 'ticket'])
			->where('is_login', 1)
			->where('user_login_id', $user_id)
			->orderByRaw('id DESC');


		if (!empty($search)) {
			$transaction = $transaction->whereHas('event', function ($query) use ($search) {
				$query->where('title', 'like', '%' . $search . '%');
			});
		}
		$transaction = $transaction->paginate(2)->withQueryString();

		return view('dashboard.myevent', [
			'myevents' => $transaction,
		]);
	}

	public function deleteMyevent(Request $request)
	{
		//Proses delete
		$deleteTransaction = Transaction::where('id', $request->id)->where('status', 'Unpaid')->delete();
		//Delete snap token dan data custom form
		if ($deleteTransaction) {
			SnapToken::where('transaction_id', $request->id)->delete();
			TransactionForm::where('transaction_id', $request->id)->delete();
		}
		return response()->json(['success' => 'Data registrasi berhasil dihapus!']);
	}

	//Manajemen event
	public function manajemenEvent(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')->where('user_id', $user_id)->paginate(2)->withQueryString();
		return view('dashboard.manajemen-event', [
			'listEvent' => $listEvent
		]);
	}

	//Tidak dipakai (Dipakai ketika menggunakan ajax)
	public function getMyEvent(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}
		$transaction = Transaction::with(['event', 'ticket'])->where('is_login', 1)->where('user_login_id', $request->user_id)->orderByRaw('id DESC')->get();
		return DataTables::of($transaction)
			->addIndexColumn()
			->addColumn('event', function ($transaction) {
				$event = $transaction->event->title;
				$ticket = $transaction->ticket->ticket_name;
				return view('dashboard.components.column-myevent-event')->with(['event' => $event, 'ticket' => $ticket]);
			})
			->addColumn('transaction_status', function ($transaction) {
				return view('dashboard.components.column-myevent-status')->with(['data' => $transaction]);
			})
			->addColumn('action', function ($transaction) {
				return view('dashboard.components.column-myevent')->with(['data' => $transaction]);
			})
			->make(true);
	}
	//Tidak dipakai (Dipakai ketika menggunakan ajax)

	public function participant(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$dataEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->paginate(2)
			->withQueryString();

		return view('dashboard.page-participant', [
			'dataEvent' => $dataEvent,
		]);
	}

	public function getParticipant(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}

		$dataParticipant = Transaction::with(['event', 'ticket'])
			->where('event_id', $request->id)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataParticipant)
			->addIndexColumn()
			->addColumn('transaction_status', function ($dataParticipant) {
				return view('dashboard.components.column-status')->with(['data' => $dataParticipant]);
			})
			->addColumn('transaction_action', function ($dataParticipant) {
				return view('dashboard.components.column-action-participant')->with(['data' => $dataParticipant]);
			})
			->make(true);
	}

	public function getCustomformParticipant(Request $request)
	{
		$customForm = CustomForm::where('event_id', $request->event_id)->get();

		foreach ($customForm as $form) {
			$dataForm = TransactionForm::with(['transaction'])
				->where('form_id', $form->id)
				->where('transaction_id', $request->id)
				->first();

			$data[] = [
				'nama_form' => strtr($form->form_name, ['*' => '']),
				'form_value' => $dataForm ? $dataForm->form_value : '',
			];
		}

		return response()->json(['data' => $data]);
	}

	public function transactionReport(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')->where('user_id', $user_id)->paginate(2)->withQueryString();


		return view('dashboard.page-transaction-report', [
			'listEvent' => $listEvent,
		]);
	}

	public function getTransactionReport(Request $request)
	{
		$event_id = $request->event_id;
		//Biaya admin untuk customer
		$biayaAdmin = config('app.biaya_admin');

		//Total transaksi sukses
		$totalPeserta = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->count();

		//Total biaya admin
		$biayaAdminPeserta = $biayaAdmin * $totalPeserta;

		//Total dana sebelum dikurangi biaya admin
		$totalTransaksi = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->sum('total_price');

		//Pengurangan total dana dikurangi biaya admin dari user (Total dana masuk)
		$totalDana = $totalTransaksi - $biayaAdminPeserta;

		$totalTiket = Ticket::where('event_id', $event_id)->count();

		//Mengkategorikan dana berdasarkan metode pembayaran
		//Metode BANK TRANSFER (VA)
		$qty_bank_tf = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'bank_transfer')
			->count();

		$dana_bank_tf = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'bank_transfer')
			->sum('total_price') -
			$biayaAdmin * $qty_bank_tf;

		// Bank TF : 1.5% + 4500 per transaksi
		$admin_bank_tf = 4500 * $qty_bank_tf + (1.5 / 100) * $dana_bank_tf;

		$total_dana_bank_tf = $dana_bank_tf - $admin_bank_tf;

		//Metode CREDIT CARD

		$qty_credit_card = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'credit_card')
			->count();

		$dana_credit_card = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'credit_card')
			->sum('total_price') -
			$biayaAdmin * $qty_credit_card;

		//Credit card : 3.5% + 2500 per transaksi
		$admin_credit_card = 2500 * $qty_credit_card + (3.5 / 100) * $dana_credit_card;

		$total_dana_credit_card = $dana_credit_card - $admin_credit_card;

		//Metode Lain (Qris, Gopay, Shopeepay, Dana, Linkaja)

		$qty_lain = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
			->count();

		$dana_lain = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
			->sum('total_price') -
			$biayaAdmin * $qty_lain;

		// Pembayaran Lain : 3% pertransaksi / per tiket
		$admin_lain = (3 / 100) * $dana_lain;

		$total_dana_lain = $dana_lain - $admin_lain;

		//Pengurangan biaya admin penyelenggara
		$eventConnectFee = $admin_bank_tf + $admin_credit_card + $admin_lain;

		// penarikan dana;
		$danaDitarik = WithdrawData::where('event_id', $event_id)->sum('amount');

		$danaBersih = $total_dana_bank_tf + $total_dana_credit_card + $total_dana_lain - $danaDitarik;

		$data = [
			'danaTotal' => $totalDana,
			'peserta' => $totalPeserta,
			'tiket' => $totalTiket,
			'fee' => $eventConnectFee,
			'danaDitarik' => $danaDitarik,
			'danaBersih' => $danaBersih,
		];
		return response()->json(['data' => $data]);
	}

	public function eventCheckin(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$dataEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->paginate(2)
			->withQueryString();

		return view('dashboard.page-checkin-event', [
			'dataEvent' => $dataEvent,
		]);
	}

	public function getParticipantCheckin(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}

		$dataParticipant = Transaction::with(['event', 'ticket'])
			->where('event_id', $request->id)
			->where('status', 'Paid')
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataParticipant)
			->addIndexColumn()
			->addColumn('checkin_action', function ($dataParticipant) {
				return view('dashboard.components.column-action-checkin')->with(['data' => $dataParticipant]);
			})
			->make(true);
	}

	public function checkinProcess(Request $request)
	{

		$timestamp = Carbon::now()->timestamp;
		$tanggalCheckin = Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s');

		$checkinTransaction = Transaction::where('transaction_id', $request->id)->first();

		//Jika Tidak ada ID
		if (!$checkinTransaction) {
			return response()->json(['error' => 'Masukan ID dengan benar!']);
		}

		if (!empty($checkinTransaction->checkin)) {
			return response()->json(['error' => 'Sudah di check in guys!']);
		}

		//Jika ID ada
		$checkinTransaction->update(['checkin' => $tanggalCheckin]);
		return response()->json(['success' => 'Berhasil checkin!']);
	}

	public function withdraw(Request $request)
	{
		//Proteksi siapa yang mencairkan
		$user_id = auth()->user()->id;
		$dataEvent = Event::where('id', $request->event_id)->where('user_id', $user_id)->first();

		if (empty($dataEvent)) {
			return response()->json(['error' => 'Pelanggaran!']);
		}

		//Memanggil data report
		$transactionReportData = $this->getTransactionReport($request);

		//dd($transactionReportData);

		$data = [
			'event_id' => $request->event_id,
			'user_id' => $request->wdUserId,
			'rekening' => $request->wdRekening,
			'amount' => $request->wdAmount,
			'status' => 'Proses',
		];

		$submitWithdraw = WithdrawData::create($data);

		if (!$submitWithdraw) {
			return response()->json(['error' => 'Gagal request withdraw!']);
		}
		return response()->json(['success' => 'Berhasil request penarikan dana!']);
	}
}
