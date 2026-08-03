<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Cities;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Message;
use App\Models\Provinces;
use App\Models\Subscriber;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
	
	public function index()
	{
		$heroBanners = collect();

		/*
		|--------------------------------------------------------------------------
		| Banner dari Event
		|--------------------------------------------------------------------------
		*/

		$events = Event::query()
			// ->where('selected_event', 1)
			->latest()
			->take(5)
			->get();

		foreach ($events as $event) {

			$image = asset('assets/default-img/event-images/def-img.png');

			if ($event->image) {

				$path = public_path("storage/event-images/{$event->image}");

				if (file_exists($path)) {

					$image = asset("storage/event-images/{$event->image}");

				}

			}

			$heroBanners->push([

				'image' => $image,

				'link' => route('event.show', $event->slug),

				'button_text' => 'Lihat Event',

				'sort' => 2,

			]);

		}

		/*
		|--------------------------------------------------------------------------
		| Banner Promosi
		|--------------------------------------------------------------------------
		*/

		// nanti tinggal tambah

		/*
		$promotions = PromotedBanner::active()->get();

		foreach ($promotions as $banner){

			$heroBanners->push([

				'image' => asset('storage/'.$banner->image),

				'link' => $banner->url,

				'button_text' => $banner->button_text,

				'sort' => 1,

			]);

		}
		*/

		/*
		|--------------------------------------------------------------------------
		| Sorting
		|--------------------------------------------------------------------------
		*/

		$heroBanners = $heroBanners
			->sortBy('sort')
			->values();

			// dd($heroBanners );

			$categories = EventCategory::orderBy('sort_order')->get();

		return view('apps.home', [

			'heroBanners' => $heroBanners,
			'categories' => $categories,

			'eventTerbaru' => Event::with('penyelenggara', 'ticket')
				->latest()
				->take(10)
				->get(),

			'eventPopuler' => Event::with('penyelenggara', 'ticket')
				->orderByDesc('visitor')
				->take(10)
				->get(),

			'eventPilihan' => Event::with('penyelenggara', 'ticket')
				->where('selected_event', 1)
				->latest()
				->take(8)
				->get(),

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
			->where('category_id', 'LIKE', '%' . $request->category . '%')
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
			->paginate(8)
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
			'categories' => EventCategory::all(),
			'jenisevent' => $jenisevent,
			'sorts' => $sorts,
		]);
	}

	public function subscribe(Request $request)
	{
		$email = $request->email;

		$data = [
			'email' => $email,
			'is_active' => 1,
		];

		$cekData = Subscriber::where('email', $email)->exists();

		# Cek sudah subcribe atau belum
		if ($cekData) {
			return response()->json(['error' => 'email already subscribed']);
		}

		Subscriber::create($data);
		return response()->json(['success' => 'Successful subscription!']);
	}

	public function sendMessage(Request $request)
	{
		$ipAddress = $request->ip();

		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'name' => 'required',
			'subjek' => 'required',
			'message' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->first()]);
		}

		$data = [
			'ip' => $ipAddress,
			'email' => $request->email,
			'name' => $request->name,
			'subjek' => $request->subjek,
			'message' => $request->message,
			'is_active' => 1,
		];

		# hitung pesan
		$cekData = Message::where('is_reply', 0)
			->where(function ($query) use ($request, $ipAddress) {
				$query->where('email', $request->email)
					->orWhere('ip', $ipAddress);
			})
			->get();
		$jml_pesan = count($cekData);

		# Filter span
		# tambahkan opsi jika spam maka hapus pesan lama
		if ($jml_pesan > 5) {
			return response()->json(['error' => 'Wahh terindikasi spam!']);
		}

		Message::create($data);
		return response()->json(['success' => 'Berhasil mengirim pesan!']);
	}
}
