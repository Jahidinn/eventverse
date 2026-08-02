<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        PaymentGateway::updateOrCreate(
            ['slug' => 'xendit'],
            [
                'name' => 'Xendit',
                'description' => 'Xendit Payment Gateway',
                'is_active' => true,
            ]
        );

        PaymentGateway::updateOrCreate(
            ['slug' => 'midtrans'],
            [
                'name' => 'Midtrans',
                'description' => 'Midtrans Payment Gateway',
                'is_active' => true,
            ]
        );
    }
}