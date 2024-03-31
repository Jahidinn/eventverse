<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Theme;
use App\Models\Cities;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Provinces;
use App\Models\CustomForm;
use App\Models\EventVisitor;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('events.create', [
			'data_provinces' => Provinces::all(),
			'category' => Category::all(),
			'theme' => Theme::all(),
		]);
	}

	public function getCities($code)
	{
		$cities = Cities::where('province_code', $code)->get();
		return response()->json(['result' => $cities]);
	}

	public function cekUrl(Request $request)
	{
		if ($request->url == '') {
			return response()->json(['result' => 'N']);
		}

		$url = Event::where('slug', $request->url)->first();

		if (!$url) {
			return response()->json(['result' => 0]);
		} else {
			return response()->json(['result' => 1]);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{

		$validasi = Validator::make($request->all(), [
			'penyelenggaraEvent' => 'required',
			'create-category' => 'required',
			'create-lokasi' => 'required',
			'create-tanggal' => 'required',

			'userId' => 'required',
			'organizerEvent' => 'required',
			'bannerEvent' => 'required|max:616',
			'linkEvent' => 'required|unique:events,slug',
			'titleEvent' => 'required',
			'kategoriEvent' => 'required',
			'descriptionEvent' => 'required',
			'terms' => 'required',
			'temaEvent' => 'required',
			'jenisEvent' => 'required',
			'priceCategory' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
		], [
			'penyelenggaraEvent.required' => 'Kolom Penyelenggara Event wajib diisi!',
			'create-category.required' => 'Kolom Kategori Event wajib diisi!',
			'create-lokasi.required' => 'Kolom Lokasi Event wajib diisi!',
			'create-tanggal.required' => 'Kolom Tanggal Event wajib diisi!',
			'userId.required' => 'Kolom User ID wajib diisi!',

			'organizerEvent.required' => 'Kolom Organizer Event wajib diisi!',
			'bannerEvent.required' => 'Banner/Poster Event wajib diisi!',
			'bannerEvent.max' => 'Ukuran maksimum banner adalah 616 KB!',
			'linkEvent.required' => 'Kolom Link Event wajib diisi!',
			'linkEvent.unique' => 'Link Event sudah digunakan.',
			'titleEvent.required' => 'Kolom Judul Event wajib diisi!',
			'kategoriEvent.required' => 'Kolom Kategori Event wajib diisi!',
			'descriptionEvent.required' => 'Kolom Deskripsi Event wajib diisi!',
			'terms.required' => 'Kolom Syarat & Ketentuan Event wajib diisi!',
			'temaEvent.required' => 'Kolom Tema Event wajib diisi!',
			'jenisEvent.required' => 'Kolom Jenis Event wajib diisi!',
			'priceCategory.required' => 'Kolom Kategori Harga wajib diisi!',
			'startDate.required' => 'Kolom Tanggal Mulai Event wajib diisi!',
			'endDate.required' => 'Kolom Tanggal Selesai Event wajib diisi!',
		]);

		if ($validasi->fails()) {
			return response()->json(['error' => $validasi->errors()->first()]);
		} else {

			//Remove white space
			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('bannerEvent')->getClientOriginalName());

			if (($request->organizerEvent == 'org' && ($request->organizerId == '' || empty($request->organizerId))) || $request->organizerEvent == 'individual') {
				$type = 'individual';
				$org_id = $request->userId;
			} else {
				$type = $request->organizerEvent;
				$org_id = $request->organizerId;
			}

			$data = [
				'user_id' => $request->userId,
				'organizer' => $type,
				'organizer_id' => $org_id,
				'title' => $request->titleEvent,
				'slug' => $request->linkEvent,
				'category' => $request->kategoriEvent,
				'description' => $request->descriptionEvent,
				'terms' => $request->terms,
				'theme' => $request->temaEvent,
				'location_jenis' => $request->jenisEvent,
				'location_province' => $request->provinces,
				'location_city' => $request->cities,
				'location_detail' => $request->detailAlamat,
				'price_category' => $request->priceCategory,
				'start_date' => $request->startDate,
				'end_date' => $request->endDate,
				'image' => $imageName,

			];

			if ($request->startDate > $request->endDate) {
				return response()->json(['error' => 'Tanggal event tidak sesuai!']);
			}

			// Get ticket data
			if ($request->ticketName) {
				//submit ke database
				//save image
				$request->file('bannerEvent')->storeAs('public/event-images', $imageName);

				//save data
				Event::insert($data);
				$dataEvent = Event::where('slug', $request->linkEvent)->first();

				foreach ($request->ticketName as $key => $ticketName) {

					$finalValues[] = [
						"event_id" => $dataEvent->id,
						"ticket_name" => $ticketName,
						"ticket_description" => $request->ticketDescription[$key],
						"ticket_quota" => $request->ticketQuota[$key],
						"ticket_start" => $request->ticketDate[$key],
						"ticket_deadline" => $request->ticketDeadline[$key],
						"ticket_price" => $request->ticketPrice[$key] ?? 0,
						"ticket_button" => $request->ticketButton[$key],
						"more_quantity" => $request->moreQuantity[$key] && $request->moreQuantity[$key] == 1 ? 1 : 0,
					];
				}
				Ticket::insert($finalValues);
			} else {
				return response()->json(['error' => 'Tambahkan minimal 1 tiket pendaftaran!']);
			}

			// get custom form data
			if ($request->formName) {
				foreach ($request->formName as $key => $formName) {
					$form_status = strpos($formName, '*') !== false ? 1 : 0;
					$customForm[] = [
						"event_id" => $dataEvent->id,
						"form_name" => $formName,
						"form_status" => $form_status,
					];
				}
				CustomForm::insert($customForm);
			}

			//dd($data, $finalValues, $customForm);

			return response()->json(['success' => 'Berhasil posting event', 'url' => $request->linkEvent]);
		}
	}

	public function show(Event $event, Request $request)
	{
		//Menyimpan data visitor unik berdasarkan IP Address
		$ipAddress = $request->ip();
		$cekUnique = EventVisitor::where('ip_address', $ipAddress)->where('event_id', $event->id)->exists();

		//Jika belum ada visitor
		if (!$cekUnique) {
			//Masukan ip address dan event yag dikunjungi
			EventVisitor::create([
				'ip_address' => $ipAddress,
				'event_id' => $event->id,
			]);

			// Update kolom pengunjung di tabel Event
			$event = Event::find($event->id);
			$event->increment('visitor');
		}

		# Event rekomendasi
		$recomendedEvent = Event::where('status', 1)
			->where('slug', '!=', $event->slug)
			->inRandomOrder()
			->limit(8)
			->get();

		return view('events.show', [
			'detailEvent' => $event,
			'ticketData' => Ticket::where('event_id', $event->id)->get(),
			'ticketTransaction' => Transaction::where('event_id', $event->id)->where('status', '!=', 'Expired')->get(),
			'dateNow' => Carbon::now()->format('Y-m-d'),
			'recomendedEvents' => $recomendedEvent
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Event $event)
	{
		$jenisLokasi = [
			['lokasi' => 'Online'],
			['lokasi' => 'Offline'],
		];

		$jenisPenyelenggara = [
			['jenis' => 'individual', 'text' => 'Individu'],
			['jenis' => 'org', 'text' => 'Organisasi'],
		];
		return view('events.edit', [
			'detailEvent' => $event,
			'ticketData' => Ticket::where('event_id', $event->id)->get(),
			'data_provinces' => Provinces::all(),
			'category' => Category::all(),
			'theme' => Theme::all(),
			'jenisLokasi' => $jenisLokasi,
			'jenisPenyelenggara' => $jenisPenyelenggara,
		]);
	}

	public function editImage(Request $request)
	{
		//Validasi Gambar/poster
		$validasi = Validator::make($request->all(), [
			'bannerEventEdit' => 'required|max:616'
		]);

		//Response jika validasi gagal
		if ($validasi->fails()) {
			return response()->json(['error' => 'Banner/poster kosong atau ukuran terlalu besar']);
		}

		//Jika lolos validasi atau validasi berhasil
		else {
			$event = Event::where('id', $request->eventId)->first();

			//Hapus file
			if ($event->image) {
				Storage::delete('public/event-images/' . $event->image);
			}

			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('bannerEventEdit')->getClientOriginalName());
			$data = [
				'image' => $imageName,
			];

			//Simpan gambar dan update data gambar pada database
			$request->file('bannerEventEdit')->storeAs('public/event-images', $imageName);
			Event::where('id', $request->eventId)->update($data);

			//response suksess
			return response()->json(['success' => 'Banner/poster event berhasil diubah!', 'img' => $imageName]);
		}
	}

	public function getMyOrg()
	{
		$myOrg = OrganisationMember::with(['user', 'org'])
			->where('user_id', auth()->user()->id)
			->whereIn('position', ['Member', 'Owner'])
			->get();

		if (!$myOrg || empty($myOrg)) {
			return response()->json(['error' => '']);
		} else {
			return response()->json(['data' => $myOrg]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 */

	public function update(Request $request)
	{
	}

	public function editProcess(Request $request)
	{
		$validasi = Validator::make($request->all(), [
			'penyelenggaraEvent' => 'required',
			'create-category' => 'required',
			'create-lokasi' => 'required',
			'create-tanggal' => 'required',

			'organizerEvent' => 'required',
			'linkEvent' => 'required',
			'titleEvent' => 'required',
			'kategoriEvent' => 'required',
			'descriptionEvent' => 'required',
			'terms' => 'required',
			'temaEvent' => 'required',
			'jenisEvent' => 'required',
			'priceCategory' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
		], [
			'penyelenggaraEvent.required' => 'Kolom Penyelenggara Event wajib diisi!',
			'create-category.required' => 'Kolom Kategori Event wajib diisi!',
			'create-lokasi.required' => 'Kolom Lokasi Event wajib diisi!',
			'create-tanggal.required' => 'Kolom Tanggal Event wajib diisi!',
			'userId.required' => 'Kolom User ID wajib diisi!',

			'organizerEvent.required' => 'Kolom Organizer Event wajib diisi!',
			'linkEvent.required' => 'Kolom Link Event wajib diisi!',
			'linkEvent.unique' => 'Link Event sudah digunakan.',
			'titleEvent.required' => 'Kolom Judul Event wajib diisi!',
			'kategoriEvent.required' => 'Kolom Kategori Event wajib diisi!',
			'descriptionEvent.required' => 'Kolom Deskripsi Event wajib diisi!',
			'terms.required' => 'Kolom Syarat & Ketentuan Event wajib diisi!',
			'temaEvent.required' => 'Kolom Tema Event wajib diisi!',
			'jenisEvent.required' => 'Kolom Jenis Event wajib diisi!',
			'priceCategory.required' => 'Kolom Kategori Harga wajib diisi!',
			'startDate.required' => 'Kolom Tanggal Mulai Event wajib diisi!',
			'endDate.required' => 'Kolom Tanggal Selesai Event wajib diisi!',
		]);

		//Response jika validasi gagal
		if ($validasi->fails()) {
			return response()->json(['error' => $validasi->errors()->first()]);
		}

		//Jika lolos validasi atau validasi berhasil
		else {

			//Cek URL
			$event = Event::where('id', $request->eventId)->first();
			if ($request->linkEvent != $event->slug) {
				$cekURL = Event::where('slug', $request->linkEvent)->first();
				if ($cekURL) {
					return response()->json(['error' => 'Link event sudah digunakan!']);
				}
			}

			if (($request->organizerEvent == 'org' && ($request->organizerId == '' || empty($request->organizerId))) || $request->organizerEvent == 'individual') {
				$type = 'individual';
				$org_id = $request->userId;
			} else {
				$type = $request->organizerEvent;
				$org_id = $request->organizerId;
			}

			$data = [
				'organizer' => $type,
				'organizer_id' => $org_id,
				'title' => $request->titleEvent,
				'slug' => $request->linkEvent,
				'category' => $request->kategoriEvent,
				'description' => $request->descriptionEvent,
				'terms' => $request->terms,
				'theme' => $request->temaEvent,
				'location_jenis' => $request->jenisEvent,
				'location_province' => $request->provinces,
				'location_city' => $request->cities,
				'location_detail' => $request->detailAlamat,
				'price_category' => $request->priceCategory,
				'start_date' => $request->startDate,
				'end_date' => $request->endDate,
			];

			Event::where('id', $request->eventId)->update($data);
			return response()->json(['success' => 'Event Berhasil di edit!', 'url' => $request->linkEvent]);

			//return redirect('/event/' . $request->linkEvent)->with(['success' => 'Event berhasil di edit!']);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		$event = Event::where('id', $id)->first();
		$transaction = Transaction::where('event_id', $event->id)->exists();

		if ($transaction) {
			return response()->json(['error' => 'Sudah ada peserta guys, tidak bisa DIHAPUS!']);
		}

		if ($event->image) {
			Storage::delete('public/event-images/' . $event->image);
		}

		// Hapus tabel di database
		Event::where('id', $id)->delete();
		Ticket::where('event_id', $id)->delete();
		CustomForm::where('event_id', $id)->delete();

		return response()->json(['success' => 'Event berhasil DIHAPUS!']);
	}

	//Edit ticket dan formulir

	public function getTicket(Request $request)
	{
		$ticket = Ticket::where('event_id', $request->event_id)->get();
		return DataTables::of($ticket)
			->addColumn('action', function ($ticket) {
				return view('dashboard.components.column-action')->with(['data' => $ticket, 'button' => 'ticket']);
			})
			->make(true);
	}

	public function getFormulir(Request $request)
	{
		$form = CustomForm::where('event_id', $request->event_id)->get();
		return DataTables::of($form)
			->addColumn('action', function ($form) {
				return view('dashboard.components.column-action')->with(['data' => $form, 'button' => 'formulir']);
			})
			->make(true);
	}

	public function addTicket(Request $request)
	{
		// Validasi data formulir
		$validator = Validator::make($request->all(), [
			'event_id' => 'required',
			'ticket_name' => 'required',
			'ticket_price' => 'required',
			'ticket_quota' => 'required|numeric',
			'ticket_start' => 'required',
			'ticket_deadline' => 'required',
			'ticket_button' => 'required',
		]);

		// Jika validasi gagal, kembalikan respons dengan pesan kesalahan pertama
		if ($validator->fails()) {
			$firstError = $validator->errors()->first();
			return response()->json(['error' => $firstError], 400);
		}

		if ($request->input('ticket_more_qty') && $request->input('ticket_more_qty') == 1) {
			$moreQty = 1;
		} else {
			$moreQty = 0;
		}

		$data = [
			'event_id' => $request->event_id,
			'ticket_name' => $request->ticket_name,
			'ticket_price' => preg_replace("/[^0-9]/", '', $request->ticket_price),
			'ticket_quota' => $request->ticket_quota,
			'ticket_start' => $request->ticket_start,
			'ticket_deadline' => $request->ticket_deadline,
			'ticket_button' => $request->ticket_button,
			'more_quantity' => $moreQty,
		];

		Ticket::insert($data);
		return response()->json(['success' => 'Berhasil menambah tiket pendaftaran!']);
	}

	public function addFormulir(Request $request)
	{
		$form_status = strpos($request->form_name, '*') !== false ? 1 : 0;
		$data = [
			'event_id' => $request->event_id,
			'form_name' => $request->form_name,
			'form_status' => $form_status,
		];

		CustomForm::insert($data);
		return response()->json(['success' => 'Berhasil menambah form pendaftaran!']);
	}

	//Cek kemanan tiket untuk front-end
	public function checkTicketParticipant(Request $request)
	{
		$id = $request->id;
		$participant = Transaction::where('ticket_id', $id)->exists();

		if ($participant) {
			return response()->json(['data' => 1]);
		} else {
			return response()->json(['data' => 0]);
		}
	}

	public function editTicket(Request $request)
	{
		// Validasi data formulir
		$validator = Validator::make($request->all(), [
			'event_id' => 'required',
			'ticket_name' => 'required',
			'ticket_price' => 'required',
			'ticket_quota' => 'required|numeric',
			'ticket_start' => 'required',
			'ticket_deadline' => 'required',
			'ticket_button' => 'required',
		]);

		// Jika validasi gagal, kembalikan respons dengan pesan kesalahan pertama
		if ($validator->fails()) {
			$firstError = $validator->errors()->first();
			return response()->json(['error' => $firstError], 400);
		}

		if ($request->input('ticket_more_qty') && $request->input('ticket_more_qty') == 1) {
			$moreQty = 1;
		} else {
			$moreQty = 0;
		}

		$data = [
			'ticket_name' => $request->ticket_name,
			'ticket_price' => preg_replace("/[^0-9]/", '', $request->ticket_price),
			'ticket_quota' => $request->ticket_quota,
			'ticket_start' => $request->ticket_start,
			'ticket_deadline' => $request->ticket_deadline,
			'ticket_button' => $request->ticket_button,
			'more_quantity' => $moreQty,
		];

		$ticket = Ticket::find($request->id_ticket);
		$participant = Transaction::where('ticket_id', $request->id_ticket)->exists();

		if ($ticket) {
			//periksa keamanan ticket di backend
			if ($data['ticket_price'] != $ticket->ticket_price && $participant) {
				//Jika ada perubahan harga dan ada peserta
				return response()->json(['error' => 'Sudah ada peserta terdaftar! tidak bisa edit harga tiket, silahkan bisa menambah tiket baru!']);
			} else {
				//Jika tidak ada perubahan harga atau tidak ada peserta
				$ticket->update($data);
				return response()->json(['success' => 'Berhasil EDIT tiket pendaftaran!']);
			}
		} else {
			// Handle jika tiket tidak ditemukan
			return response()->json(['error' => 'Tiket tidak ditemukan.']);
		}
	}

	public function editFormulir(Request $request)
	{
		$form_status = strpos($request->form_name, '*') !== false ? 1 : 0;
		$data = [
			'form_name' => $request->form_name,
			'form_status' => $form_status,
		];

		CustomForm::where('id', $request->id_form)->update($data);
		return response()->json(['success' => 'Berhasil EDIT Formulir!']);
	}

	public function deleteTicket(Request $request)
	{
		//Cek tiket, jika sudah ada peserta maka tidak dapat dihapus
		$participant = Transaction::where('ticket_id', $request->id)->exists();

		if ($participant) {
			# code...
			return response()->json(['error' => 'Sudah ada peserta terdaftar!']);
		}
		// Jika tidak ada peserta terdaftar
		else {
			Ticket::where('id', $request->id)->delete();
			return response()->json(['success' => 'Tiket pendaftaran berhasil DIHAPUS!']);
		}
	}

	public function deleteFormulir(Request $request)
	{
		CustomForm::where('id', $request->id)->delete();
		return response()->json(['success' => 'Form pendaftaran berhasil DIHAPUS!']);
	}
}
