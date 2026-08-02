<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $table->unsignedBigInteger('payment_gateway_method_id')
                ->nullable()
                ->after('status');

            $table->dropColumn([
                'payment_provider',
                'payment_method',
            ]);

            $table->foreign('payment_gateway_method_id')
                ->references('id')
                ->on('payment_gateway_methods');

        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $table->string('payment_provider')
                ->nullable()
                ->after('status');

            $table->string('payment_method')
                ->nullable()
                ->after('payment_provider');

            $table->dropForeign([
                'payment_gateway_method_id'
            ]);

            $table->dropColumn(
                'payment_gateway_method_id'
            );

        });
    }
};