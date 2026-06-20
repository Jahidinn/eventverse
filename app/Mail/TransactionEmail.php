<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionEmail extends Mailable
{
	use Queueable, SerializesModels;
	public $mailData;

	/**
	 * Create a new message instance.
	 */
	public function __construct($mailData)
	{
		$this->mailData = $mailData;
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		if ($this->mailData['subjek'] == 'Paid') {
			$status = 'Sukses';
		} elseif ($this->mailData['subjek'] == 'Unpaid') {
			$status = 'Unpaid';
		} elseif ($this->mailData['subjek'] == 'Pending') {
			$status = 'Pending';
		} elseif ($this->mailData['subjek'] == 'Expired') {
			$status = 'Expired';
		} else {
			$status = 'Gagal';
		}

		return new Envelope(
			subject: 'Transaksi EventHub (' . $status . ')',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			view: 'apps.transaction-email',
			with: [
				'mailData' => $this->mailData,
				'qrcode' => base64_encode(QrCode::format('svg')->backgroundColor(0, 0, 0, 0)->color(20, 52, 68)->size(150)->errorCorrection('H')->generate('abcdef')),
				'transaction' => $this->mailData['transaction'],
				'event' => $this->mailData['event'],
				'ticket' => $this->mailData['ticket'],
			],
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments(): array
	{
		return [];
	}
}
