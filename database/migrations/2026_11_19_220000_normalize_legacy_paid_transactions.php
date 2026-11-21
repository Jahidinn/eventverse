<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Legacy checkout rows only stored subtotal and marked the transaction Paid.
         * Complete the minimum payment fields from the recorded subtotal/creation time
         * so they can be reconciled as verified payments. Fees remain zero because
         * they were never recorded and must not be invented.
         */
        DB::table('transactions')
            ->where('status', 'Paid')
            ->where('grand_total', 0)
            ->where('subtotal', '>', 0)
            ->whereNull('paid_at')
            ->update([
                'grand_total' => DB::raw('subtotal'),
                'paid_at' => DB::raw('created_at'),
            ]);
    }

    public function down(): void
    {
        // Reconciliation data is intentionally retained.
    }
};
