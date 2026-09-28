<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_provider_usages', function (Blueprint $table) {
            /*
             * Tambahkan provider_id sebagai foreign key.
             */
            $table->foreignId('provider_id')
                ->nullable()
                ->after('id');

            /*
             * Ubah sent_count menjadi usage_count.
             */
            $table->unsignedInteger('usage_count')
                ->default(0)
                ->after('window_start');
        });

        /*
         * Hapus unique/index lama yang menggunakan provider.
         */
        Schema::table('email_provider_usages', function (Blueprint $table) {
            $table->dropUnique(
                'email_provider_usages_provider_window_unique'
            );

            $table->dropIndex(
                'email_provider_usages_window_provider_index'
            );
        });

        /*
         * Hapus kolom legacy.
         */
        Schema::table('email_provider_usages', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'sent_count',
            ]);
        });

        /*
         * Tambahkan unique index baru.
         */
        Schema::table('email_provider_usages', function (Blueprint $table) {
            $table->unique(
                ['provider_id', 'window_start'],
                'email_provider_usages_provider_window_unique'
            );
        });

        /*
         * Jadikan provider_id foreign key setelah struktur
         * selesai dibuat.
         */
        Schema::table('email_provider_usages', function (Blueprint $table) {
            $table->foreign('provider_id')
                ->references('id')
                ->on('email_providers')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('email_provider_usages', function (Blueprint $table) {
            $table->dropForeign([
                'provider_id',
            ]);

            $table->dropUnique(
                'email_provider_usages_provider_window_unique'
            );

            $table->dropColumn([
                'provider_id',
                'usage_count',
            ]);
        });

        Schema::table('email_provider_usages', function (Blueprint $table) {
            $table->string('provider', 30)
                ->nullable()
                ->after('id');

            $table->unsignedInteger('sent_count')
                ->default(0)
                ->after('window_start');
        });

        Schema::table('email_provider_usages', function (Blueprint $table) {
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
};