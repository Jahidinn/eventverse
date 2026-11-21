<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('transactions')
            ->whereNull('invoice_number')
            ->orderBy('id')
            ->chunkById(200, function ($transactions) {
                foreach ($transactions as $transaction) {
                    $date = $transaction->created_at
                        ? Carbon::parse($transaction->created_at)->format('Ymd')
                        : now()->format('Ymd');

                    DB::table('transactions')
                        ->where('id', $transaction->id)
                        ->update([
                            'invoice_number' => 'INV-' . $date . '-' . str_pad((string) $transaction->id, 6, '0', STR_PAD_LEFT),
                        ]);
                }
            });
    }

    public function down(): void
    {
        // Invoice numbers are financial references; keep them on rollback.
    }
};
