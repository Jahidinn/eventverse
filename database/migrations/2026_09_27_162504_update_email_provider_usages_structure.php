<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * provider_id, usage_count, dan foreign key
         * sudah berhasil dibuat pada percobaan migration sebelumnya.
         *
         * Yang tersisa:
         * - memastikan unique provider_id + window_start
         * - menghapus kolom legacy provider
         * - menghapus kolom legacy sent_count
         */

        // Cek apakah unique index sudah ada.
        $indexes = DB::select('SHOW INDEX FROM email_provider_usages');

        $hasUniqueIndex = collect($indexes)
            ->where('Key_name', 'email_provider_usages_provider_window_unique')
            ->isNotEmpty();

        if (! $hasUniqueIndex) {
            Schema::table('email_provider_usages', function (Blueprint $table) {
                $table->unique(
                    ['provider_id', 'window_start'],
                    'email_provider_usages_provider_window_unique'
                );
            });
        }

        // Hapus struktur lama jika masih ada.
        $columnsToDrop = [];

        if (Schema::hasColumn('email_provider_usages', 'provider')) {
            $columnsToDrop[] = 'provider';
        }

        if (Schema::hasColumn('email_provider_usages', 'sent_count')) {
            $columnsToDrop[] = 'sent_count';
        }

        if (! empty($columnsToDrop)) {
            Schema::table('email_provider_usages', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }

    public function down(): void
    {
        /*
         * Kembalikan kolom legacy.
         *
         * Data usage saat ini tidak dipulihkan karena migration
         * awal memang sudah mengubah struktur tanpa data.
         */

        Schema::table('email_provider_usages', function (Blueprint $table) {
            if (! Schema::hasColumn('email_provider_usages', 'provider')) {
                $table->string('provider', 30)
                    ->nullable()
                    ->after('id');
            }

            if (! Schema::hasColumn('email_provider_usages', 'sent_count')) {
                $table->unsignedInteger('sent_count')
                    ->default(0)
                    ->after('window_start');
            }
        });

        $indexes = DB::select('SHOW INDEX FROM email_provider_usages');

        $hasUniqueIndex = collect($indexes)
            ->where('Key_name', 'email_provider_usages_provider_window_unique')
            ->isNotEmpty();

        if ($hasUniqueIndex) {
            Schema::table('email_provider_usages', function (Blueprint $table) {
                $table->dropUnique(
                    'email_provider_usages_provider_window_unique'
                );
            });
        }
    }
};