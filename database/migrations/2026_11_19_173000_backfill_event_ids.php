<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Event::query()
            ->whereNull('event_id')
            ->orderBy('id')
            ->chunkById(100, function ($events) {
                foreach ($events as $event) {
                    $event->forceFill([
                        'event_id' => 'evt_' . Str::ulid(),
                    ])->save();
                }
            });
    }

    public function down(): void
    {
        // Event IDs are permanent public identifiers; do not remove them on rollback.
    }
};
