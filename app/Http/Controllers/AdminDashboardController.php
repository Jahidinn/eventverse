<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\EventVisitor;
use App\Models\Organisation;
use App\Models\WithdrawData;
use Illuminate\Http\Request;
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


	# Transaction Check
	public function adminTransactionCheck()
	{
		return view('dashboard.admin-dashboard.admin-transaction-check', []);
	}
}
