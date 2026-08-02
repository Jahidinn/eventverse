<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use Illuminate\Database\Seeder;

class PaymentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'QRIS',
                'slug' => 'qris',
                'icon' => 'qris.svg',
                'sort_order' => 1,
            ],

            [
                'name' => 'Virtual Account',
                'slug' => 'virtual-account',
                'icon' => 'bank.svg',
                'sort_order' => 2,
            ],

            [
                'name' => 'E-Wallet',
                'slug' => 'e-wallet',
                'icon' => 'wallet.svg',
                'sort_order' => 3,
            ],

            [
                'name' => 'Retail Outlet',
                'slug' => 'retail-outlet',
                'icon' => 'store.svg',
                'sort_order' => 4,
            ],

            [
                'name' => 'Debit / Credit Card',
                'slug' => 'card',
                'icon' => 'credit-card.svg',
                'sort_order' => 5,
            ],

            [
                'name' => 'Direct Debit',
                'slug' => 'direct-debit',
                'icon' => 'wallet.svg',
                'sort_order' => 6,
            ],

            [
                'name' => 'PayLater',
                'slug' => 'paylater',
                'icon' => 'paylater.svg',
                'sort_order' => 7,
            ],

        ];

        foreach ($categories as $category) {
            PaymentCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}