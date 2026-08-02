<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah participant_id jika belum ada
        if (!Schema::hasColumn('transaction_forms', 'participant_id')) {
            Schema::table('transaction_forms', function (Blueprint $table) {
                $table->unsignedBigInteger('participant_id')
                    ->nullable()
                    ->after('id');
            });
        }

        // Hapus semua data lama
        DB::table('transaction_forms')->delete();

        // Hapus transaction_id jika masih ada
        if (Schema::hasColumn('transaction_forms', 'transaction_id')) {
            Schema::table('transaction_forms', function (Blueprint $table) {
                $table->dropColumn('transaction_id');
            });
        }

        // Ubah participant_id menjadi NOT NULL
        Schema::table('transaction_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('participant_id')
                ->nullable(false)
                ->change();
        });

        // Tambahkan foreign key (hindari duplicate FK jika migration pernah gagal)
        try {
            Schema::table('transaction_forms', function (Blueprint $table) {
                $table->foreign('participant_id')
                    ->references('id')
                    ->on('transaction_participants')
                    ->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
        }

        try {
            Schema::table('transaction_forms', function (Blueprint $table) {
                $table->foreign('form_id')
                    ->references('id')
                    ->on('custom_forms')
                    ->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
        }
    }

    public function down(): void
    {
        Schema::table('transaction_forms', function (Blueprint $table) {

            try {
                $table->dropForeign(['participant_id']);
            } catch (\Throwable $e) {
            }

            try {
                $table->dropForeign(['form_id']);
            } catch (\Throwable $e) {
            }
        });

        if (!Schema::hasColumn('transaction_forms', 'transaction_id')) {
            Schema::table('transaction_forms', function (Blueprint $table) {
                $table->unsignedBigInteger('transaction_id')
                    ->nullable()
                    ->after('id');
            });
        }

        Schema::table('transaction_forms', function (Blueprint $table) {

            if (Schema::hasColumn('transaction_forms', 'participant_id')) {
                $table->dropColumn('participant_id');
            }

        });
    }
};