<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawEmail extends Mailable
{
	use Queueable, SerializesModels;
	public $witdhdrawData;

	/**
	 * Create a new message instance.
	 */
	public function __construct($witdhdrawData)
	{
		$this->witdhdrawData = $witdhdrawData;
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			subject: 'Woohoo! Penarikan Dana Berhasil',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			view: 'dashboard.admin-dashboard.components.wd-email-page',
			with: [
				'withdraw' => $this->witdhdrawData,
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
