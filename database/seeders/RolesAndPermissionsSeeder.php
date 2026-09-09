<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions
        $permissions = [
            'post.create',
            'post.comment',
            'post.moderate',
            'content.view-free',
            'content.view-paid',
            'content.create',
            'content.publish',
            'content.gate',
            'users.manage',
            'payments.view',
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 2. Define Role-Permission Mappings
        $rolePermissions = [
            'Free Member' => [
                'post.create',
                'post.comment',
                'content.view-free',
            ],
            'Paid Subscriber' => [
                'post.create',
                'post.comment',
                'content.view-free',
                'content.view-paid',
            ],
            'Instructor' => [
                'post.create',
                'post.comment',
                'content.view-free',
                'content.view-paid',
                'content.create',
                'content.publish',
                'content.gate',
            ],
            'Moderator' => [
                'post.moderate',
                'content.view-free',
            ],
            'Admin' => $permissions,
        ];

        // 3. Create Roles & Sync Permissions
        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }
    }
}
