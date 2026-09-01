<?php

namespace App\Services;

use App\Mail\TransactionBillingMail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send billing email for a transaction.
     */
    public function sendTransaction(Transaction $transaction): void
    {
        $transaction->loadMissing([
            'event',
            'ticket',
            'participants',
        ]);

        Mail::to($transaction->buyer_email)
            ->send(new TransactionBillingMail($transaction));
    }

    /**
     * Send payment success email.
     */
    public function sendPaid(Transaction $transaction): void
    {
        $transaction->loadMissing([
            'event',
            'ticket',
            'participants',
        ]);

        Mail::to($transaction->buyer_email)
            ->send(new TransactionPaidMail($transaction));
    }

    /**
     * Send payment reminder email.
     */
    public function sendReminder(Transaction $transaction): void
    {
        // Will be implemented later.
    }
}
