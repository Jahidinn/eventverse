<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Article;
use App\Models\SnapToken;
use App\Models\CustomForm;
use App\Models\ArticleType;
use App\Models\Transaction;
use App\Models\WithdrawData;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Models\TransactionForm;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DashboardController extends Controller
{
	public function index()
	{
		//Tambahkan data myevent, event, peserta, transaksi
		$user_id = auth()->user()->id;
		$totalPeserta = 0;
		$biayaAdmin = config('app.biaya_admin');
		$totalTransaksi = 0;

		$eventDiikuti = Transaction::where('user_id', $user_id)->count();
		$eventDibuat = Event::where('user_id', $user_id)->get();

		foreach ($eventDibuat as $event) {
			$jumlahPeserta = Transaction::where('event_id', $event->id)->where('status', 'Paid')->count();
			$transaksi = Transaction::where('event_id', $event->id)->where('status', 'Paid')->sum('grand_total');

			// Tambahkan jumlah peserta ke totalPeserta
			$totalPeserta += $jumlahPeserta;

			// Tambahkan jumlah transaksi ke totalTransaksi
			$totalTransaksi += $transaksi;
		}

		return view('dashboard.page-dashboard', [
			'eventDiikuti' => $eventDiikuti,
			'eventDibuat' => count($eventDibuat),
			'totalPeserta' => $totalPeserta,
			'totalTransaksi' => $totalTransaksi - ($biayaAdmin * $totalPeserta),
		]);
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
		$transaction = $transaction->paginate(10)->withQueryString()->onEachSide(2);

		return view('dashboard.myevent', [
			'myevents' => $transaction,
		]);
	}

	# detail transaksi (formulir)
	public function detailTransaction(Request $request)
	{
		$transaction_id = $request->transaction;
		$event_id = $request->event;

		$detail_event = Event::where('id', $event_id)->first();
		$detail_transaksi = Transaction::where('id', $transaction_id)->first();

		$data_form = CustomForm::where('event_id', $event_id)->get();
		$data = [];

		foreach ($data_form as $form) {
			$form_value = TransactionForm::where('transaction_id', $transaction_id)->where('form_id', $form->id)->first();

			$data[] = [
				'form_id' => $form->id ?? '',
				'form_name' => $form->form_name ?? '',
				'form_value' => $form_value->form_value ?? '',
				'form_value_id' => $form_value->id ?? '',
			];
		}

		return response()->json(['data' => $data, 'event' => $detail_event, 'trx' => $detail_transaksi]);
	}

	# EDIT FORM TRANSAKSI
	public function editFormTransaction(Request $request)
	{
		$value_id = $request->value_id;
		$form_id = $request->form_id;
		$trx_id = $request->trx_id;
		$value_id = $request->value_id;
		$value = $request->value;

		$form = TransactionForm::find($value_id);

		if ($form) {

			$data = [
				'form_value' => $value
			];

			$form->update($data);
			$result = $form;
			# code...
		} else {
			$data = [
				'form_id' => $form_id,
				'transaction_id' => $trx_id,
				'form_value' => $value,
			];

			$result = TransactionForm::create($data);
			# code...
		}


		return response()->json(['success' => 'Berhasil edit data!', 'data' => $result]);
	}


	public function deleteMyevent(Request $request)
	{
		//Proses delete
		$deleteTransaction = Transaction::where('id', $request->id)->whereIn('status', ['Unpaid', 'Pending'])->delete();
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

		$listEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();

		// if ($listEvent->isEmpty()) {
		// 	// Lakukan pengalihan URL atau tindakan lainnya
		// 	return Redirect::to('/dashboard/manajemen-event');
		// }

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

		$transaction = Transaction::with(['event', 'ticket'])
			->where('is_login', 1)
			->where('user_login_id', $request->user_id)
			->orderByRaw('id DESC')
			->get();

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
			->orderByRaw('id DESC')
			->paginate(5)
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
			->addColumn('transaction_date', function ($dataParticipant) {
				return $dataParticipant->created_at->format('d M Y');
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

	public function checkEventDate(Request $request)
	{
		$event_id = $request->event_id;
		$cekEvent = Event::find($event_id);
		$today = Carbon::now()->format('Y-m-d');

		if ($cekEvent->end_date >= $today) {
			return response()->json(['error' => 'Event belum selesai, tidak bisa melakukan penarikan!']);
		} else {
			return response()->json(['success' => 'Ok!']);
		}
	}

	public function transactionReport(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$listEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();


		return view('dashboard.page-transaction-report', [
			'listEvent' => $listEvent,
		]);
	}

	public function getTransactionReport(Request $request)
	{
		$event_id = $request->event_id;
		//Biaya admin untuk customer
		$biayaAdmin = config('app.biaya_admin');

		//Total transaksi sukses
		$totalPeserta = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->count();

		//Total biaya admin
		$biayaAdminPeserta = $biayaAdmin * $totalPeserta;

		//Total dana sebelum dikurangi biaya admin
		$totalTransaksi = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->sum('total_price');

		//Pengurangan total dana dikurangi biaya admin dari user (Total dana masuk)
		$totalDana = $totalTransaksi - $biayaAdminPeserta;

		$totalTiket = Ticket::where('event_id', $event_id)->count();

		//Mengkategorikan dana berdasarkan metode pembayaran

		//Metode BANK TRANSFER (VA)
		$qty_bank_tf = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'bank_transfer')
			->count();

		$dana_bank_tf = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'bank_transfer')
			->sum('total_price') -
			$biayaAdmin * $qty_bank_tf;

		// Bank TF : 1.5% + 4500 per transaksi
		$admin_bank_tf = 4500 * $qty_bank_tf + (1.5 / 100) * $dana_bank_tf;

		$total_dana_bank_tf = $dana_bank_tf - $admin_bank_tf;

		//Metode CREDIT CARD

		$qty_credit_card = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'credit_card')
			->count();

		$dana_credit_card = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->where('payment_type', 'credit_card')
			->sum('total_price') -
			$biayaAdmin * $qty_credit_card;

		//Credit card : 3.5% + 2500 per transaksi
		$admin_credit_card = 2500 * $qty_credit_card + (3.5 / 100) * $dana_credit_card;

		$total_dana_credit_card = $dana_credit_card - $admin_credit_card;

		//Metode Lain (Qris, Gopay, Shopeepay, Dana, Linkaja)

		$qty_lain = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
			->count();

		$dana_lain = Transaction::where('event_id', $event_id)
			->where('status', 'Paid')
			->whereNotIn('payment_type', ['bank_transfer', 'credit_card'])
			->sum('total_price') -
			$biayaAdmin * $qty_lain;

		// Pembayaran Lain : 3% pertransaksi / per tiket
		$admin_lain = (3 / 100) * $dana_lain;

		$total_dana_lain = $dana_lain - $admin_lain;

		//Pengurangan biaya admin penyelenggara
		$eventConnectFee = $admin_bank_tf + $admin_credit_card + $admin_lain;

		// penarikan dana -> tambahkan yang statusnya hanya sukses dan berhasil, dan pending
		$danaDitarik = WithdrawData::where('event_id', $event_id)->where(function ($query) {
			$query->where('status', 'Sukses')
				->orWhere('status', 'Proses');
		})->sum('amount');

		$danaBersih = $total_dana_bank_tf + $total_dana_credit_card + $total_dana_lain - $danaDitarik;

		$data = [
			'danaTotal' => $totalDana,
			'peserta' => $totalPeserta,
			'tiket' => $totalTiket,
			'fee' => $eventConnectFee,
			'danaDitarik' => $danaDitarik,
			'danaBersih' => $danaBersih,
		];

		if ($request->from_request == 'withdraw') {
			return $data;
		} else {
			return response()->json(['data' => $data]);
		}
	}

	public function eventCheckin(Request $request)
	{
		$user_id = auth()->user()->id;
		$search = $request->key;

		$dataEvent = Event::where('title', 'like', '%' . $search . '%')
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->paginate(5)
			->withQueryString();

		return view('dashboard.page-checkin-event', [
			'dataEvent' => $dataEvent,
		]);
	}

	public function getParticipantCheckin(Request $request)
	{
		if (!auth()->user()) {
			return response()->json(['error' => 'Gagal!']);
		}

		$dataParticipant = Transaction::with(['event', 'ticket'])
			->where('event_id', $request->id)
			->where('status', 'Paid')
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($dataParticipant)
			->addIndexColumn()
			->addColumn('checkin_action', function ($dataParticipant) {
				return view('dashboard.components.column-action-checkin')->with(['data' => $dataParticipant]);
			})
			->make(true);
	}

	public function checkinProcess(Request $request)
	{

		$timestamp = Carbon::now()->timestamp;
		$tanggalCheckin = Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s');

		$checkinTransaction = Transaction::where('transaction_id', $request->id)->first();

		//Jika Tidak ada ID
		if (!$checkinTransaction) {
			return response()->json(['error' => 'Masukan ID dengan benar!']);
		}

		if (!empty($checkinTransaction->checkin)) {
			return response()->json(['error' => 'Sudah di check in guys!']);
		}

		//Jika ID ada
		$checkinTransaction->update(['checkin' => $tanggalCheckin]);
		return response()->json(['success' => 'Berhasil checkin!']);
	}

	public function withdraw(Request $request)
	{
		//Proteksi siapa yang mencairkan
		$user_id = auth()->user()->id;
		$dataEvent = Event::where('id', $request->event_id)->where('user_id', $user_id)->first();

		if (empty($dataEvent) || !$user_id) {
			return response()->json(['error' => 'Pelanggaran!']);
		}

		//Proteksi ke 2 menghindari proses penarikan sebelum event selesai
		$today = Carbon::now()->format('Y-m-d');

		if ($dataEvent->end_date >= $today) {
			return response()->json(['error' => 'Belum bisa melakukan penarikan!']);
		}

		//Memanggil data report
		$checkHistory = $this->getTransactionReport($request);


		if ($request->wdAmount > $checkHistory['danaBersih']) {
			return response()->json(['error' => 'Pelanggaran!']);
		}

		//cek rekening bank dan bank
		if (!$request->wdRekening || !$request->wdBank) {
			return response()->json(['error' => 'Belum ada data rekening bank!']);
		}

		$data = [
			'event_id' => $request->event_id,
			'user_id' => $request->wdUserId,
			'rekening' => $request->wdRekening,
			'bank' => $request->wdBank,
			'amount' => $request->wdAmount,
			'status' => 'Proses',
		];

		$submitWithdraw = WithdrawData::create($data);

		if (!$submitWithdraw) {
			return response()->json(['error' => 'Gagal request withdraw!']);
		} else {
			$updateHistory = $this->getTransactionReport($request);
			return response()->json(['success' => 'Berhasil request penarikan dana!', 'event_id' => $request->event_id, 'saldo' => $updateHistory['danaBersih']]);
		}
	}

	public function withdrawHistory(Request $request)
	{
		$user_id = auth()->user()->id;
		$dataWD = WithdrawData::where('event_id', $request->id)->where('user_id', $user_id)->get();

		return DataTables::of($dataWD)
			->addIndexColumn()
			->addColumn('wd', function ($dataWD) {
				return number_format($dataWD->amount, 0, ',', '.');
			})
			->addColumn('tanggal', function ($dataWD) {
				return $dataWD->created_at->format('d M Y');
			})
			->addColumn('wd-status', function ($dataWD) {
				return view('dashboard.components.column-status-withdraw')->with(['data' => $dataWD]);
			})
			->make(true);
	}

	public function downloadExcel(Request $request, $id)
	{
		$user_id = auth()->user()->id;

		//Cek yang download pembuat event atau bukan
		$cekUser = Event::where('id', $id)->first();
		if ($cekUser->user_id != $user_id) {

			//Jika bukan jangan lanjutkan download
			abort(404, 'Resource not found.');
		}

		//Dapatkan data transaksi / peserta
		$participants = Transaction::with(['ticket', 'event'])->where('event_id', $id)
			->orderBy('ticket_id', 'asc')
			->orderBy('status')
			->get();

		//Data custom forms
		$customForms = CustomForm::where('event_id', $id)->get();

		// Mendapatkan instance kontroller saat membuat objek
		$dashboardController = new DashboardController();

		// Panggil fungsi getTransactionReport untuk mendapatkan perhitungan data transaksi
		$transaksi = $dashboardController->getTransactionReport(app('request')->merge(['event_id' => $id]));
		$dataTransaksi = json_decode(json_encode($transaksi), true)['original']['data'];

		$danaTotal = number_format($dataTransaksi['danaTotal'], 0, ',', '.');
		$danaDitarik = number_format($dataTransaksi['danaDitarik'], 0, ',', '.');
		$fee = number_format($dataTransaksi['fee'], 0, ',', '.');
		$danaBersih = number_format($dataTransaksi['danaBersih'], 0, ',', '.');
		$peserta = number_format(count($participants), 0, ',', '.');
		$tiket = number_format($dataTransaksi['tiket'], 0, ',', '.');

		// Membuat objek Spreadsheet
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Mengatur tinggi baris untuk baris pertama
		$sheet->getRowDimension(1)->setRowHeight(10);
		$sheet->getRowDimension(2)->setRowHeight(30);
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getRowDimension(4)->setRowHeight(25);
		$sheet->getRowDimension(5)->setRowHeight(20);
		$sheet->getColumnDimension('A')->setWidth(3);

		$startColumnForm = 9;
		$lastColumn = count($customForms) + $startColumnForm - 1;

		$row = 6;
		$lastRow = count($participants) + $row;

		// Melakukan merge pada sel-sel tertentu
		$sheet->mergeCells('B2:' . chr(65 + $lastColumn) . '2');

		$sheet->mergeCells('B' . $row - 3 . ':C' . $row - 3);
		$sheet->mergeCells('B' . $row - 2 . ':C' . $row - 2);

		$sheet->mergeCells('D' . $row - 3 . ':E' . $row - 3);
		$sheet->mergeCells('D' . $row - 2 . ':E' . $row - 2);

		$sheet->mergeCells('F' . $row - 3 . ':G' . $row - 3);
		$sheet->mergeCells('F' . $row - 2 . ':G' . $row - 2);

		$sheet->mergeCells('H' . $row - 3 . ':' . chr(65 + $lastColumn) . $row - 2);

		//Title event
		$sheet->setCellValue('B2', $cekUser->title);
		//Perhitungan data
		$sheet->setCellValue('B' . $row - 3, 'Total eserta (' . $peserta . ')');
		$sheet->setCellValue('B' . $row - 2, 'Total tiket (' . $tiket . ')');

		$sheet->setCellValue('D' . $row - 3, 'Total pemasukan (Rp ' . $danaTotal . ')');
		$sheet->setCellValue('D' . $row - 2, 'Total pencairan (Rp ' . $danaDitarik . ')');

		$sheet->setCellValue('F' . $row - 3, 'Biaya layanan (Rp ' . $fee . ')');
		$sheet->setCellValue('F' . $row - 2, 'Saldo Akhir (Rp ' . $danaBersih . ')');

		// Data header
		$sheet->setCellValue('B' . $row - 1, 'Ticket Pendaftaran');
		$sheet->setCellValue('C' . $row - 1, 'ID');
		$sheet->setCellValue('D' . $row - 1, 'Nama');
		$sheet->setCellValue('E' . $row - 1, 'Email');
		$sheet->setCellValue('F' . $row - 1, 'Tlp');
		$sheet->setCellValue('G' . $row - 1, 'Biaya');
		$sheet->setCellValue('H' . $row - 1, 'Status');
		$sheet->setCellValue('I' . $row - 1, 'Pembayaran');

		//Looping header dinamis berdasarkan custom form
		$headerCustom = $startColumnForm;
		foreach ($customForms as $value) {
			// Gunakan huruf alfabet untuk menentukan nama kolom berdasarkan indeks
			$columnName = chr(65 + $headerCustom);
			$sheet->setCellValue($columnName . $row - 1, $value->form_name ?? '');

			// Tingkatkan indeks kolom untuk langkah berikutnya
			$headerCustom++;
		}

		//Looping isi data transaksi atau peserta event
		foreach ($participants as $participant) {
			if ($participant->total_price == 0 || $participant->total_price == '') {
				$price = 0;
			} else {
				$price = $participant->total_price - config('app.biaya_admin');
			}

			//Looping data wajib
			$sheet->setCellValue('B' . $row, $participant->ticket->ticket_name);
			$sheet->setCellValue('C' . $row, $participant->transaction_id);
			$sheet->setCellValue('D' . $row, $participant->name);
			$sheet->setCellValue('E' . $row, $participant->email);
			$sheet->setCellValue('F' . $row, $participant->phone);
			$sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('0');
			$sheet->setCellValue('G' . $row, $price);
			$sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValue('H' . $row, $participant->status);
			$sheet->setCellValue('I' . $row, $participant->payment_type);

			//Looping data value custom form
			$customColumnIndex = $startColumnForm;
			foreach ($customForms as $value) {
				$columnName = chr(65 + $customColumnIndex);
				$data = TransactionForm::where('transaction_id', $participant->id)->where('form_id', $value->id)->first();
				$sheet->setCellValue($columnName . $row, $data->form_value ?? '');

				// Tingkatkan indeks kolom untuk langkah berikutnya
				$customColumnIndex++;
			}
			$row++;
		}


		//STYLING TABEL

		$sheet->getStyle('B2:' . chr(65 + $lastColumn) . $lastRow)
			->getAlignment()
			->setVertical(Alignment::VERTICAL_CENTER);

		$sheet->getStyle($row - 1)
			->getAlignment()
			->setVertical(Alignment::VERTICAL_CENTER);

		$sheet->getStyle('B2:' . chr(65 + $lastColumn) . 2)
			->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('4F81BD');

		$sheet->getStyle('B5:' . chr(65 + $lastColumn) . 5)
			->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('9ee8ff');

		$sheet->getStyle(2)
			->getAlignment()
			->setHorizontal('center');

		$sheet->getStyle('B5:' . chr(65 + $lastColumn) . $lastRow)
			->getAlignment()
			->setHorizontal('left');

		$sheet->getStyle('B2:' . chr(65 + $lastColumn) . $lastRow)
			->getBorders()
			->getInside()
			->setBorderStyle(Border::BORDER_DASHED)
			->setColor(new Color('c4c4c4'));

		$sheet->getStyle('B2:' . chr(65 + $lastColumn) . $lastRow)
			->getBorders()
			->getOutline()
			->setBorderStyle(Border::BORDER_MEDIUM);

		$sheet->getStyle('B5:' . chr(65 + $lastColumn) . '5')
			->getBorders()
			->getOutline()
			->setBorderStyle(Border::BORDER_MEDIUM)
			->setColor(new Color('000000'));

		$sheet->getStyle('B2:' . chr(65 + $lastColumn) . '2')
			->getBorders()
			->getOutline()
			->setBorderStyle(Border::BORDER_MEDIUM)
			->setColor(new Color('000000'));

		# styling background baris konten
		foreach (range(5, $lastRow) as $row) {
			if ($row % 2 == 0) { // Check if row number is even
				$sheet->getStyle('B' . $row . ':' . chr(65 + $lastColumn) . $row)
					->getFill()
					->setFillType(Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('ebeded'); // Set background color
			}
		}



		// Mengatur lebar kolom otomatis sesuai dengan panjang karakter
		foreach ($sheet->getColumnIterator() as $column) {
			$columnIndex = $column->getColumnIndex();
			// Pastikan kolom dimulai dari B dan seterusnya
			if ($columnIndex < 'B') {
				continue;
			}

			// Mengatur lebar kolom A dan B menjadi 25
			if ($columnIndex == 'B' || $columnIndex == 'C') {
				$maxWidth = 26;
			} else {
				$maxWidth = 23; // Lebar maksimal untuk kolom lainnya
			}

			$sheet->getColumnDimension($columnIndex)->setWidth($maxWidth);

			// Mengatur wrap text untuk setiap sel di kolom
			foreach ($sheet->getRowIterator() as $row) {
				$cell = $sheet->getCell($columnIndex . $row->getRowIndex());
				//$sheet->getStyle($cell->getCoordinate())->getAlignment()->setWrapText(true);

				if ($row->getRowIndex() == 2 || $row->getRowIndex() == 5) {
					$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);
					$sheet->getStyle($cell->getCoordinate())->getFont()->setSize(12);
				}
				if ($row->getRowIndex() == 3 || $row->getRowIndex() == 4) {
					$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);
					$sheet->getStyle($cell->getCoordinate())->getFont()->setSize(11);
					$sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setRGB('FFFFFF');

					$sheet->getStyle($cell->getCoordinate())->getFill()
						->setFillType(Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('808080'); // Set background color
				}
			}
		}


		// Menyiapkan respons untuk file Excel
		$writer = new Xlsx($spreadsheet);

		// Nama file Excel yang akan didownload
		$filename = 'Data peserta-' . time() . '.xlsx';

		// Set header untuk menentukan jenis respons
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		// Mengirim file Excel ke browser
		$writer->save('php://output');
		//return response()->json(['success' => 'Sukses download']);
	}

	# ARTICLE
	public function article()
	{
		# Query mengambil data kategori dan jenis artikel 
		$kategori = ArticleCategory::all();
		$type = ArticleType::all();

		return view('dashboard.page-article', [
			'categories' => $kategori,
			'type' => $type,
		]);
	}

	public function getArticle()
	{
		$user_id = auth()->user()->id;

		$article = Article::with(['user'])
			->where('user_id', $user_id)
			->orderByRaw('id DESC')
			->get();

		return DataTables::of($article)
			->addIndexColumn()
			->addColumn('blog-title', function ($article) {
				return view('dashboard.admin-dashboard.components.article-title')->with(['data' => $article]);
			})
			->addColumn('action', function ($article) {
				return view('dashboard.admin-dashboard.components.article-action')->with(['data' => $article]);
			})
			->make(true);
	}
}
