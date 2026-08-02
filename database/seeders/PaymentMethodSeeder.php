<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [

            /*
            |--------------------------------------------------------------------------
            | QRIS
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'qris',
                'name' => 'QRIS',
                'slug' => 'qris',
                'code' => 'qris',
                'icon' => 'qris.svg',
                'sort_order' => 1,
            ],

            /*
            |--------------------------------------------------------------------------
            | Virtual Account
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'virtual-account',
                'name' => 'BCA Virtual Account',
                'slug' => 'bca-virtual-account',
                'code' => 'bca_va',
                'icon' => 'bca.svg',
                'sort_order' => 1,
            ],
            [
                'category' => 'virtual-account',
                'name' => 'BNI Virtual Account',
                'slug' => 'bni-virtual-account',
                'code' => 'bni_va',
                'icon' => 'bni.svg',
                'sort_order' => 2,
            ],
            [
                'category' => 'virtual-account',
                'name' => 'BRI Virtual Account',
                'slug' => 'bri-virtual-account',
                'code' => 'bri_va',
                'icon' => 'bri.svg',
                'sort_order' => 3,
            ],
            [
                'category' => 'virtual-account',
                'name' => 'Mandiri Virtual Account',
                'slug' => 'mandiri-virtual-account',
                'code' => 'mandiri_va',
                'icon' => 'mandiri.svg',
                'sort_order' => 4,
            ],
            [
                'category' => 'virtual-account',
                'name' => 'Permata Virtual Account',
                'slug' => 'permata-virtual-account',
                'code' => 'permata_va',
                'icon' => 'permata.svg',
                'sort_order' => 5,
            ],
            [
                'category' => 'virtual-account',
                'name' => 'CIMB Niaga Virtual Account',
                'slug' => 'cimb-niaga-virtual-account',
                'code' => 'cimb_va',
                'icon' => 'cimb.svg',
                'sort_order' => 6,
            ],
            [
                'category' => 'virtual-account',
                'name' => 'BSI Virtual Account',
                'slug' => 'bsi-virtual-account',
                'code' => 'bsi_va',
                'icon' => 'bsi.svg',
                'sort_order' => 7,
            ],

            /*
            |--------------------------------------------------------------------------
            | E-Wallet
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'e-wallet',
                'name' => 'GoPay',
                'slug' => 'gopay',
                'code' => 'gopay',
                'icon' => 'gopay.svg',
                'sort_order' => 1,
            ],
            [
                'category' => 'e-wallet',
                'name' => 'ShopeePay',
                'slug' => 'shopeepay',
                'code' => 'shopeepay',
                'icon' => 'shopeepay.svg',
                'sort_order' => 2,
            ],
            [
                'category' => 'e-wallet',
                'name' => 'OVO',
                'slug' => 'ovo',
                'code' => 'ovo',
                'icon' => 'ovo.svg',
                'sort_order' => 3,
            ],
            [
                'category' => 'e-wallet',
                'name' => 'DANA',
                'slug' => 'dana',
                'code' => 'dana',
                'icon' => 'dana.svg',
                'sort_order' => 4,
            ],
            [
                'category' => 'e-wallet',
                'name' => 'LinkAja',
                'slug' => 'linkaja',
                'code' => 'linkaja',
                'icon' => 'linkaja.svg',
                'sort_order' => 5,
            ],
            [
                'category' => 'e-wallet',
                'name' => 'AstraPay',
                'slug' => 'astrapay',
                'code' => 'astrapay',
                'icon' => 'astrapay.svg',
                'sort_order' => 6,
            ],

            /*
            |--------------------------------------------------------------------------
            | Retail Outlet
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'retail-outlet',
                'name' => 'Alfamart',
                'slug' => 'alfamart',
                'code' => 'alfamart',
                'icon' => 'alfamart.svg',
                'sort_order' => 1,
            ],
            [
                'category' => 'retail-outlet',
                'name' => 'Indomaret',
                'slug' => 'indomaret',
                'code' => 'indomaret',
                'icon' => 'indomaret.svg',
                'sort_order' => 2,
            ],

            /*
            |--------------------------------------------------------------------------
            | Debit / Credit Card
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'card',
                'name' => 'Debit / Credit Card',
                'slug' => 'debit-credit-card',
                'code' => 'credit_card',
                'icon' => 'visa.svg',
                'sort_order' => 1,
            ],

            /*
            |--------------------------------------------------------------------------
            | Direct Debit
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'direct-debit',
                'name' => 'BCA OneKlik',
                'slug' => 'bca-oneklik',
                'code' => 'bca_oneklik',
                'icon' => 'bca.svg',
                'sort_order' => 1,
            ],

            /*
            |--------------------------------------------------------------------------
            | PayLater
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'paylater',
                'name' => 'Kredivo',
                'slug' => 'kredivo',
                'code' => 'kredivo',
                'icon' => 'kredivo.svg',
                'sort_order' => 1,
            ],
            [
                'category' => 'paylater',
                'name' => 'Akulaku',
                'slug' => 'akulaku',
                'code' => 'akulaku',
                'icon' => 'akulaku.svg',
                'sort_order' => 2,
            ],
            [
                'category' => 'paylater',
                'name' => 'Indodana',
                'slug' => 'indodana',
                'code' => 'indodana',
                'icon' => 'indodana.svg',
                'sort_order' => 3,
            ],
            [
                'category' => 'paylater',
                'name' => 'SPayLater',
                'slug' => 'spaylater',
                'code' => 'spaylater',
                'icon' => 'spaylater.svg',
                'sort_order' => 4,
            ],

        ];

        foreach ($methods as $method) {

            $category = PaymentCategory::where('slug', $method['category'])->first();

            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                [
                    'payment_category_id' => $category->id,
                    'name' => $method['name'],
                    'slug' => $method['slug'],
                    'code' => $method['code'],
                    'icon' => $method['icon'],
                    'sort_order' => $method['sort_order'],
                    'is_active' => true,
                ]
            );

        }
    }
}