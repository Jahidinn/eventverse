<?php

use App\Models\Transaction;
use App\Models\TransactionParticipant;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Transaction::query()
            ->where('status', 'Paid')
            ->whereDoesntHave('participants')
            ->orderBy('id')
            ->chunkById(100, function ($transactions) {
                foreach ($transactions as $transaction) {
                    if ((int) $transaction->quantity !== 1) {
                        continue;
                    }

                    TransactionParticipant::firstOrCreate(
                        ['ticket_code' => $transaction->transaction_code . '-001'],
                        [
                            'transaction_id' => $transaction->id,
                            'transaction_code' => $transaction->transaction_code,
                            'name' => $transaction->buyer_name,
                            'email' => $transaction->buyer_email,
                            'phone' => $transaction->buyer_phone,
                            'created_at' => $transaction->created_at,
                            'updated_at' => $transaction->created_at,
                        ]
                    );
                }
            });
    }

    public function down(): void
    {
        // Participant rows are operational records; do not delete them on rollback.
    }
};
