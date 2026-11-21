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
use App\Models\EventCategory;
use App\Models\TransactionForm;
use App\Models\TransactionParticipant;
use App\Services\Dashboard\OverviewService;
use Illuminate\Support\Facades\DB;
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
	public function index(OverviewService $overview)
	{
		$user = auth()->user();

		if ($user->hasRole('admin') && !$user->hasRole('organizer')) {
			return redirect('/administrator');
		}

		if (!$user->hasRole('organizer')) {
			return redirect('/dashboard/myevent');
		}

		return view('dashboard.page-dashboard', [
			'overview' => $overview->forOrganizer($user),
		]);
	}

	//My event
	public function myEvent(Request $request)
	{
		$search = $request->key;
		$status = $request->status;

		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}
		$user_id = auth()->user()->id;

		$transaction = Transaction::with(['event', 'ticket', 'participants.forms'])
			->where('user_id', $user_id)
			->orderByRaw('id DESC');

		if (!empty($search)) {
			$transaction = $transaction->whereHas('event', function ($query) use ($search) {
				$query->where('title', 'like', '%' . $search . '%');
			});
		}

		if (in_array($status, ['Paid', 'Pending', 'Unpaid', 'Expired', 'Cancelled', 'Refunded'], true)) {
			$transaction = $transaction->where('status', $status);
		}

		$transaction = $transaction->paginate(10)->withQueryString()->onEachSide(2);

		return view('dashboard.myevent', [
			'myevents' => $transaction,
			'activeStatus' => $status,
		]);
	}

	# detail transaksi (formulir)
	public function detailTransaction(Request $request)
	{
		$transaction_id = $request->transaction;
		$event_id = $request->event;

		$detail_event = Event::where('id', $event_id)->first();
		$detail_transaksi = Transaction::where('id', $transaction_id)->first();

		abort_if(!$detail_event || !$detail_transaksi, 404);
		$this->authorize('view', $detail_transaksi);

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
			$this->authorize('update', $form->transaction);

			$data = [
				'form_value' => $value
			];

			$form->update($data);
			$result = $form;
			# code...
		} else {
			$transaction = Transaction::findOrFail($trx_id);
			$this->authorize('update', $transaction);

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
		$transaction = Transaction::findOrFail($request->id);
		$this->authorize('delete', $transaction);

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
	public function manajemenEvent(Request $request, OverviewService $overview)
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

		$finance = $listEvent->getCollection()
			->mapWithKeys(function (Event $event) use ($overview) {
				return [$event->id => $overview->financeForEvent($event)];
			});

		return view('dashboard.manajemen-event', [
			'listEvent' => $listEvent,
			'categories' => EventCategory::all(),
			'finance' => $finance,
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
			->where('user_login_id', auth()->id())
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

		$this->authorize('viewParticipants', $event);


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
		->whereHas('transaction', function ($query) use ($event, $request) {
			$query->where('event_id', $event->id);
			// kalau ada request status, filter
			if ($request->has('status')) {
				$query->where('status', $request->status);
			}

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

		$dataTable->addColumn('ticket_code', function ($participant) {

			return $participant
				?->ticket_code ?? '-';

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

		$dataTable->addColumn(
			'participant_checkin_action',
			function ($participant) {

				return view(
					'dashboard.components.column-action-checkin',
					[
						'participant' => $participant,
					]
				)->render();

			}
		);


		$dataTable->addColumn(
			'participant_id',
			function ($participant) {
				return $participant->id;
			}
		);

		$dataTable->addColumn(
			'checked_in_at',
			function ($participant) {
				return $participant->checked_in_at?->toIso8601String();
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
				'participant_checkin_action',
			])

			->make(true);
	}

	public function participantDetail(Request $request)
	{
		$participant = TransactionParticipant::with([
			'transaction.event',
			'transaction.ticket',
			'transaction.paymentGatewayMethod.method',
			'forms.form',
		])->findOrFail($request->id);

		$this->authorize('view', $participant);

		$transaction = $participant->transaction;

		return response()->json([
			'participant' => [
				'id' => $participant->id,
				'name' => $participant->name,
				'email' => $participant->email,
				'phone' => $participant->phone,
				'ticket_code' => $participant->ticket_code,
				'checked_in_at' => $participant->checked_in_at?->toIso8601String(),
			],
			'transaction' => [
				'code' => $transaction?->transaction_code,
				'status' => $transaction?->status,
				'date' => $transaction?->created_at?->format('d M Y H:i'),
				'buyer_name' => $transaction?->buyer_name,
				'buyer_email' => $transaction?->buyer_email,
				'subtotal' => (float) ($transaction?->subtotal ?? 0),
				'grand_total' => (float) ($transaction?->grand_total ?? 0),
				'payment_method' => $transaction?->paymentGatewayMethod?->method?->name,
			],
			'event' => [
				'title' => $transaction?->event?->title,
				'slug' => $transaction?->event?->slug,
				'start_date' => $transaction?->event?->start_date?->format('d M Y'),
			],
			'ticket' => [
				'name' => $transaction?->ticket?->ticket_name,
			],
			'forms' => $participant->forms->map(function ($form) {
				return [
					'label' => $form->form?->field_label ?? 'Field',
					'type' => $form->form?->field_type,
					'value' => $form->form_value,
				];
			})->values(),
		]);
	}

	public function getCustomformParticipant(Request $request)
	{
		$event = Event::where('event_id', $request->event_id)->firstOrFail();
		$this->authorize('viewParticipants', $event);

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
		$cekEvent = Event::findOrFail($event_id);
		$this->authorize('viewFinance', $cekEvent);

		$today = Carbon::now()->format('Y-m-d');

		if ($cekEvent->end_date >= $today) {
			return response()->json(['error' => 'Event belum selesai, tidak bisa melakukan penarikan!']);
		} else {
			return response()->json(['success' => 'Ok!']);
		}
	}

	public function transactionReport(Request $request, OverviewService $overview)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();


		$finance = $listEvent->getCollection()
			->mapWithKeys(function (Event $event) use ($overview) {
				return [$event->id => $overview->financeForEvent($event)];
			});

		$totals = $overview->forOrganizer(auth()->user());

		return view('dashboard.page-transaction', [
			'listEvent' => $listEvent,
			'finance' => $finance,
			'totals' => $totals,
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
		$event = Event::findOrFail($eventId);
		$this->authorize('viewFinance', $event);

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

	public function participantEvent(string $event_id)
	{
		$event = Event::where('event_id', $event_id)->firstOrFail();
		$this->authorize('viewParticipants', $event);

		return view('dashboard.participant-event', [
			'event' => $event,
		]);
	}

	public function eventCheckinEvent(string $event_id)
	{
		$event = Event::where('event_id', $event_id)->firstOrFail();
		$this->authorize('checkIn', $event);

		return view('dashboard.checkin-event', [
			'event' => $event,
		]);
	}

	// public function getParticipantCheckin(Request $request)
	// {
	// 	if (!auth()->user()) {
	// 		return response()->json(['error' => 'Gagal!']);
	// 	}

	// 	$dataParticipant = Transaction::with(['event', 'ticket'])
	// 		->where('event_id', $request->id)
	// 		->where('status', 'Paid')
	// 		->orderByRaw('id DESC')
	// 		->get();

	// 	return DataTables::of($dataParticipant)
	// 		->addIndexColumn()
	// 		->addColumn('checkin_action', function ($dataParticipant) {
	// 			return view('dashboard.components.column-action-checkin')->with(['data' => $dataParticipant]);
	// 		})
	// 		->make(true);
	// }

	public function checkinProcess(Request $request)
	{
		$checkinTransaction = TransactionParticipant::find($request->id);

		if (!$checkinTransaction) {
			return response()->json(['error' => 'ID transaksi tidak ditemukan!'], 404);
		}

		$this->authorize('checkIn', $checkinTransaction);

		$result = DB::transaction(function () use ($request) {
			$participant = TransactionParticipant::whereKey($request->id)
				->lockForUpdate()
				->first();

			if (!$participant) {
				return ['success' => false, 'error' => 'ID transaksi tidak ditemukan!', 'status' => 404];
			}

			if (!empty($participant->checked_in_at)) {
				return ['success' => false, 'error' => 'Peserta sudah check-in!', 'status' => 422];
			}

			$participant->update([
				'checked_in_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'checked_in_by' => auth()->id(),
			]);

			app(\App\Services\AuditLogger::class)->log(
				'participant.checked_in',
				'Check-in peserta ' . ($participant->name ?: ('#' . $participant->id)) . '.',
				$participant,
				[
					'event_id' => $participant->transaction?->event_id,
					'transaction_id' => $participant->transaction_id,
				]
			);

			return ['success' => true, 'message' => 'Successfully checked in!!', 'status' => 200];
		});

		if (!$result['success']) {
			return response()->json(['error' => $result['error']], $result['status']);
		}

		return response()->json(['success' => $result['message']]);
	}

	public function withdraw(Request $request)
	{
		$request->validate([
			'event_id' => ['required', 'integer', 'exists:events,id'],
			'wdAmount' => ['required', 'integer', 'min:10000'],
		]);

		$user = auth()->user();

		if (!$user->bank || !$user->no_rekening) {
			return response()->json(['error' => 'Lengkapi data rekening bank terlebih dahulu!']);
		}

		$request->merge(['from_request' => 'withdraw']);

		return DB::transaction(function () use ($request, $user) {
			$dataEvent = Event::whereKey($request->event_id)
				->lockForUpdate()
				->firstOrFail();

			$this->authorize('withdraw', $dataEvent);

			if (!$dataEvent->end_date || $dataEvent->end_date >= today()) {
				return response()->json(['error' => 'Belum bisa melakukan penarikan!']);
			}

			$checkHistory = $this->getTransactionReport($request);

			if ((int) $request->wdAmount > (float) $checkHistory['danaBersih']) {
				return response()->json(['error' => 'Jumlah penarikan melebihi saldo tersedia!']);
			}

			WithdrawData::create([
				'event_id' => $dataEvent->id,
				'user_id' => $user->id,
				'rekening' => $user->no_rekening,
				'bank' => $user->bank,
				'amount' => (int) $request->wdAmount,
				'status' => 'Proses',
			]);

			$updateHistory = $this->getTransactionReport($request);

			return response()->json([
				'success' => 'Berhasil request penarikan dana!',
				'event_id' => $dataEvent->id,
				'saldo' => $updateHistory['danaBersih'],
			]);
		});
	}

	public function withdrawHistory(Request $request)
	{
		$event = Event::findOrFail($request->id);
		$this->authorize('viewFinance', $event);

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
		//Cek yang download pembuat event atau bukan
		$event = Event::where('event_id', $id)->firstOrFail();
		$event_id = $event->id;

		$this->authorize('viewParticipants', $event);

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
				$columnName = Coordinate::stringFromColumnIndex($customColumnIndex);
				$transactionForm = $forms->get($form->id);
				$value = $transactionForm?->form_value ?? '';

				if (in_array($form->field_type, ['image', 'file']) && $value) {
					// $value = "form-images/EVHW25DBSYJMHRTVO-001-25.png"
					$filename = basename($value); // ambil nama file saja

					$downloadUrl = route('file.download', $filename);
					$viewUrl     = route('file.view', $filename);

					// kolom download
					// $sheet->setCellValue(
					// 	$columnName . $row,
					// 	'=HYPERLINK("'.$downloadUrl.'","Download")'
					// );

					// kolom view (misalnya di kolom berikutnya)
					$sheet->setCellValue(
						Coordinate::stringFromColumnIndex($customColumnIndex) . $row,
						'=HYPERLINK("'.$viewUrl.'","Download")'
					);
				} else {
					$sheet->setCellValue($columnName . $row, $value);
				}


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
	public function article(Request $request)
	{
		$search = trim((string) $request->get('key', ''));
		$articles = Article::with(['category', 'type'])
			->where('user_id', auth()->id())
			->when($search !== '', fn ($query) => $query->where('title', 'like', '%' . $search . '%'))
			->latest('created_at')
			->paginate(12)
			->withQueryString();

		return view('dashboard.page-article', [
			'categories' => ArticleCategory::orderBy('category')->get(),
			'types' => ArticleType::orderBy('type_name')->get(),
			'articles' => $articles,
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
