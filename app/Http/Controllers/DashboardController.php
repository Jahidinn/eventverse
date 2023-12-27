<?php

namespace App\Http\Controllers;

use App\Models\CustomForm;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\SnapToken;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionForm;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
	public function index()
	{
		return view('dashboard.index');
	}

	//My event
	public function myEvent(Request $request)
	{
		$search = $request->key;

		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}
		$user_id = auth()->user()->id;
		$transaction = Transaction::with(['event', 'ticket'])
			->where('is_login', 1)
			->where('user_login_id', $user_id)
			->orderByRaw('id DESC');


		if (!empty($search)) {
			$transaction = $transaction->whereHas('event', function ($query) use ($search) {
				$query->where('title', 'like', '%' . $search . '%');
			});
		}
		$transaction = $transaction->paginate(2)->withQueryString();

		return view('dashboard.myevent', [
			'myevents' => $transaction,
		]);
	}

	public function deleteMyevent(Request $request)
	{
		//Proses delete
		$deleteTransaction = Transaction::where('id', $request->id)->where('status', 'Unpaid')->delete();
		//Delete snap token dan data custom form
		if ($deleteTransaction) {
			SnapToken::where('transaction_id', $request->id)->delete();
			TransactionForm::where('transaction_id', $request->id)->delete();
		}
		return response()->json(['success' => 'Data registrasi berhasil dihapus!']);
	}

	//Manajemen event
	public function manajemenEvent(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')->where('user_id', $user_id)->paginate(2)->withQueryString();
		return view('dashboard.manajemen-event', [
			'listEvent' => $listEvent
		]);
	}

	//Tidak dipakai (Dipakai ketika menggunakan ajax)
	public function getMyEvent(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}
		$transaction = Transaction::with(['event', 'ticket'])->where('is_login', 1)->where('user_login_id', $request->user_id)->orderByRaw('id DESC')->get();
		return DataTables::of($transaction)
			->addIndexColumn()
			->addColumn('event', function ($transaction) {
				$event = $transaction->event->title;
				$ticket = $transaction->ticket->ticket_name;
				return view('dashboard.components.column-myevent-event')->with(['event' => $event, 'ticket' => $ticket]);
			})
			->addColumn('transaction_status', function ($transaction) {
				return view('dashboard.components.column-myevent-status')->with(['data' => $transaction]);
			})
			->addColumn('action', function ($transaction) {
				return view('dashboard.components.column-myevent')->with(['data' => $transaction]);
			})
			->make(true);
	}
	//Tidak dipakai (Dipakai ketika menggunakan ajax)

	public function participant(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$dataEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->paginate(2)
			->withQueryString();

		return view('dashboard.page-participant', [
			'dataEvent' => $dataEvent,
		]);
	}

	public function getParticipant(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}

		$dataParticipant = Transaction::with(['event', 'ticket'])
			->where('event_id', $request->id)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataParticipant)
			->addIndexColumn()
			->addColumn('transaction_status', function ($dataParticipant) {
				return view('dashboard.components.column-status')->with(['data' => $dataParticipant]);
			})
			->addColumn('transaction_action', function ($dataParticipant) {
				return view('dashboard.components.column-action-participant')->with(['data' => $dataParticipant]);
			})
			->make(true);
	}

	public function getCustomformParticipant(Request $request)
	{
		$customForm = CustomForm::where('event_id', $request->event_id)->get();

		foreach ($customForm as $form) {
			$dataForm = TransactionForm::with(['transaction'])
				->where('form_id', $form->id)
				->where('transaction_id', $request->id)
				->first();

			$data[] = [
				'nama_form' => strtr($form->form_name, ['*' => '']),
				'form_value' => $dataForm ? $dataForm->form_value : '',
			];
		}

		return response()->json(['data' => $data]);
	}

	public function transactionReport(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')->where('user_id', $user_id)->paginate(2)->withQueryString();


		return view('dashboard.page-transaction-report', [
			'listEvent' => $listEvent,
		]);
	}
}
