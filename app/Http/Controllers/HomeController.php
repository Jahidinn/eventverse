<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Event;
use App\Models\Provinces;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{
		$eventTerbaru = Event::with('penyelenggara', 'ticket')->orderBy('id', 'DESC')->limit(8)->get();
		$eventPopuler = Event::with('penyelenggara', 'ticket')->orderBy('visitor', 'DESC')->limit(8)->get();
		$eventPilihan = Event::with('penyelenggara', 'ticket')->where('selected_event', 1)->orderBy('id', 'DESC')->limit(8)->get();

		return view('apps.home', [
			'eventTerbaru' => $eventTerbaru,
			'eventPopuler' => $eventPopuler,
			'eventPilihan' => $eventPilihan,
		]);
	}
}
