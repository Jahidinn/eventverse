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
		/*
		|--------------------------------------------------------------------------
		| 1. FEATURED EVENTS
		|--------------------------------------------------------------------------
		*/

		$events = Event::query()
			// ->where('selected_event', 1)
			->with(['penyelenggara', 'ticket', 'category', 'org', 'individual'])
			->latest()
			->take(5)
			->get();

		/*
		|--------------------------------------------------------------------------
		| 2. PROMOTED BANNERS (DUMMY)
		|--------------------------------------------------------------------------
		| Nanti tinggal ganti ke:
		| $promotions = PromotedBanner::where('is_active', 1)
		|     ->orderBy('sort_order')
		|     ->get();
		|
		| Struktur kolom sesuai tabel `promoted_banners`:
		|   - id, image, alt_text, url, link_target, is_active, sort_order, start_at, end_at
		|
		| Dummy pakai gambar gratis (picsum.photos) — bisa langsung jalan tanpa upload.
		|--------------------------------------------------------------------------
		*/

		$promotions = collect([
			(object) [
				'id'          => 1,
				'image'       => 'https://picsum.photos/seed/eventverse-promo-1/1200/750',
				'alt_text'    => 'Follow Instagram Eventverse',
				'url'         => 'https://instagram.com/eventconnect.id',
				'link_target' => '_blank',
				'sort_order'  => 1,
			],
			(object) [
				'id'          => 2,
				'image'       => 'https://picsum.photos/seed/eventverse-promo-2/1200/750',
				'alt_text'    => 'Cek Biaya Transaksi Eventverse',
				'url'         => 'https://eventverse.id/pricing',
				'link_target' => '_self',
				'sort_order'  => 2,
			],
			(object) [
				'id'          => 3,
				'image'       => 'https://picsum.photos/seed/eventverse-promo-3/1200/750',
				'alt_text'    => 'Hubungi Tim Eventverse via WhatsApp',
				'url'         => 'https://wa.me/6282133553002',
				'link_target' => '_blank',
				'sort_order'  => 3,
			],
			(object) [
				'id'          => 4,
				'image'       => 'https://picsum.photos/seed/eventverse-promo-4/1200/750',
				'alt_text'    => 'Promo khusus pengguna baru Eventverse',
				'url'         => null, // ← banner tanpa link (tidak clickable)
				'link_target' => '_self',
				'sort_order'  => 4,
			],
		]);

		/*
		|--------------------------------------------------------------------------
		| 3. MERGE HERO BANNERS
		|--------------------------------------------------------------------------
		| Urutan: PROMO DULU → EVENT KEMUDIAN
		|--------------------------------------------------------------------------
		*/

		$heroBanners = collect();

		// ─── 3a. Promo banners ───
		foreach ($promotions->sortBy('sort_order') as $promo) {

			$promoImage = 'https://placehold.co/1200x750/e2e8f0/64748b?text=No+Image';

			if (!empty($promo->image)) {

				if (preg_match('/^https?:\/\//i', $promo->image)) {
					// URL eksternal — langsung pakai
					$promoImage = $promo->image;

				} else {
					// Path relatif — cek file di storage
					$promoPath = 'storage/' . ltrim($promo->image, '/');

					if (file_exists(public_path($promoPath))) {
						$promoImage = asset($promoPath);
					}
					// kalau file tidak ada → tetap placeholder
				}
			}

			$heroBanners->push((object) [
				'type'        => 'promo',
				'image'       => $promoImage,
				'alt_text'    => $promo->alt_text ?? '',
				'url'         => $promo->url ?? null,
				'link_target' => $promo->link_target ?? '_self',
			]);
		}

		// ─── 3b. Event banners ───
		foreach ($events as $event) {

			$eventImage = 'assets/default-img/event-images/def-img.png';

			if (!empty($event->image)) {
				$imgPath = 'storage/event-images/' . $event->image;

				if (file_exists(public_path($imgPath))) {
					$eventImage = asset($imgPath);
				}
			}

			$heroBanners->push((object) [
				'type'  => 'event',
				'event' => $event,
				'image' => $eventImage,
			]);
		}

		/*
		|--------------------------------------------------------------------------
		| 4. CATEGORIES
		|--------------------------------------------------------------------------
		*/

		$categories = EventCategory::orderBy('sort_order')->get();

		/*
		|--------------------------------------------------------------------------
		| 5. RETURN VIEW
		|--------------------------------------------------------------------------
		*/

		return view('apps.home', [

			'heroBanners' => $heroBanners,
			'categories'  => $categories,

			'eventTerbaru' => Event::with(['penyelenggara', 'ticket'])
				->latest()
				->take(8)
				->get(),

			'eventPopuler' => Event::with(['penyelenggara', 'ticket'])
				->orderByDesc('visitor')
				->take(8)
				->get(),

			'eventPilihan' => Event::with(['penyelenggara', 'ticket'])
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

		return view('apps.event-search', [
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
