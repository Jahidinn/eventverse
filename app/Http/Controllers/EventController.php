<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Cities;
use App\Models\CustomForm;
use App\Models\Ticket;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
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
		]);
	}

	public function getCities($code)
	{
		$cities = Cities::where('province_code', $code)->get();
		return response()->json(['result' => $cities]);
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
					$customForm[] = [
						"event_id" => $dataEvent->id,
						"form_name" => $formName
					];
				}
				CustomForm::insert($customForm);
			}

			//dd($data, $finalValues, $customForm);

			return response()->json(['success' => 'Data Berhasil Disimpan']);
		}
	}

	/**
	 * Display the specified resource.
	 */
	// public function show(Event $event)
	public function show()
	{
		return view('events.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Event $event)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Event $event)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Event $event)
	{
		//
	}
}
