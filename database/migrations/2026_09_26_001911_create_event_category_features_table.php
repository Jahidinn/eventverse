<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_category_features', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_category_id');

            // Technical feature key, e.g. lineup, schedule, facility
            $table->string('feature', 100);

            // Label displayed to organizer / participant
            $table->string('label', 100);

            $table->boolean('is_enabled')->default(true);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->foreign('event_category_id')
                ->references('id')
                ->on('event_categories')
                ->cascadeOnDelete();

            $table->unique(
                ['event_category_id', 'feature'],
                'event_category_feature_unique'
            );

            $table->index(
                ['event_category_id', 'is_enabled'],
                'event_category_feature_enabled_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_category_features');
    }
};