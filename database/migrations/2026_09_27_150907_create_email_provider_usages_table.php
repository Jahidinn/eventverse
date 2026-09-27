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
        Schema::create('email_provider_usages', function (Blueprint $table) {
            $table->id();

            $table->string('provider', 30);

            $table->dateTime('window_start');

            $table->unsignedInteger('sent_count')->default(0);

            $table->timestamps();

            $table->unique(
                ['provider', 'window_start'],
                'email_provider_usages_provider_window_unique'
            );

            $table->index(
                ['window_start', 'provider'],
                'email_provider_usages_window_provider_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_provider_usages');
    }
};