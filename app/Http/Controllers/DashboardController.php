<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index()
	{
		return view('dashboard.index');
	}

	public function myEvent()
	{
		return view('dashboard.myevent');
	}
	public function manajemenEvent()
	{
		$listEvent = Event::all();
		return view('dashboard.manajemen-event', [
			'listEvent' => $listEvent
		]);
	}
}
