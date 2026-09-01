<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Article;
use App\Models\SnapToken;
use App\Models\CustomForm;
use App\Models\ArticleType;
use App\Models\Transaction;
use App\Models\WithdrawData;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Models\TransactionForm;
use App\Models\TransactionParticipant;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DashboardController extends Controller
{
	public function index()
	{
		//Tambahkan data myevent, event, peserta, transaksi
		$user_id = auth()->user()->id;
		$totalPeserta = 0;
		$biayaAdmin = config('app.biaya_admin');
		$totalTransaksi = 0;

		$eventDiikuti = Transaction::where('user_id', $user_id)->count();
		$eventDibuat = Event::where('user_id', $user_id)->get();

		foreach ($eventDibuat as $event) {
			$jumlahPeserta = Transaction::where('event_id', $event->id)->where('status', 'Paid')->count();
			$transaksi = Transaction::where('event_id', $event->id)->where('status', 'Paid')->sum('grand_total');

			// Tambahkan jumlah peserta ke totalPeserta
			$totalPeserta += $jumlahPeserta;

			// Tambahkan jumlah transaksi ke totalTransaksi
			$totalTransaksi += $transaksi;
		}

		return view('dashboard.page-dashboard', [
			'eventDiikuti' => $eventDiikuti,
			'eventDibuat' => count($eventDibuat),
			'totalPeserta' => $totalPeserta,
			'totalTransaksi' => $totalTransaksi,
		]);
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
		$transaction = $transaction->paginate(10)->withQueryString()->onEachSide(2);

		return view('dashboard.myevent', [
			'myevents' => $transaction,
		]);
	}

	# detail transaksi (formulir)
	public function detailTransaction(Request $request)
	{
		$transaction_id = $request->transaction;
		$event_id = $request->event;

		$detail_event = Event::where('id', $event_id)->first();
		$detail_transaksi = Transaction::where('id', $transaction_id)->first();

		$data_form = CustomForm::where('event_id', $event_id)->get();
		$data = [];

		foreach ($data_form as $form) {
			$form_value = TransactionForm::where('transaction_id', $transaction_id)->where('form_id', $form->id)->first();

			$data[] = [
				'form_id' => $form->id ?? '',
				'form_name' => $form->form_name ?? '',
				'form_value' => $form_value->form_value ?? '',
				'form_value_id' => $form_value->id ?? '',
			];
		}

		return response()->json(['data' => $data, 'event' => $detail_event, 'trx' => $detail_transaksi]);
	}

	# EDIT FORM TRANSAKSI
	public function editFormTransaction(Request $request)
	{
		$value_id = $request->value_id;
		$form_id = $request->form_id;
		$trx_id = $request->trx_id;
		$value_id = $request->value_id;
		$value = $request->value;

		$form = TransactionForm::find($value_id);

		if ($form) {

			$data = [
				'form_value' => $value
			];

			$form->update($data);
			$result = $form;
			# code...
		} else {
			$data = [
				'form_id' => $form_id,
				'transaction_id' => $trx_id,
				'form_value' => $value,
			];

			$result = TransactionForm::create($data);
			# code...
		}


		return response()->json(['success' => 'Berhasil edit data!', 'data' => $result]);
	}


	public function deleteMyevent(Request $request)
	{
		//Proses delete
		$deleteTransaction = Transaction::where('id', $request->id)->whereIn('status', ['Unpaid', 'Pending'])->delete();
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

		$listEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();

		// if ($listEvent->isEmpty()) {
		// 	// Lakukan pengalihan URL atau tindakan lainnya
		// 	return Redirect::to('/dashboard/manajemen-event');
		// }

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

		$transaction = Transaction::with(['event', 'ticket'])
			->where('is_login', 1)
			->where('user_login_id', $request->user_id)
			->orderByRaw('id DESC')
			->get();

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
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();

		return view('dashboard.page-participant', [
			'dataEvent' => $dataEvent,
		]);
	}

	// public function getParticipant(Request $request)
	// {
	// 	if (!auth()->user()) {
	// 		return response()->json(['error' => 'Gagal!']);
	// 	}

	// 	$dataParticipant = Transaction::with(['event', 'ticket'])
	// 		->where('event_id', $request->id)
	// 		->orderByRaw('id DESC')
	// 		->get();

	// 	return DataTables::of($dataParticipant)
	// 		->addIndexColumn()
	// 		->addColumn('transaction_status', function ($dataParticipant) {
	// 			return view('dashboard.components.column-status')->with(['data' => $dataParticipant]);
	// 		})
	// 		->addColumn('transaction_date', function ($dataParticipant) {
	// 			return $dataParticipant->created_at->format('d M Y');
	// 		})
	// 		->addColumn('transaction_action', function ($dataParticipant) {
	// 			return view('dashboard.components.column-action-participant')->with(['data' => $dataParticipant]);
	// 		})
	// 		->make(true);
	// }

	public function getParticipant(Request $request)
	{
		if (!auth()->check()) {
			return response()->json([
				'error' => 'Gagal!'
			], 401);
		}

		/*
		|--------------------------------------------------------------------------
		| EVENT
		|--------------------------------------------------------------------------
		*/

		$event = Event::where(
			'event_id',
			$request->event_id
		)->first();

		if (!$event) {
			return response()->json([
				'error' => 'Event tidak ditemukan!'
			], 404);
		}


		/*
		|--------------------------------------------------------------------------
		| CUSTOM FORM EVENT
		|--------------------------------------------------------------------------
		*/

		$customForms = CustomForm::where(
			'event_id',
			$event->id
		)
			->orderBy('id')
			->get();


		/*
		|--------------------------------------------------------------------------
		| PARTICIPANT
		|--------------------------------------------------------------------------
		*/

		$dataParticipant = TransactionParticipant::with([
			'transaction.event.customForms',
			'transaction.ticket',
			'transaction.paymentGatewayMethod.gateway',
			'transaction.paymentGatewayMethod.method',
			'forms.form',
		])
		->whereHas('transaction', function ($query) use ($event) {
			$query->where('event_id', $event->id);
		})
		->latest();


		/*
		|--------------------------------------------------------------------------
		| DATATABLE
		|--------------------------------------------------------------------------
		*/

		$dataTable = DataTables::of($dataParticipant)

			->addIndexColumn();


		/*
		|--------------------------------------------------------------------------
		| PARTICIPANT NAME
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn('name', function ($participant) {

			return $participant->name ?? '-';

		});


		/*
		|--------------------------------------------------------------------------
		| PARTICIPANT EMAIL
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn('email', function ($participant) {

			return $participant->email ?? '-';

		});


		/*
		|--------------------------------------------------------------------------
		| PARTICIPANT PHONE
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn('phone', function ($participant) {

			return $participant->phone ?? '-';

		});


		/*
		|--------------------------------------------------------------------------
		| TICKET
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn('ticket_name', function ($participant) {

			return $participant
				->transaction
				?->ticket
				?->ticket_name ?? '-';

		});


		/*
		|--------------------------------------------------------------------------
		| CUSTOM FORM
		|--------------------------------------------------------------------------
		|
		| Setiap CustomForm menjadi satu kolom.
		|
		*/

		foreach ($customForms as $customForm) {

			$dataTable->addColumn(
				'form_' . $customForm->id,
				function ($participant) use ($customForm) {

					$transactionForm = $participant->forms
						->firstWhere(
							'form_id',
							$customForm->id
						);

					return $transactionForm?->form_value ?? '-';
				}
			);

		}


		/*
		|--------------------------------------------------------------------------
		| TRANSACTION CODE
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn(
			'transaction_id',
			function ($participant) {

				return $participant
					->transaction
					?->transaction_code ?? '-';

			}
		);
		


		/*
		|--------------------------------------------------------------------------
		| TRANSACTION DATE
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn(
			'transaction_date',
			function ($participant) {

				return $participant
					->transaction
					?->created_at
					?->format('d M Y')
					?? '-';

			}
		);


		/*
		|--------------------------------------------------------------------------
		| STATUS
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn(
			'transaction_status',
			function ($participant) {

				if (!$participant->transaction) {
					return '-';
				}

				return view(
					'dashboard.components.column-status',
					[
						'data' => $participant->transaction,
					]
				)->render();

			}
		);


		/*
		|--------------------------------------------------------------------------
		| ACTION
		|--------------------------------------------------------------------------
		*/

		$dataTable->addColumn(
			'transaction_action',
			function ($participant) {

				return view(
					'dashboard.components.column-action-participant',
					[
						'data' => $participant->transaction,
						'participant' => $participant,
					]
				)->render();

			}
		);


		/*
		|--------------------------------------------------------------------------
		| RESPONSE
		|--------------------------------------------------------------------------
		*/

		return $dataTable

			->rawColumns([
				'transaction_status',
				'transaction_action',
			])

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

	# Next boleh tarik walau event belum selesai
	public function checkEventDate(Request $request)
	{
		$event_id = $request->event_id;
		$cekEvent = Event::find($event_id);
		$today = Carbon::now()->format('Y-m-d');

		if ($cekEvent->end_date >= $today) {
			return response()->json(['error' => 'Event belum selesai, tidak bisa melakukan penarikan!']);
		} else {
			return response()->json(['success' => 'Ok!']);
		}
	}

	public function transactionReport(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();


		return view('dashboard.page-transaction', [
			'listEvent' => $listEvent,
		]);
	}

	// public function getTransactionReport(Request $request)
	// {
	// 	$event_id = $request->event_id;
	// 	//Biaya admin untuk customer
	// 	$biayaAdmin = config('app.biaya_admin');

	// 	//Total transaksi sukses
	// 	$totalPeserta = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->count();

	// 	//Total biaya admin
	// 	$biayaAdminPeserta = $biayaAdmin * $totalPeserta;

	// 	//Total dana sebelum dikurangi biaya admin
	// 	$totalTransaksi = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->sum('total_price');

	// 	//Pengurangan total dana dikurangi biaya admin dari user (Total dana masuk)
	// 	$totalDana = $totalTransaksi - $biayaAdminPeserta;

	// 	$totalTiket = Ticket::where('event_id', $event_id)->count();

	// 	//Mengkategorikan dana berdasarkan metode pembayaran

	// 	//Metode BANK TRANSFER (VA)
	// 	$qty_bank_tf = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->where('payment_type', 'bank_transfer')
	// 		->count();

	// 	$dana_bank_tf = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->where('payment_type', 'bank_transfer')
	// 		->sum('total_price') -
	// 		$biayaAdmin * $qty_bank_tf;

	// 	// Bank TF : 1.5% + 4500 per transaksi
	// 	$admin_bank_tf = 4500 * $qty_bank_tf + (1.5 / 100) * $dana_bank_tf;

	// 	$total_dana_bank_tf = $dana_bank_tf - $admin_bank_tf;

	// 	//Metode CREDIT CARD

	// 	$qty_credit_card = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->where('payment_type', 'credit_card')
	// 		->count();

	// 	$dana_credit_card = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->where('payment_type', 'credit_card')
	// 		->sum('total_price') -
	// 		$biayaAdmin * $qty_credit_card;

	// 	//Credit card : 3.5% + 2500 per transaksi
	// 	$admin_credit_card = 2500 * $qty_credit_card + (3.5 / 100) * $dana_credit_card;

	// 	$total_dana_credit_card = $dana_credit_card - $admin_credit_card;

	// 	//Metode Lain (Qris, Gopay, Shopeepay, Dana, Linkaja)

	// 	$qty_lain = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
	// 		->count();

	// 	$dana_lain = Transaction::where('event_id', $event_id)
	// 		->where('status', 'Paid')
	// 		->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
	// 		->sum('total_price') -
	// 		$biayaAdmin * $qty_lain;

	// 	// Pembayaran Lain : 3% pertransaksi / per tiket
	// 	$admin_lain = (3 / 100) * $dana_lain;

	// 	$total_dana_lain = $dana_lain - $admin_lain;

	// 	//Pengurangan biaya admin penyelenggara
	// 	$eventConnectFee = $admin_bank_tf + $admin_credit_card + $admin_lain;

	// 	// penarikan dana -> tambahkan yang statusnya hanya sukses dan berhasil, dan pending
	// 	$danaDitarik = WithdrawData::where('event_id', $event_id)->where(function ($query) {
	// 		$query->where('status', 'Sukses')
	// 			->orWhere('status', 'Proses');
	// 	})->sum('amount');

	// 	$danaBersih = $total_dana_bank_tf + $total_dana_credit_card + $total_dana_lain - $danaDitarik;

	// 	$data = [
	// 		'danaTotal' => $totalDana,
	// 		'peserta' => $totalPeserta,
	// 		'tiket' => $totalTiket,
	// 		'fee' => $eventConnectFee,
	// 		'danaDitarik' => $danaDitarik,
	// 		'danaBersih' => $danaBersih,
	// 	];

	// 	if ($request->from_request == 'withdraw') {
	// 		return $data;
	// 	} else {
	// 		return response()->json(['data' => $data]);
	// 	}
	// }

	public function getTransactionReport(Request $request)
	{
		$eventId = $request->event_id;

		/*
		|--------------------------------------------------------------------------
		| TRANSAKSI PAID
		|--------------------------------------------------------------------------
		*/

		$transactions = Transaction::with([
			'participants',
		])
			->where('event_id', $eventId)
			->where('status', 'Paid')
			->get();


		/*
		|--------------------------------------------------------------------------
		| TOTAL PESERTA
		|--------------------------------------------------------------------------
		|
		| Sekarang peserta berasal dari transaction_participants.
		|
		*/

		$totalPeserta = $transactions->sum(function ($transaction) {

			return $transaction->participants->count();

		});


		/*
		|--------------------------------------------------------------------------
		| TOTAL TIKET TERJUAL
		|--------------------------------------------------------------------------
		|
		| Jika 1 participant = 1 tiket.
		|
		*/

		$totalTiket = $totalPeserta;


		/*
		|--------------------------------------------------------------------------
		| DANA TOTAL
		|--------------------------------------------------------------------------
		|
		| Gunakan SUBTOTAL.
		|
		| subtotal = hak Event Creator
		| grand_total = total yang dibayar customer
		|
		*/

		$danaTotal = $transactions->sum(function ($transaction) {

			return (float) $transaction->subtotal;

		});


		/*
		|--------------------------------------------------------------------------
		| FEE EVENTVERSE
		|--------------------------------------------------------------------------
		|
		| Fee admin + payment gateway sudah dibebankan
		| kepada customer.
		|
		| Jadi tidak ada pengurangan fee dari subtotal.
		|
		*/

		$eventConnectFee = 0;


		/*
		|--------------------------------------------------------------------------
		| DANA DITARIK
		|--------------------------------------------------------------------------
		*/

		$danaDitarik = WithdrawData::where(
			'event_id',
			$eventId
		)
			->where(function ($query) {

				$query
					->where('status', 'Sukses')
					->orWhere('status', 'Proses');

			})
			->sum('amount');


		/*
		|--------------------------------------------------------------------------
		| DANA BERSIH
		|--------------------------------------------------------------------------
		|
		| Dana creator = subtotal transaksi Paid
		| dikurangi dana yang sudah ditarik.
		|
		*/

		$danaBersih =
			$danaTotal - $danaDitarik;


		/*
		|--------------------------------------------------------------------------
		| RESPONSE
		|--------------------------------------------------------------------------
		*/

		$data = [

			'danaTotal' =>
				$danaTotal,

			'peserta' =>
				$totalPeserta,

			'tiket' =>
				$totalTiket,

			'fee' =>
				$eventConnectFee,

			'danaDitarik' =>
				$danaDitarik,

			'danaBersih' =>
				$danaBersih,

		];


		/*
		|--------------------------------------------------------------------------
		| WITHDRAW
		|--------------------------------------------------------------------------
		*/

		if ($request->from_request === 'withdraw') {

			return $data;

		}


		/*
		|--------------------------------------------------------------------------
		| JSON
		|--------------------------------------------------------------------------
		*/

		return response()->json([
			'data' => $data
		]);
	}


	public function eventCheckin(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$dataEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
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

		if (empty($dataEvent) || !$user_id) {
			return response()->json(['error' => 'Pelanggaran!']);
		}

		//Proteksi ke 2 menghindari proses penarikan sebelum event selesai
		$today = Carbon::now()->format('Y-m-d');

		if ($dataEvent->end_date >= $today) {
			return response()->json(['error' => 'Belum bisa melakukan penarikan!']);
		}

		//Memanggil data report
		$checkHistory = $this->getTransactionReport($request);


		if ($request->wdAmount > $checkHistory['danaBersih']) {
			return response()->json(['error' => 'Pelanggaran!']);
		}

		//cek rekening bank dan bank
		if (!$request->wdRekening || !$request->wdBank) {
			return response()->json(['error' => 'Belum ada data rekening bank!']);
		}

		$data = [
			'event_id' => $request->event_id,
			'user_id' => $request->wdUserId,
			'rekening' => $request->wdRekening,
			'bank' => $request->wdBank,
			'amount' => $request->wdAmount,
			'status' => 'Proses',
		];

		$submitWithdraw = WithdrawData::create($data);

		if (!$submitWithdraw) {
			return response()->json(['error' => 'Gagal request withdraw!']);
		} else {
			$updateHistory = $this->getTransactionReport($request);
			return response()->json(['success' => 'Berhasil request penarikan dana!', 'event_id' => $request->event_id, 'saldo' => $updateHistory['danaBersih']]);
		}
	}

	public function withdrawHistory(Request $request)
	{
		$user_id = auth()->user()->id;
		$dataWD = WithdrawData::where('event_id', $request->id)->where('user_id', $user_id)->get();

		return DataTables::of($dataWD)
			->addIndexColumn()
			->addColumn('wd', function ($dataWD) {
				return number_format($dataWD->amount, 0, ',', '.');
			})
			->addColumn('tanggal', function ($dataWD) {
				return $dataWD->created_at->format('d M Y');
			})
			->addColumn('wd-status', function ($dataWD) {
				return view('dashboard.components.column-status-withdraw')->with(['data' => $dataWD]);
			})
			->make(true);
	}

	public function downloadExcel($id)
	{
		$user_id = auth()->user()->id;

		//Cek yang download pembuat event atau bukan
		$event = Event::where('event_id', $id)->first();
		$event_id = $event->id;

		if ($event->user_id != $user_id) {

			//Jika bukan jangan lanjutkan download
			abort(404, 'Resource not found.');
		}

		// ==========================================================================
		// DATA PARTICIPANT
		// ==========================================================================

		$participants = TransactionParticipant::with([
			'transaction.event',
			'transaction.ticket',
			'forms.form',
		])
			->whereHas('transaction', function ($query) use ($event_id) {
				$query->where('event_id', $event_id)->where('status', 'Paid');
			})
			->get()
			->sortBy(function ($participant) {
				return $participant->transaction?->ticket_id ?? 0;
			})
			->values();


		// ==========================================================================
		// DATA CUSTOM FORM
		// ==========================================================================

		$customForms = CustomForm::where('event_id', $event_id)
			->orderBy('id')
			->get();


		// ==========================================================================
		// TRANSACTION REPORT
		// ==========================================================================

		$dashboardController = new DashboardController();

		$transaksi = $dashboardController->getTransactionReport(
			app('request')->merge([
				'event_id' => $event_id,
				'from_request' => 'withdraw',
			])
		);

		$dataTransaksi = $transaksi;


		// ==========================================================================
		// DATA REKAP
		// ==========================================================================

		$danaTotal = number_format(
			$dataTransaksi['danaTotal'],
			0,
			',',
			'.'
		);

		$danaDitarik = number_format(
			$dataTransaksi['danaDitarik'],
			0,
			',',
			'.'
		);

		$fee = number_format(
			$dataTransaksi['fee'],
			0,
			',',
			'.'
		);

		$danaBersih = number_format(
			$dataTransaksi['danaBersih'],
			0,
			',',
			'.'
		);


		// ==========================================================================
		// JUMLAH PESERTA
		// ==========================================================================

		$peserta = number_format(
			$participants->count(),
			0,
			',',
			'.'
		);


		// ==========================================================================
		// JUMLAH TIKET
		// ==========================================================================

		$tiket = number_format(
			$dataTransaksi['tiket'],
			0,
			',',
			'.'
		);

		// ==========================================================================
		// MEMBUAT OBJECT SPREADSHEET
		// ==========================================================================

		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();


		// ==========================================================================
		// STYLE AWAL
		// ==========================================================================

		$sheet->getRowDimension(1)->setRowHeight(10);
		$sheet->getRowDimension(2)->setRowHeight(30);
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getRowDimension(4)->setRowHeight(25);
		$sheet->getRowDimension(5)->setRowHeight(20);

		$sheet->getColumnDimension('A')->setWidth(3);


		// ==========================================================================
		// KOLOM
		// ==========================================================================

		$startColumnForm = 10; // J

		$lastColumnIndex =
			$startColumnForm + count($customForms) - 1;


		// Helper untuk mengubah nomor kolom menjadi huruf.
		// Tidak lagi menggunakan chr() karena bisa bermasalah
		// kalau custom form lebih dari 26 kolom.

		$lastColumn = Coordinate::stringFromColumnIndex(
			$lastColumnIndex
		);


		// ==========================================================================
		// BARIS
		// ==========================================================================

		$row = 6;

		$lastRow = count($participants) + $row - 1;


		// ==========================================================================
		// MERGE
		// ==========================================================================

		$sheet->mergeCells(
			'B2:' . $lastColumn . '2'
		);

		$sheet->mergeCells(
			'B3:C3'
		);

		$sheet->mergeCells(
			'B4:C4'
		);

		$sheet->mergeCells(
			'D3:E3'
		);

		$sheet->mergeCells(
			'D4:E4'
		);

		$sheet->mergeCells(
			'F3:G3'
		);

		$sheet->mergeCells(
			'F4:G4'
		);

		$sheet->mergeCells(
			'H3:' . $lastColumn . '4'
		);


		// ==========================================================================
		// TITLE EVENT
		// ==========================================================================

		$sheet->setCellValue(
			'B2',
			$event->title
		);


		// ==========================================================================
		// REKAP
		// ==========================================================================

		$sheet->setCellValue(
			'B3',
			'Total peserta (' . $peserta . ')'
		);

		$sheet->setCellValue(
			'B4',
			'Total tiket (' . $tiket . ')'
		);

		$sheet->setCellValue(
			'D3',
			'Total pemasukan (Rp ' . $danaTotal . ')'
		);

		$sheet->setCellValue(
			'D4',
			'Total pencairan (Rp ' . $danaDitarik . ')'
		);

		$sheet->setCellValue(
			'F3',
			'Biaya layanan (Rp ' . $fee . ')'
		);

		$sheet->setCellValue(
			'F4',
			'Saldo Akhir (Rp ' . $danaBersih . ')'
		);


		// ==========================================================================
		// HEADER
		// ==========================================================================

		$sheet->setCellValue(
			'B5',
			'Ticket Pendaftaran'
		);

		$sheet->setCellValue(
			'C5',
			'ID'
		);

		$sheet->setCellValue(
			'D5',
			'Nama'
		);

		$sheet->setCellValue(
			'E5',
			'Email'
		);

		$sheet->setCellValue(
			'F5',
			'Tlp'
		);

		$sheet->setCellValue(
			'G5',
			'Biaya'
		);

		$sheet->setCellValue(
			'H5',
			'Status'
		);

		$sheet->setCellValue(
			'I5',
			'Pembayaran'
		);


		// ==========================================================================
		// HEADER CUSTOM FORM
		// ==========================================================================

		$headerCustom = $startColumnForm;

		foreach ($customForms as $form) {

			$columnName = Coordinate::stringFromColumnIndex(
				$headerCustom
			);

			$sheet->setCellValue(
				$columnName . '5',
				$form->field_label ?? ''
			);

			$headerCustom++;
		}


		// ==========================================================================
		// LOOP PESERTA
		// ==========================================================================

		foreach ($participants as $participant) {

			/*
			|--------------------------------------------------------------------------
			| TRANSACTION
			|--------------------------------------------------------------------------
			*/

			$transaction = $participant->transaction;


			/*
			|--------------------------------------------------------------------------
			| TICKET
			|--------------------------------------------------------------------------
			*/

			$ticket = $transaction?->ticket;


			/*
			|--------------------------------------------------------------------------
			| HARGA PESERTA
			|--------------------------------------------------------------------------
			|
			| Harga participant berasal dari harga tiket.
			|
			| Jangan:
			|
			| total_price - biaya_admin
			|
			| karena total_price/grand_total adalah transaksi customer.
			|
			*/

			$price = (float) (
				$ticket?->price ?? 0
			);


			/*
			|--------------------------------------------------------------------------
			| DATA DASAR
			|--------------------------------------------------------------------------
			*/

			$sheet->setCellValue(
				'B' . $row,
				$ticket?->ticket_name ?? '-'
			);


			/*
			|--------------------------------------------------------------------------
			| TRANSACTION CODE
			|--------------------------------------------------------------------------
			|
			| TransactionParticipant sudah punya transaction_code,
			| tetapi transaction_id tetap bisa digunakan sebagai ID transaksi.
			|
			*/

			$sheet->setCellValue(
				'C' . $row,
				$participant->transaction_code
					?? $transaction?->transaction_code
					?? '-'
			);


			/*
			|--------------------------------------------------------------------------
			| PARTICIPANT
			|--------------------------------------------------------------------------
			*/

			$sheet->setCellValue(
				'D' . $row,
				$participant->name ?? '-'
			);

			$sheet->setCellValue(
				'E' . $row,
				$participant->email ?? '-'
			);

			$sheet->setCellValue(
				'F' . $row,
				$participant->phone ?? '-'
			);

			$sheet->getStyle(
				'F' . $row
			)
				->getNumberFormat()
				->setFormatCode('0');


			/*
			|--------------------------------------------------------------------------
			| HARGA TIKET
			|--------------------------------------------------------------------------
			*/

			$sheet->setCellValue(
				'G' . $row,
				$price
			);

			$sheet->getStyle(
				'G' . $row
			)
				->getNumberFormat()
				->setFormatCode('#,##0');


			/*
			|--------------------------------------------------------------------------
			| STATUS TRANSAKSI
			|--------------------------------------------------------------------------
			*/

			$sheet->setCellValue(
				'H' . $row,
				$transaction?->status ?? '-'
			);


			/*
			|--------------------------------------------------------------------------
			| PAYMENT
			|--------------------------------------------------------------------------
			*/

			$paymentMethod = $transaction?->paymentGatewayMethod?->method;

			$paymentName =
				$paymentMethod?->name
				?? $transaction?->payment_type
				?? '-';


			$sheet->setCellValue(
				'I' . $row,
				$paymentName
			);


			/*
			|--------------------------------------------------------------------------
			| CUSTOM FORM
			|--------------------------------------------------------------------------
			|
			| forms sudah di-load dari participant.
			|
			*/


			$customColumnIndex = $startColumnForm;

			$forms = $participant->forms->keyBy('form_id');

			foreach ($customForms as $form) {

				$columnName = Coordinate::stringFromColumnIndex(
					$customColumnIndex
				);

				$transactionForm = $forms->get($form->id);

				$value = $transactionForm?->form_value ?? '';

				$sheet->setCellValue(
					$columnName . $row,
					$value
				);

				$customColumnIndex++;
			}


			$row++;
		}

		// ==========================================================================
		// STYLING
		// ==========================================================================

		$sheet->getStyle(
			'B2:' . $lastColumn . $lastRow
		)
			->getAlignment()
			->setVertical(
				Alignment::VERTICAL_CENTER
			);


		$sheet->getStyle(
			'B2:' . $lastColumn . $lastRow
		)
			->getBorders()
			->getInside()
			->setBorderStyle(
				Border::BORDER_DASHED
			)
			->setColor(
				new Color('c4c4c4')
			);


		$sheet->getStyle(
			'B2:' . $lastColumn . $lastRow
		)
			->getBorders()
			->getOutline()
			->setBorderStyle(
				Border::BORDER_MEDIUM
			);


		// ==========================================================================
		// HEADER EVENT
		// ==========================================================================

		$sheet->getStyle(
			'B2:' . $lastColumn . '2'
		)
			->getFill()
			->setFillType(
				Fill::FILL_SOLID
			)
			->getStartColor()
			->setARGB('4F81BD');


		$sheet->getStyle(
			'B2:' . $lastColumn . '2'
		)
			->getAlignment()
			->setHorizontal('center');


		// ==========================================================================
		// HEADER TABLE
		// ==========================================================================

		$sheet->getStyle(
			'B5:' . $lastColumn . '5'
		)
			->getFill()
			->setFillType(
				Fill::FILL_SOLID
			)
			->getStartColor()
			->setARGB('9ee8ff');


		$sheet->getStyle(
			'B5:' . $lastColumn . '5'
		)
			->getBorders()
			->getOutline()
			->setBorderStyle(
				Border::BORDER_MEDIUM
			)
			->setColor(
				new Color('000000')
			);


		// ==========================================================================
		// REKAP
		// ==========================================================================

		$sheet->getStyle(
			'B3:' . $lastColumn . '4'
		)
			->getAlignment()
			->setHorizontal('left');


		// ==========================================================================
		// FONT REKAP
		// ==========================================================================

		$sheet->getStyle(
			'B2:' . $lastColumn . '2'
		)
			->getFont()
			->setBold(true)
			->setSize(12);


		$sheet->getStyle(
			'B3:' . $lastColumn . '4'
		)
			->getFont()
			->setBold(true)
			->setSize(11)
			->getColor()
			->setRGB('FFFFFF');


		$sheet->getStyle(
			'B3:' . $lastColumn . '4'
		)
			->getFill()
			->setFillType(
				Fill::FILL_SOLID
			)
			->getStartColor()
			->setARGB('808080');


		// ==========================================================================
		// ALIGNMENT DATA
		// ==========================================================================

		$sheet->getStyle(
			'B5:' . $lastColumn . $lastRow
		)
			->getAlignment()
			->setHorizontal('left');


		// ==========================================================================
		// ZEBRA ROW
		// ==========================================================================

		for ($excelRow = 6; $excelRow <= $lastRow; $excelRow++) {

			if ($excelRow % 2 === 0) {

				$sheet->getStyle(
					'B' . $excelRow . ':' . $lastColumn . $excelRow
				)
					->getFill()
					->setFillType(
						Fill::FILL_SOLID
					)
					->getStartColor()
					->setARGB('ebeded');
			}
		}


		// ==========================================================================
		// COLUMN WIDTH
		// ==========================================================================

		foreach ($sheet->getColumnIterator() as $column) {

			$columnIndex = $column->getColumnIndex();

			if ($columnIndex === 'A') {
				continue;
			}


			if (
				$columnIndex === 'B' ||
				$columnIndex === 'C'
			) {

				$maxWidth = 26;

			} else {

				$maxWidth = 23;
			}


			$sheet->getColumnDimension(
				$columnIndex
			)->setWidth($maxWidth);


			/*
			|--------------------------------------------------------------------------
			| FONT
			|--------------------------------------------------------------------------
			*/

			foreach ($sheet->getRowIterator() as $excelRow) {

				$rowIndex =
					$excelRow->getRowIndex();

				$cell =
					$sheet->getCell(
						$columnIndex . $rowIndex
					);


				if ($rowIndex === 2) {

					$sheet->getStyle(
						$cell->getCoordinate()
					)
						->getFont()
						->setBold(true)
						->setSize(12);
				}


				if ($rowIndex === 5) {

					$sheet->getStyle(
						$cell->getCoordinate()
					)
						->getFont()
						->setBold(true)
						->setSize(12);
				}
			}
		}


		// ==========================================================================
		// DOWNLOAD
		// ==========================================================================

		$writer = new Xlsx(
			$spreadsheet
		);

		$filename =
			'Data peserta-' .
			time() .
			'.xlsx';


		header(
			'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		header(
			'Content-Disposition: attachment;filename="' .
			$filename .
			'"'
		);

		header(
			'Cache-Control: max-age=0'
		);


		$writer->save(
			'php://output'
		);

		exit;

		//return response()->json(['success' => 'Sukses download']);
	}

	# ARTICLE
	public function article()
	{
		# Query mengambil data kategori dan jenis artikel 
		$kategori = ArticleCategory::all();
		$type = ArticleType::all();

		return view('dashboard.page-article', [
			'categories' => $kategori,
			'type' => $type,
		]);
	}

	public function getArticle()
	{
		$user_id = auth()->user()->id;

		$article = Article::with(['user'])
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($article)
			->addIndexColumn()
			->addColumn('blog-title', function ($article) {
				return view('dashboard.admin-dashboard.components.article-title')->with(['data' => $article]);
			})
			->addColumn('action', function ($article) {
				return view('dashboard.admin-dashboard.components.article-action')->with(['data' => $article]);
			})
			->make(true);
	}
}
