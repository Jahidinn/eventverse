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
        Schema::create('event_images', function (Blueprint $table) {
            $table->id();
            $table->string('event_id', 32)->index();
            $table->string('image');
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->enum('type', [
                'gallery',
                'poster',
                'venue',
                'sponsor'
            ])->default('gallery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_images');
    }
};
