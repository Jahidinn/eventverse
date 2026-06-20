<?php

namespace App\Http\Controllers;

//use Barryvdh\DomPDF\PDF as PDF;
//use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Vinkla\Hashids\Facades\Hashids;

class PDFController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function generatePDF(Request $request)
	{
		
		$url = env('APP_URL_INVOICE');
		// if ($request->url != $url) {
		// 	return redirect('/');
		// }

		// dd($request->all());
		$id_transaksi = Hashids::decode($request->id_transaksi)[0] ?? abort(404);

		$transaksi = Transaction::find($id_transaksi);
		$event = Event::with('penyelenggara')->find($transaksi->event_id);
		$ticket = Ticket::find($transaksi->ticket_id);

		// $qrcode = QrCode::backgroundColor(0, 0, 0, 0)->color(255, 255, 255)->size(150)->errorCorrection('H')->generate('EC-WNLKUUEUX5');
		// return view('apps.pdf-invoice', [
		// 	'qrcode' => $qrcode
		// ]);

		$qrcode = base64_encode(QrCode::format('svg')->backgroundColor(0, 0, 0, 0)->color(20, 52, 68)->size(150)->errorCorrection('H')->generate($transaksi->transaction_id));
		$qrcode_ec = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate('http:://www.eventhub.web.id'));

		$data = [
			'title' => 'Eventhub Ticket',
			'qrcode_ec' => $qrcode_ec,
			'qrcode' => $qrcode,
			'transaction' => $transaksi,
			'event' => $event,
			'ticket' => $ticket,
		];

		$pdf = PDF::loadView('apps.pdf-invoice', $data);
		return $pdf->download('Invoice-EC' . $transaksi->id + 1 . '.pdf');
	}

	public function downloadTicket(Request $request)
	{
		$id_transaksi = Hashids::decode($request->id_transaksi)[0] ?? abort(404);

		$transaksi = Transaction::find($id_transaksi);
		$event = Event::with('penyelenggara')->find($transaksi->event_id);
		$ticket = Ticket::find($transaksi->ticket_id);

		$qrcode = base64_encode(QrCode::format('svg')->backgroundColor(0, 0, 0, 0)->color(20, 52, 68)->size(100)->errorCorrection('H')->generate('EC-WNLKUUEUX5'));
		$qrcode_ec = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate('http:://www.eventhub.id'));

		$data = [
			'title' => 'Eventhub Ticket',
			'qrcode_ec' => $qrcode_ec,
			'qrcode' => $qrcode,
			'transaction' => $transaksi,
			'event' => $event,
			'ticket' => $ticket,
		];
    $pdf = Pdf::loadView('apps.ticket-pdf', $data);

    return $pdf->download('apps.ticket-pdf.pdf');
}
}
