<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewayMethod;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentGatewayMethodSeeder extends Seeder
{
    public function run(): void
    {
        $gateway = PaymentGateway::where('slug', 'xendit')->first();

        $methods = [

            // ==========================
            // QRIS
            // ==========================

            [
                'code' => 'qris',
                'gateway_code' => 'QRIS',
                'fee_type' => 'percent',
                'fee_value' => 0.70,
                'sort_order' => 1,
            ],

            // ==========================
            // Virtual Account
            // ==========================

            [
                'code' => 'bca_va',
                'gateway_code' => 'BCA',
                'fee_type' => 'fixed',
                'fee_value' => 4500,
                'sort_order' => 2,
            ],
            [
                'code' => 'bni_va',
                'gateway_code' => 'BNI',
                'fee_type' => 'fixed',
                'fee_value' => 4500,
                'sort_order' => 3,
            ],
            [
                'code' => 'bri_va',
                'gateway_code' => 'BRI',
                'fee_type' => 'fixed',
                'fee_value' => 4500,
                'sort_order' => 4,
            ],
            [
                'code' => 'mandiri_va',
                'gateway_code' => 'MANDIRI',
                'fee_type' => 'fixed',
                'fee_value' => 4500,
                'sort_order' => 5,
            ],
            [
                'code' => 'permata_va',
                'gateway_code' => 'PERMATA',
                'fee_type' => 'fixed',
                'fee_value' => 4500,
                'sort_order' => 6,
            ],

            // ==========================
            // E-Wallet
            // ==========================

            [
                'code' => 'gopay',
                'gateway_code' => 'GOPAY',
                'fee_type' => 'fixed',
                'fee_value' => 1000,
                'sort_order' => 7,
            ],
            [
                'code' => 'shopeepay',
                'gateway_code' => 'SHOPEEPAY',
                'fee_type' => 'fixed',
                'fee_value' => 1000,
                'sort_order' => 8,
            ],

            // ==========================
            // Retail Outlet
            // ==========================

            [
                'code' => 'alfamart',
                'gateway_code' => 'ALFAMART',
                'fee_type' => 'fixed',
                'fee_value' => 5000,
                'sort_order' => 9,
            ],

            // ==========================
            // Card
            // ==========================

            [
                'code' => 'credit_card',
                'gateway_code' => 'CREDIT_CARD',
                'fee_type' => 'percent',
                'fee_value' => 2.90,
                'sort_order' => 10,
            ],

        ];

        foreach ($methods as $item) {

            $method = PaymentMethod::where('code', $item['code'])->first();

            if (! $method) {
                continue;
            }

            PaymentGatewayMethod::updateOrCreate(
                [
                    'payment_gateway_id' => $gateway->id,
                    'payment_method_id' => $method->id,
                ],
                [
                    'gateway_code' => $item['gateway_code'],
                    'fee_type' => $item['fee_type'],
                    'fee_value' => $item['fee_value'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}