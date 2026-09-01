<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_gateway_methods', function (Blueprint $table) {
            $table->string('sub_code')
                ->nullable()
                ->after('gateway_code');
        });

        /*
        |--------------------------------------------------------------------------
        | Copy Xendit -> Midtrans
        |--------------------------------------------------------------------------
        |
        | Xendit
        | gateway_id = 1
        |
        | Midtrans
        | gateway_id = 2
        |
        */

        $xenditMethods = DB::table('payment_gateway_methods')
            ->where('payment_gateway_id', 1)
            ->get();

        foreach ($xenditMethods as $method) {

            $mapping = match ($method->gateway_code) {

                'QRIS' => [
                    'gateway_code' => 'qris',
                    'sub_code' => null,
                ],

                'BCA_VIRTUAL_ACCOUNT' => [
                    'gateway_code' => 'bank_transfer',
                    'sub_code' => 'bca',
                ],

                'BNI_VIRTUAL_ACCOUNT' => [
                    'gateway_code' => 'bank_transfer',
                    'sub_code' => 'bni',
                ],

                'BRI_VIRTUAL_ACCOUNT' => [
                    'gateway_code' => 'bank_transfer',
                    'sub_code' => 'bri',
                ],

                'MANDIRI_VIRTUAL_ACCOUNT' => [
                    'gateway_code' => 'bank_transfer',
                    'sub_code' => 'mandiri',
                ],

                'PERMATA_VIRTUAL_ACCOUNT' => [
                    'gateway_code' => 'bank_transfer',
                    'sub_code' => 'permata',
                ],

                'GOPAY' => [
                    'gateway_code' => 'gopay',
                    'sub_code' => null,
                ],

                'SHOPEEPAY' => [
                    'gateway_code' => 'shopeepay',
                    'sub_code' => null,
                ],

                'ALFAMART' => [
                    'gateway_code' => 'cstore',
                    'sub_code' => 'alfamart',
                ],

                'CREDIT_CARD' => [
                    'gateway_code' => 'credit_card',
                    'sub_code' => null,
                ],

                default => null,
            };

            if (!$mapping) {
                continue;
            }

            DB::table('payment_gateway_methods')->insert([
                'payment_gateway_id' => 2,

                'payment_method_id' => $method->payment_method_id,

                'gateway_code' => $mapping['gateway_code'],

                'sub_code' => $mapping['sub_code'],

                'fee_type' => $method->fee_type,

                'fee_value' => $method->fee_value,

                'fee_min' => $method->fee_min,

                'fee_max' => $method->fee_max,

                'is_active' => $method->is_active,

                'sort_order' => $method->sort_order,

                'created_at' => $method->created_at,

                'updated_at' => $method->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus payment method Midtrans
        |--------------------------------------------------------------------------
        */

        DB::table('payment_gateway_methods')
            ->where('payment_gateway_id', 2)
            ->delete();

        Schema::table('payment_gateway_methods', function (Blueprint $table) {
            $table->dropColumn('sub_code');
        });
    }
};