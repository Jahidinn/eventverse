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
        Schema::table('custom_forms', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn([
                'form_name',
                'form_status'
            ]);

            $table->unsignedInteger('sort_order')
                ->default(1)
                ->after('event_id');

            $table->string('field_type', 30)
                ->default('text')
                ->after('sort_order');

            $table->string('field_label')
                ->after('field_type');

            $table->string('field_placeholder')
                ->nullable()
                ->after('field_label');

            $table->text('field_help')
                ->nullable()
                ->after('field_placeholder');

            $table->boolean('field_required')
                ->default(false)
                ->after('field_help');

            $table->json('field_options')
                ->nullable()
                ->after('field_required');

            $table->json('field_validation')
                ->nullable()
                ->after('field_options');

            $table->boolean('field_status')
                ->default(true)
                ->after('field_validation');

            $table->index('event_id');
            $table->index('sort_order');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_forms', function (Blueprint $table) {
            $table->dropIndex(['event_id']);
            $table->dropIndex(['sort_order']);

            $table->dropColumn([
                'event_id',
                'sort_order',
                'field_type',
                'field_label',
                'field_placeholder',
                'field_help',
                'field_required',
                'field_options',
                'field_validation',
                'field_status'
            ]);

            $table->string('form_name');
            $table->integer('form_status')->default(1);
        });
    }
};
