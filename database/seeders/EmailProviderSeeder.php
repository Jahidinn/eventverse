<?php

namespace Database\Seeders;

use App\Models\EmailProvider;
use Illuminate\Database\Seeder;

class EmailProviderSeeder extends Seeder
{
    public function run(): void
    {
        EmailProvider::updateOrCreate(
            ['code' => 'shared'],
            [
                'name' => 'Shared SMTP',
                'driver' => 'smtp',
                'hourly_limit' => 100,
                'priority' => 1,
                'is_active' => true,
            ]
        );

        EmailProvider::updateOrCreate(
            ['code' => 'ses'],
            [
                'name' => 'Amazon SES',
                'driver' => 'ses',
                'hourly_limit' => null,
                'priority' => 2,
                'is_active' => true,
            ]
        );
    }
}