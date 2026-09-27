<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Mail\TransactionBillingMail;
use App\Mail\TransactionPaidMail;
use App\Models\Transaction;

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

        SendEmailJob::dispatch(
            $transaction->buyer_email,
            new TransactionBillingMail($transaction)
        );
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

        SendEmailJob::dispatch(
            $transaction->buyer_email,
            new TransactionPaidMail($transaction)
        );
    }

    /**
     * Send payment reminder email.
     */
    public function sendReminder(Transaction $transaction): void
    {
        // Will be implemented later.
    }
}