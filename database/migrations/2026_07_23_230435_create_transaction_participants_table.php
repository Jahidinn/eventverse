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
        Schema::create('transaction_participants', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Transaction
            |--------------------------------------------------------------------------
            */

            $table->foreignId('transaction_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('transaction_code');

            /*
            |--------------------------------------------------------------------------
            | Ticket
            |--------------------------------------------------------------------------
            */

            $table->string('ticket_code')->unique();

            /*
            |--------------------------------------------------------------------------
            | Participant
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Check In
            |--------------------------------------------------------------------------
            */

            $table->timestamp('checked_in_at')->nullable();

            $table->foreignId('checked_in_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('transaction_code');
            $table->index('ticket_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_participants');
    }
};
