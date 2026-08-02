<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Competition',
            'Seminar',
            'Workshop',
            'Conference',
            'Webinar',
            'Training',
            'Bootcamp',
            'Expo',
            'Festival',
            'Concert',
            'Technology',
            'Business',
            'Education',
            'Community',
            'Sport',
            'Art & Culture',
            'Food & Beverage',
            'Charity',
            'Religious',
            'Career Fair',
            'Others',
        ];

        foreach ($categories as $index => $name) {

            EventCategory::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                [
                    'name' => $name,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

        }
    }
}