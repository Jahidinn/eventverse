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
            'competition' => [
                'label' => 'Judges',
            ],

            'seminar' => [
                'label' => 'Speakers',
            ],

            'workshop' => [
                'label' => 'Instructors',
            ],

            'conference' => [
                'label' => 'Speakers',
            ],

            'webinar' => [
                'label' => 'Speakers',
            ],

            'training' => [
                'label' => 'Instructors',
            ],

            'bootcamp' => [
                'label' => 'Instructors',
            ],

            'expo' => [
                'label' => 'Exhibitors',
            ],

            'festival' => [
                'label' => 'Line-up',
            ],

            'concert' => [
                'label' => 'Line-up',
            ],

            'art-culture' => [
                'label' => 'Line-up',
            ],

            'religious' => [
                'label' => 'Speakers',
            ],

            'career-fair' => [
                'label' => 'Speakers',
            ],
        ];

        foreach ($features as $slug => $feature) {
            $category = EventCategory::where('slug', $slug)->first();

            if (!$category) {
                $this->command->warn(
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
                    'label' => $feature['label'],
                    'is_enabled' => true,
                    'sort_order' => 10,
                ]
            );

            $this->command->info(
                "Enabled lineup: {$category->name} → {$feature['label']}"
            );
        }
    }
}