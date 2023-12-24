<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Theme;
use App\Models\Cities;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Provinces;
use App\Models\CustomForm;
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
			'bannerEvent' => 'required|max:616'
		]);

		if ($validasi->fails()) {
			return response()->json(['error' => 'Banner/poster kosong atau ukuran terlalu besar']);
		} else {

			//Remove white space
			$imageName = preg_replace('/\s+/', '-', time() . '-' . $request->file('bannerEvent')->getClientOriginalName());

			$data = [
				'user_id' => $request->userId,
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
						"ticket_price" => $request->ticketPrice[$key],
						"ticket_button" => $request->ticketButton[$key],
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
						"form_status" => $form_status
					];
				}
				CustomForm::insert($customForm);
			}

			//dd($data, $finalValues, $customForm);

			return response()->json(['success' => 'Data Berhasil Disimpan']);
		}
	}

	public function show(Event $event)
	{
		return view('events.show', [
			'detailEvent' => $event,
			'ticketData' => Ticket::where('event_id', $event->id)->get()
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
		return view('events.edit', [
			'detailEvent' => $event,
			'ticketData' => Ticket::where('event_id', $event->id)->get(),
			'data_provinces' => Provinces::all(),
			'category' => Category::all(),
			'theme' => Theme::all(),
			'jenisLokasi' => $jenisLokasi,
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
			return response()->json(['success' => 'Banner berhasil diubah!']);
		}
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request)
	{
		$data = [
			'user_id' => $request->userId,
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
		return redirect('/event/' . $request->linkEvent)->with(['success' => 'Event berhasil di edit!']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		$event = Event::where('id', $id)->first();

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
		$data = [
			'event_id' => $request->event_id,
			'ticket_name' => $request->ticket_name,
			'ticket_price' => preg_replace("/[^0-9]/", '', $request->ticket_price),
			'ticket_quota' => $request->ticket_quota,
			'ticket_start' => $request->ticket_start,
			'ticket_deadline' => $request->ticket_deadline,
			'ticket_button' => $request->ticket_button,
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

	public function editTicket(Request $request)
	{
		$data = [
			'ticket_name' => $request->ticket_name,
			'ticket_price' => preg_replace("/[^0-9]/", '', $request->ticket_price),
			'ticket_quota' => $request->ticket_quota,
			'ticket_start' => $request->ticket_start,
			'ticket_deadline' => $request->ticket_deadline,
			'ticket_button' => $request->ticket_button,
		];

		Ticket::where('id', $request->id_ticket)->update($data);
		return response()->json(['success' => 'Berhasil EDIT tiket pendaftaran!']);
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
		Ticket::where('id', $request->id)->delete();
		return response()->json(['success' => 'Tiket pendaftaran berhasil DIHAPUS!']);
	}

	public function deleteFormulir(Request $request)
	{
		CustomForm::where('id', $request->id)->delete();
		return response()->json(['success' => 'Form pendaftaran berhasil DIHAPUS!']);
	}
}
