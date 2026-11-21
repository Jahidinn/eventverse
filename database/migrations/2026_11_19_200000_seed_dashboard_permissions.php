<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'platform.view',
            'payments.view',
            'withdrawals.manage',
            'events.manage',
            'articles.manage',
            'users.manage',
            'roles.manage',
            'audit.view',
            'event-studio.access',
            'participants.manage',
            'finance.view',
            'checkin.manage',
            'my-event.view',
            'organization.manage',
            'profile.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findOrCreate('admin', 'web');
        $organizer = Role::findOrCreate('organizer', 'web');
        $participant = Role::findOrCreate('participant', 'web');

        $admin->givePermissionTo($permissions);
        $organizer->givePermissionTo([
            'event-studio.access',
            'participants.manage',
            'finance.view',
            'checkin.manage',
            'my-event.view',
            'organization.manage',
            'profile.manage',
        ]);
        $participant->givePermissionTo([
            'my-event.view',
            'organization.manage',
            'profile.manage',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $permissions = [
            'platform.view', 'payments.view', 'withdrawals.manage', 'events.manage',
            'articles.manage', 'users.manage', 'roles.manage', 'audit.view',
            'event-studio.access', 'participants.manage', 'finance.view',
            'checkin.manage', 'my-event.view', 'organization.manage', 'profile.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->where('guard_name', 'web')->delete();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
