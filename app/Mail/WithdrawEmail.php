<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $witdhdrawData;

    public function __construct($witdhdrawData)
    {
        $this->witdhdrawData = $witdhdrawData;
    }

    public function envelope(): Envelope
    {
        $subject = $this->witdhdrawData->status === 'Sukses'
            ? 'Woohoo! Penarikan Dana Berhasil'
            : 'Yahh! Penarikan Dana GAGAL';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.withdraw',
            with: [
                'withdraw' => $this->witdhdrawData,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}