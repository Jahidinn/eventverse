<?php

namespace App\Http\Controllers;

use App\Mail\WithdrawEmail;
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
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardController extends Controller
{
	public function index()
	{
		$totalEvent = Event::count();
		$registeredUser = User::count();
		$organization = Organisation::count();
		$allParticipant = Transaction::count();

		//Participant atau transaksi unik
		$uniqueParticipant = Transaction::groupBy(['email', 'event_id'])->get();
		$uniqueParticipantCount = count($uniqueParticipant);

		$totalTransaksi = Transaction::where('status', 'Paid')->sum('total_price');
		$totalWithdraw = WithdrawData::where('status', 'Sukses')->sum('amount');

		$activeTransaction = $totalTransaksi - $totalWithdraw;

		$uniqueVisitor = EventVisitor::count();

		// Dapatkan bulan dan tahun sekarang
		$now = Carbon::now();
		$currentMonth = $now->month;
		$currentYear = $now->year;

		// Lakukan query untuk menghitung data pada bulan dan tahun sekarang
		$participantThisMonth = Transaction::whereMonth('created_at', $currentMonth)
			->whereYear('created_at', $currentYear)
			->count();

		//Article on progress
		$totalArticle = '000';


		return view('dashboard.admin-dashboard.admin-index', [
			'totalEvent' => $totalEvent,
			'registeredUser' => $registeredUser,
			'organization' => $organization,
			'allParticipant' => $allParticipant,
			'uniqueParticipant' => $uniqueParticipantCount,
			'totalTransaksi' => $totalTransaksi,
			'totalWithdraw' => $totalWithdraw,
			'activeTransaction' => $activeTransaction,
			'participantThisMonth' => $participantThisMonth,
			'uniqueVisitor' => $uniqueVisitor,
			'totalArticle' => $totalArticle,
		]);
	}

	public function withdrawRequest(Request $request)
	{
		return view('dashboard.admin-dashboard.admin-wd-request', []);
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
		#Cek data
		$witdhdrawDataCheck = WithdrawData::where('id', $request->id)->exists();
		$witdhdrawData = WithdrawData::find($request->id);

		# Jika Tidak ada ID
		if (!$witdhdrawDataCheck) {
			return response()->json(['error' => 'Masukan ID dengan benar!']);
		}

		# Jika ID ada
		$witdhdrawData->update(['status' => 'Gagal', 'catatan' => $request->catatan]);
		# Kirim email
		$this->sendEmail($request->id);
		# Response
		return response()->json(['success' => 'Berhasil dibatalkan!']);
	}

	public function accepWithdraw(Request $request)
	{
		# Cek data
		$witdhdrawDataCheck = WithdrawData::where('id', $request->id)->exists();
		$witdhdrawData = WithdrawData::find($request->id);

		# Jika Tidak ada ID
		if (!$witdhdrawDataCheck) {
			return response()->json(['error' => 'Masukan ID dengan benar!']);
		}

		# Jika ID ada
		$witdhdrawData->update(['status' => 'Sukses']);
		# Kirim email
		$this->sendEmail($request->id);
		# Response
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

	function sendEmail($id)
	{
		#Fungsi kirim email ketika sukses ataupun gagal
		$witdhdrawData = WithdrawData::with(['event', 'user'])->where('id', $id)->first();

		Mail::to($witdhdrawData->user->email)->send(new WithdrawEmail($witdhdrawData));

		return response()->json('Sukses kirim email');
	}


	# Transaction Check
	public function adminTransactionCheck()
	{
		return view('dashboard.admin-dashboard.admin-transaction-check', []);
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
}
