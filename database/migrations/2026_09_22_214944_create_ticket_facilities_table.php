<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_facility', function (Blueprint $table) {
            $table->id();

            $table->foreignId('facility_id')
                ->constrained('event_facilities')
                ->cascadeOnDelete();

            $table->foreignId('ticket_id')
                ->constrained('tickets')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['facility_id', 'ticket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_facility');
    }
};