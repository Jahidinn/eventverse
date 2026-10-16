<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use App\Models\EventCategoryFeature;
use Illuminate\Database\Seeder;

class EventCategoryFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'competition' => 'Judges',
            'seminar' => 'Speakers',
            'workshop' => 'Instructors',
            'conference' => 'Speakers',
            'webinar' => 'Speakers',
            'training' => 'Instructors',
            'bootcamp' => 'Instructors',
            'expo' => 'Exhibitors',
            'festival' => 'Line-up',
            'concert' => 'Line-up',

            'technology' => 'Speakers',
            'business' => 'Speakers',
            'education' => 'Speakers',
            'community' => 'Speakers',
            'sport' => 'Coaches',
            'art-culture' => 'Line-up',
            'food-beverage' => 'Exhibitors',
            'charity' => 'Speakers',
            'religious' => 'Speakers',
            'career-fair' => 'Speakers',
            'others' => 'Speakers',
        ];

        foreach ($features as $slug => $label) {
            $category = EventCategory::where('slug', $slug)->first();

            if (!$category) {
                $this->command?->warn(
                    "Category '{$slug}' tidak ditemukan."
                );

                continue;
            }

            EventCategoryFeature::updateOrCreate(
                [
                    'event_category_id' => $category->id,
                    'feature' => 'lineup',
                ],
                [
                    'label' => $label,
                    'is_enabled' => true,
                    'sort_order' => 10,
                ]
            );

            $this->command?->info(
                "Enabled lineup: {$category->name} -> {$label}"
            );
        }
    }
}
