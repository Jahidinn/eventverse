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

        $permission = Permission::where('name', 'my-event.view')->where('guard_name', 'web')->first();
        $organizer = Role::where('name', 'organizer')->where('guard_name', 'web')->first();

        if ($permission && $organizer) {
            $organizer->revokePermissionTo($permission);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $permission = Permission::where('name', 'my-event.view')->where('guard_name', 'web')->first();
        $organizer = Role::where('name', 'organizer')->where('guard_name', 'web')->first();

        if ($permission && $organizer) {
            $organizer->givePermissionTo($permission);
        }
    }
};
