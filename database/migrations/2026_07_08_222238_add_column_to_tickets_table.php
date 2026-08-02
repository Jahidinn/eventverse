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
            $table->string('event_id', 100)->change();
            $table->decimal('ticket_price', 12, 2)->change();
            $table->renameColumn('more_quantity', 'max_quantity');
            $table->renameColumn('ticket_deadline', 'ticket_end');
            $table->unsignedInteger('sort_order')
                ->default(0)
                ->after('ticket_button');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
