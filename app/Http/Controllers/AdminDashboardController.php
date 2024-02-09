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
}
