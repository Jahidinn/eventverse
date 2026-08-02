<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $table->decimal('subtotal', 15, 2)
                ->default(0)
                ->change();

            $table->decimal('platform_fee', 15, 2)
                ->default(0)
                ->after('subtotal');

            $table->decimal('payment_fee', 15, 2)
                ->default(0)
                ->after('platform_fee');

            $table->decimal('grand_total', 15, 2)
                ->default(0)
                ->after('payment_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
