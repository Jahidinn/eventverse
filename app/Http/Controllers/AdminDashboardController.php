<?php

namespace App\Http\Controllers;

use App\Mail\WithdrawEmail;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleType;
use Svg\Tag\Rect;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\EventVisitor;
use App\Models\Organisation;
use App\Models\WithdrawData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\FuncCall;
use App\Services\EmailService;
use App\Services\AuditLogger;
use App\Services\Dashboard\OverviewService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardController extends Controller
{
	protected EmailService $emailService;
	protected AuditLogger $auditLogger;
	public function __construct(EmailService $emailService, AuditLogger $auditLogger)
	{
		$this->emailService = $emailService;
		$this->auditLogger = $auditLogger;
	}

	public function index(OverviewService $overview)
	{
		return view('dashboard.admin-dashboard.admin-index', [
			'overview' => $overview->forAdmin(),
		]);
	}

	public function payments(Request $request, OverviewService $overview)
	{
		$environment = config('xendit.environment', 'sandbox') === 'production' ? 'production' : 'sandbox';
		$search = trim((string) $request->get('key', ''));

		$query = Transaction::with(['event', 'ticket', 'paymentGatewayMethod.method'])
			->where('environment', $environment);

		if ($request->filled('status')) {
			$query->where('status', $request->status);
		}

		if ($search !== '') {
			$query->where(function ($inner) use ($search) {
				$inner->where('transaction_code', 'like', '%' . $search . '%')
					->orWhere('buyer_name', 'like', '%' . $search . '%')
					->orWhere('buyer_email', 'like', '%' . $search . '%')
					->orWhereHas('event', function ($event) use ($search) {
						$event->where('title', 'like', '%' . $search . '%');
					});
			});
		}

		$transactions = $query->latest('created_at')
			->paginate(20)
			->withQueryString();

		return view('dashboard.admin-dashboard.admin-payments', [
			'overview' => $overview->forAdmin(),
			'transactions' => $transactions,
			'environment' => $environment,
			'search' => $search,
		]);
	}

	public function withdrawRequest(Request $request)
	{
		$stats = WithdrawData::query()
			->selectRaw('status, COUNT(*) as total_count, SUM(amount) as total_amount')
			->groupBy('status')
			->get()
			->keyBy('status');

		return view('dashboard.admin-dashboard.admin-wd-request', [
			'stats' => $stats,
		]);
	}

	public function withdrawRequestData(Request $request)
	{

		$dataWdRequest = WithdrawData::with(['event', 'user'])
			->where('status', 'LIKE', '%' . $request->status . '%')
			->where('status', 'Proses')
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataWdRequest)
			->addIndexColumn()
			->addColumn('admin_wd_user', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-user')->with(['data' => $dataWdRequest]);
			})
			->addColumn('admin_wd_amount', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-amount')->with(['data' => $dataWdRequest]);
			})
			->addColumn('admin_wd_status', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-status')->with(['data' => $dataWdRequest]);
			})
			->addColumn('admin_wd_action', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-action')->with(['data' => $dataWdRequest]);
			})
			->make(true);
	}

	public function tolakWithdraw(Request $request)
	{
		$request->validate([
			'id' => ['required', 'integer', 'exists:withdraw_data,id'],
			'catatan' => ['required', 'string', 'max:255'],
		]);

		$withdrawal = DB::transaction(function () use ($request) {
			$withdrawal = WithdrawData::whereKey($request->id)->lockForUpdate()->firstOrFail();

			if ($withdrawal->status !== 'Proses') {
				return null;
			}

			$withdrawal->update([
				'status' => 'Gagal',
				'catatan' => $request->catatan,
			]);

			return $withdrawal;
		});

		if (!$withdrawal) {
			return response()->json(['error' => 'Request ini sudah diproses sebelumnya!']);
		}

		$this->emailService->sendWithdraw($withdrawal->load(['event', 'user']));

		$this->auditLogger->log(
			'withdrawal.rejected',
			'Menolak penarikan #' . $withdrawal->id . '.',
			$withdrawal,
			[
				'amount' => (float) $withdrawal->amount,
				'event_id' => $withdrawal->event_id,
				'reason' => $request->catatan,
			]
		);

		return response()->json(['success' => 'Request penarikan ditolak!']);
	}

	public function accepWithdraw(Request $request)
	{
		$request->validate([
			'id' => ['required', 'integer', 'exists:withdraw_data,id'],
		]);

		$result = DB::transaction(function () use ($request) {
			$preview = WithdrawData::findOrFail($request->id);

			if (!$preview->event) {
				return ['error' => 'Event untuk withdrawal ini tidak ditemukan!'];
			}

			$event = Event::whereKey($preview->event_id)->lockForUpdate()->firstOrFail();

			$withdrawal = WithdrawData::with('event')
				->whereKey($request->id)
				->lockForUpdate()
				->firstOrFail();

			if ($withdrawal->status !== 'Proses') {
				return ['error' => 'Request ini sudah diproses sebelumnya!'];
			}

			$finance = app(OverviewService::class)->financeForEvent($event);
			$availableBefore = (float) $finance['available'] + (float) $withdrawal->amount;

			if ((float) $withdrawal->amount > $availableBefore) {
				return ['error' => 'Saldo event tidak lagi mencukupi untuk withdrawal ini!'];
			}

			$withdrawal->update(['status' => 'Sukses']);

			return ['withdrawal' => $withdrawal];
		});

		if (isset($result['error'])) {
			return response()->json(['error' => $result['error']]);
		}

		$this->emailService->sendWithdraw($result['withdrawal']->load(['event', 'user']));

		$this->auditLogger->log(
			'withdrawal.approved',
			'Menyetujui penarikan #' . $result['withdrawal']->id . '.',
			$result['withdrawal'],
			[
				'amount' => (float) $result['withdrawal']->amount,
				'event_id' => $result['withdrawal']->event_id,
			]
		);

		return response()->json(['success' => 'Proses pencairan berhasil diterima!']);
	}

	public function withdrawHistoryData(Request $request)
	{
		$startDate = $request->start_date;
		$endDate = Carbon::parse($request->end_date)->endOfDay();

		$dataWdRequest = WithdrawData::with(['event', 'user'])
			->where('status', 'LIKE', '%' . $request->status . '%')
			->where('status', '!=', 'Proses')
			->where('updated_at', '>=', $startDate)
			->where('updated_at', '<=', $endDate)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataWdRequest)
			->addIndexColumn()
			->addColumn('admin_wd_user', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-user')->with(['data' => $dataWdRequest]);
			})
			->addColumn('admin_wd_amount', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-amount')->with(['data' => $dataWdRequest]);
			})
			->addColumn('admin_wd_date', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-date')->with(['data' => $dataWdRequest]);
			})
			->addColumn('admin_wd_status', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-status')->with(['data' => $dataWdRequest]);
			})
			->make(true);
	}

	public function sendEmail($id)
	{
		$witdhdrawData = WithdrawData::with(['event', 'user'])
			->where('id', $id)
			->firstOrFail();

		$this->emailService->sendWithdraw($witdhdrawData);

		return response()->json('Email sedang diproses');
	}

	# Transaction Check
	public function adminTransactionCheck()
	{
		return redirect('/administrator/payments');
	}

	public function adminGetEvent(Request $request)
	{
		# cek event yang ada request penarikan dana
		$dataWdRequest = WithdrawData::with(['event', 'user'])
			->where('status', 'Proses')
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataWdRequest)
			->addIndexColumn()
			->addColumn('check_event', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.check-event')->with(['data' => $dataWdRequest]);
			})
			->addColumn('check_amount', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.wd-request-amount')->with(['data' => $dataWdRequest]);
			})
			->addColumn('check_action', function ($dataWdRequest) {
				return view('dashboard.admin-dashboard.components.check-action')->with(['data' => $dataWdRequest]);
			})
			->make(true);
	}

	public function adminGetTransaction(Request $request)
	{
		$transaction = Transaction::with(['event', 'ticket'])
			->where('event_id', $request->id)
			->where('status', 'Paid')
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($transaction)
			->addIndexColumn()
			->addColumn('check_amount', function ($transaction) {
				return view('dashboard.admin-dashboard.components.check-process-amount')->with(['data' => $transaction]);
			})
			->addColumn('check_action', function ($transaction) {
				return view('dashboard.admin-dashboard.components.check-process-action')->with(['data' => $transaction]);
			})
			->make(true);
	}

	public function checktTransaction(Request $request)
	{
		$timestamp = Carbon::now()->timestamp;
		$tanggalCheckin = Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s');

		# Cek data
		$transactionDataCheck = Transaction::where('id', $request->id)->exists();
		$transactionData = Transaction::find($request->id);

		# Jika Tidak ada ID
		if (!$transactionDataCheck || $transactionData->admin_check != null || !empty($transactionData->admin_check)) {
			return response()->json(['error' => 'Masukan ID dengan benar!']);
		}

		# Jika ID ada
		$transactionData->update(['admin_check' => $tanggalCheckin]);
		return response()->json(['success' => 'Transaction checked!']);
	}

	# ARTICLE
	public function article(Request $request)
	{
		$search = trim((string) $request->get('key', ''));
		$articles = Article::with(['user', 'category', 'type'])
			->when($search !== '', fn ($query) => $query->where('title', 'like', '%' . $search . '%'))
			->latest('created_at')
			->paginate(12)
			->withQueryString();

		return view('dashboard.admin-dashboard.admin-article', [
			'categories' => ArticleCategory::orderBy('category')->get(),
			'types' => ArticleType::orderBy('type_name')->get(),
			'articles' => $articles,
		]);
	}

	#KATEGORI ARTIKEL
	public function articleCategories()
	{
		return view('dashboard.admin-dashboard.admin-article-category', [
			'categories' => ArticleCategory::orderBy('category')->get(),
			'types' => ArticleType::orderBy('type_name')->get(),
		]);
	}


	# EVENT MANAGEMENT BY ADMINISTRATOR

	public function selectedEventManagement()
	{

		return view('dashboard.admin-dashboard.admin-selected-event', []);
	}

	public function getSelectedEvent()
	{
		$selectedEvent = Event::where('selected_event', '>', 0)->orderByRaw('updated_at DESC')->get();

		return DataTables::of($selectedEvent)
			->addIndexColumn()
			->addColumn('action', function ($selectedEvent) {
				return view('dashboard.admin-dashboard.components.event-selected-action')->with(['data' => $selectedEvent]);
			})
			->make(true);
	}

	public function getDataEvent()
	{
		// Mendapatkan tanggal hari ini
		$today = Carbon::now()->toDateString();

		// Mendapatkan event yang diposting lebih dari hari ini dan belum dipilih
		$dataEvent = Event::where('selected_event', 0)
			->whereDate('end_date', '>', $today)
			->get();

		return DataTables::of($dataEvent)
			->addIndexColumn()
			->addColumn('action', function ($dataEvent) {
				return view('dashboard.admin-dashboard.components.event-select-action')->with(['data' => $dataEvent]);
			})
			->make(true);
	}

	public function selectEvent(Request $request)
	{
		$event = Event::findOrFail($request->id);

		$selected = [
			'selected_event' => 1,
		];

		$event->update($selected);
		return response()->json(['success' => 'Event selected!']);
	}

	public function unselectEvent(Request $request)
	{
		$event = Event::findOrFail($request->id);

		$selected = [
			'selected_event' => 0,
		];

		$event->update($selected);
		return response()->json(['success' => 'Event is no longer promoted!']);
	}

	public function promotionEventManagement()
	{

		return view('dashboard.admin-dashboard.admin-promotion-event', []);
	}

	public function getPromotionEvent()
	{
		$selectedEvent = Event::where('promotion', '>', 0)->orderByRaw('updated_at DESC')->get();

		return DataTables::of($selectedEvent)
			->addIndexColumn()
			->addColumn('action', function ($selectedEvent) {
				return view('dashboard.admin-dashboard.components.event-promotion-action')->with(['data' => $selectedEvent]);
			})
			->make(true);
	}

	public function getEventForPromotion()
	{
		// Mendapatkan tanggal hari ini
		$today = Carbon::now()->toDateString();

		// Mendapatkan event yang diposting lebih dari hari ini dan belum dipilih
		$dataEvent = Event::where('promotion', 0)
			->whereDate('end_date', '>', $today)
			->get();

		return DataTables::of($dataEvent)
			->addIndexColumn()
			->addColumn('action', function ($dataEvent) {
				return view('dashboard.admin-dashboard.components.event-promote-action')->with(['data' => $dataEvent]);
			})
			->make(true);
	}

	public function promoteEvent(Request $request)
	{
		$event = Event::findOrFail($request->id);

		$promotion = [
			'promotion' => 1,
		];

		$event->update($promotion);
		return response()->json(['success' => 'Event promoted!']);
	}

	public function unpromoteEvent(Request $request)
	{
		$event = Event::findOrFail($request->id);

		$promotion = [
			'promotion' => 0,
		];

		$event->update($promotion);
		return response()->json(['success' => 'Event is no longer promoted!']);
	}
}
