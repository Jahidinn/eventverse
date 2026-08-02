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
        Schema::table('events', function (Blueprint $table) {
            $table->string('event_id', 32)
                ->nullable()
                ->unique()
                ->after('id');
            $table->string('location_online', 200)->nullable()->after('location_jenis');
            $table->string('location_maps', 255)->nullable()->after('location_detail');
            $table->enum('event_status', [
                'draft',
                'published',
                'archived'
            ])
            ->default('draft')
            ->after('status');

            // Nullable untuk mendukung Draft & Auto Save
            $table->unsignedBigInteger('theme')->nullable()->change();

            $table->string('location_jenis')->nullable()->change();
            $table->string('location_province')->nullable()->change();
            $table->string('location_city')->nullable()->change();
            $table->string('location_detail')->nullable()->change();

            $table->integer('price_category')->nullable()->change();

            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();

            $table->text('description')->nullable()->change();
            $table->text('terms')->nullable()->change();

            $table->string('image')->nullable()->change();

            $table->unsignedBigInteger('organizer_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
