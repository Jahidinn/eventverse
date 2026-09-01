<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Transaction $transaction
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.addresses.tickets.address'),
                config('mail.addresses.tickets.name'),
            ),
            subject: 'Pembayaran Berhasil - Transaksi #' . $this->transaction->transaction_code,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction-paid',
        );
    }
}