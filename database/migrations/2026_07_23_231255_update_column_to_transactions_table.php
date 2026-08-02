<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Rename Columns
        |--------------------------------------------------------------------------
        */

        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('total_price', 'subtotal');
            $table->renameColumn('user_login_id', 'user_id');
        });

        /*
        |--------------------------------------------------------------------------
        | Remove Columns
        |--------------------------------------------------------------------------
        */

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'is_login',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Add Columns
        |--------------------------------------------------------------------------
        */

        Schema::table('transactions', function (Blueprint $table) {

            $table->char('currency', 3)
                ->default('IDR')
                ->after('subtotal');

            $table->json('payment_payload')
                ->nullable()
                ->after('payment_reference');
        });

        /*
        |--------------------------------------------------------------------------
        | Change transaction_code
        |--------------------------------------------------------------------------
        */

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_code')->nullable(false)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->unique('transaction_code');
        });

        /*
        |--------------------------------------------------------------------------
        | User FK
        |--------------------------------------------------------------------------
        */

        Schema::table('transactions', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->change();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropUnique(['transaction_code']);

            $table->renameColumn('subtotal', 'total_price');
            $table->renameColumn('user_id', 'user_login_id');

            $table->string('payment_type')->nullable();
            $table->integer('is_login')->default(0);

            $table->dropColumn([
                'currency',
                'payment_payload',
            ]);
        });
    }
};