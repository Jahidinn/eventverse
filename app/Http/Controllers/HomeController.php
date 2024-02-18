<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cities;
use App\Models\Event;
use App\Models\Provinces;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{
		$eventTerbaru = Event::with('penyelenggara', 'ticket')->orderBy('created_at', 'DESC')->limit(20)->get();
		$eventPopuler = Event::with('penyelenggara', 'ticket')->orderBy('visitor', 'DESC')->limit(10)->get();
		$eventPilihan = Event::with('penyelenggara', 'ticket')->where('selected_event', 1)->orderBy('id', 'DESC')->limit(8)->get();

		return view('apps.home', [
			'eventTerbaru' => $eventTerbaru,
			'eventPopuler' => $eventPopuler,
			'eventPilihan' => $eventPilihan,
		]);
	}

	public function searchEvent(Request $request)
	{
		if ($request->sort == 'Terlama') {
			$sort = 'ASC';
		} else {
			$sort = 'DESC';
		}

		$resultEvent = Event::with('penyelenggara', 'ticket')
			->where(function ($query) use ($request) {
				$query->where('title', 'LIKE', '%' . $request->key . '%')->orWhere('description', 'LIKE', '%' . $request->key . '%');
			})
			->where('category', 'LIKE', '%' . $request->category . '%')
			->where('location_jenis', 'LIKE', '%' . $request->location . '%')
			->where('price_category', 'LIKE', '%' . $request->price . '%')
			->where(function ($query) use ($request) {
				if ($request->city) {
					$query->where('location_city', 'LIKE', '%' . $request->city . '%');
				}
			})
			->where(function ($query) use ($request) {
				if ($request->date) {
					$query->where('start_date', '<=', $request->date)->where('end_date', '>=', $request->date);
				}
			})
			->orderBy('id', $sort)
			->paginate(2)
			->withQueryString();

		$jenisevent = [
			['val' => '', 'text' => 'Semua jenis event'],
			['val' => 'Online', 'text' => 'Online'],
			['val' => 'Offline', 'text' => 'Offline'],
		];
		$sorts = ['Terbaru', 'Terlama'];

		return view('apps.search-page', [
			'eventTerbaru' => $resultEvent,
			'cities' => Cities::all(),
			'categories' => Category::all(),
			'jenisevent' => $jenisevent,
			'sorts' => $sorts,
		]);
	}
}
