<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\OrganisationMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::findOrCreate('admin', 'web');
        $organizer = Role::findOrCreate('organizer', 'web');
        $participant = Role::findOrCreate('participant', 'web');

        $permissions = [
            'platform.view', 'payments.view', 'withdrawals.manage', 'events.manage',
            'articles.manage', 'articles.create', 'users.manage', 'roles.manage', 'audit.view',
            'event-studio.access', 'participants.manage', 'finance.view',
            'checkin.manage', 'organization.manage', 'profile.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin->givePermissionTo($permissions);
        $organizer->givePermissionTo([
            'event-studio.access', 'participants.manage', 'finance.view',
            'checkin.manage', 'organization.manage', 'profile.manage',
            'articles.create',
        ]);
        $participant->givePermissionTo([
            'my-event.view', 'organization.manage', 'profile.manage',
        ]);

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
}
