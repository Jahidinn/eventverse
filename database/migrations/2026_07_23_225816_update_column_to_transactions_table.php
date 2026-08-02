<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Buyer
            |--------------------------------------------------------------------------
            */

            $table->renameColumn('name', 'buyer_name');
            $table->renameColumn('email', 'buyer_email');
            $table->renameColumn('phone', 'buyer_phone');

            /*
            |--------------------------------------------------------------------------
            | Transaction
            |--------------------------------------------------------------------------
            */

            $table->renameColumn('transaction_id', 'transaction_code');

            /*
            |--------------------------------------------------------------------------
            | Remove Old Columns
            |--------------------------------------------------------------------------
            */

            $table->dropColumn([
                'checkin',
                'admin_check',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            $table->string('payment_provider')->nullable()->after('status');
            $table->string('payment_method')->nullable()->after('payment_provider');
            $table->string('payment_reference')->nullable()->after('payment_method');

            /*
            |--------------------------------------------------------------------------
            | Payment Date
            |--------------------------------------------------------------------------
            */

            $table->timestamp('paid_at')->nullable()->after('payment_reference');
            $table->timestamp('expired_at')->nullable()->after('paid_at');
        });

        DB::statement("
            ALTER TABLE transactions
            MODIFY status ENUM(
                'Pending',
                'Paid',
                'Expired',
                'Cancelled',
                'Refunded'
            ) NOT NULL DEFAULT 'Pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE transactions
            MODIFY status ENUM(
                'Paid',
                'Unpaid'
            ) NOT NULL DEFAULT 'Unpaid'
        ");

        Schema::table('transactions', function (Blueprint $table) {

            $table->renameColumn('buyer_name', 'name');
            $table->renameColumn('buyer_email', 'email');
            $table->renameColumn('buyer_phone', 'phone');

            $table->renameColumn('transaction_code', 'transaction_id');

            $table->timestamp('checkin')->nullable();
            $table->timestamp('admin_check')->nullable();

            $table->dropColumn([
                'payment_provider',
                'payment_method',
                'payment_reference',
                'paid_at',
                'expired_at',
            ]);
        });
    }
};