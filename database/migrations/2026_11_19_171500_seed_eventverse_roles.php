<?php

use App\Models\Event;
use App\Models\OrganisationMember;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $admin = Role::findOrCreate('admin', 'web');
        $organizer = Role::findOrCreate('organizer', 'web');
        $participant = Role::findOrCreate('participant', 'web');

        $organizerIds = Event::query()
            ->whereNotNull('user_id')
            ->distinct()
            ->pluck('user_id')
            ->merge(
                OrganisationMember::query()
                    ->whereIn('position', ['Owner', 'Member'])
                    ->pluck('user_id')
            )
            ->filter()
            ->unique()
            ->flip();

        User::query()->chunkById(100, function ($users) use ($admin, $organizer, $participant, $organizerIds) {
            foreach ($users as $user) {
                if (!$user->hasRole('participant')) {
                    $user->assignRole($participant);
                }

                if ((int) $user->category_id === 2 && !$user->hasRole('admin')) {
                    $user->assignRole($admin);
                }

                if ($organizerIds->has($user->id) && !$user->hasRole('organizer')) {
                    $user->assignRole($organizer);
                }
            }
        });
    }

    public function down(): void
    {
        Role::query()
            ->whereIn('name', ['admin', 'organizer', 'participant'])
            ->where('guard_name', 'web')
            ->delete();
    }
};
