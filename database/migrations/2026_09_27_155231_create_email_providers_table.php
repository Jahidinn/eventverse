<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_providers', function (Blueprint $table) {
            $table->id();

            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->string('driver', 50);

            $table->unsignedInteger('hourly_limit')->nullable();
            $table->unsignedInteger('priority')->default(1);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_providers');
    }
};