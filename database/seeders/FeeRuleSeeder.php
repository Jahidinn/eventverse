<?php

namespace Database\Seeders;

use App\Models\FeeRule;
use Illuminate\Database\Seeder;

class FeeRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeeRule::insert([

            [
                'name'       => 'Platform Fee',
                'code'       => 'platform_fee',
                'type'       => 'platform',
                'fee_type'   => 'fixed',
                'fee_value'  => 0,
                'fee_min'    => null,
                'fee_max'    => null,
                'is_active'  => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Organizer Fee',
                'code'       => 'organizer_fee',
                'type'       => 'organizer',
                'fee_type'   => 'fixed',
                'fee_value'  => 0,
                'fee_min'    => null,
                'fee_max'    => null,
                'is_active'  => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Withdrawal Fee',
                'code'       => 'withdrawal_fee',
                'type'       => 'withdrawal',
                'fee_type'   => 'fixed',
                'fee_value'  => 0,
                'fee_min'    => null,
                'fee_max'    => null,
                'is_active'  => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}