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
        Schema::table('tickets', function (Blueprint $table) {

            $table->unsignedInteger('reserved_quantity')
                ->default(0)
                ->after('ticket_quota');

            $table->unsignedInteger('sold_quantity')
                ->default(0)
                ->after('reserved_quantity');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            $table->dropColumn([
                'reserved_quantity',
                'sold_quantity',
            ]);

        });
    }
};