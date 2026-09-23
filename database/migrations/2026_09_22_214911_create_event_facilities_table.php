<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_facilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            // Tabler icon name, e.g. "medal", "shirt", "gift"
            $table->string('icon')->nullable();

            // general = berlaku untuk semua ticket
            // ticket  = hanya berlaku untuk ticket tertentu
            $table->enum('scope', ['general', 'ticket'])
                ->default('general');

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['event_id', 'scope']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_facilities');
    }
};