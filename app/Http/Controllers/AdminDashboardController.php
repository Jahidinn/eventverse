<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
	public function index()
	{
		//Tambahkan data myevent, event, peserta, transaksi
		$user_id = auth()->user()->id;
		$totalPeserta = 0;
		$biayaAdmin = config('app.biaya_admin');
		$totalTransaksi = 0;

		$eventDiikuti = Transaction::where('user_login_id', $user_id)->count();
		$eventDibuat = Event::where('user_id', $user_id)->get();

		foreach ($eventDibuat as $event) {
			$jumlahPeserta = Transaction::where('event_id', $event->id)->where('status', 'Paid')->count();
			$transaksi = Transaction::where('event_id', $event->id)->where('status', 'Paid')->sum('total_price');

			// Tambahkan jumlah peserta ke totalPeserta
			$totalPeserta += $jumlahPeserta;

			// Tambahkan jumlah transaksi ke totalTransaksi
			$totalTransaksi += $transaksi;
		}

		return view('dashboard.admin-dashboard.admin-index', [
			'eventDiikuti' => $eventDiikuti,
			'eventDibuat' => count($eventDibuat),
			'totalPeserta' => $totalPeserta,
			'totalTransaksi' => $totalTransaksi - ($biayaAdmin * $totalPeserta),
		]);
	}
}
