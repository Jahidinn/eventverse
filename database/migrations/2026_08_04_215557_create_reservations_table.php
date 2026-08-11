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
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();

            $table->string('reservation_code', 30)->unique();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('ticket_id')
                ->constrained()
                ->cascadeOnDelete();

            // Guest = session, Login = nullable user_id (nanti kalau ada)
            $table->string('session_id', 100)->index();

            $table->unsignedInteger('quantity');

            $table->enum('status', [
                'Reserved',
                'Completed',
                'Expired',
                'Cancelled',
            ])->default('Reserved');

            $table->timestamp('expired_at')->index();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
