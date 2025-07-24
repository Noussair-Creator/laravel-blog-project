<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for Posts and Comments
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit own posts']);
        Permission::create(['name' => 'delete own posts']);
        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'delete own comments']);

        // Admin-specific permissions for Posts and Comments
        Permission::create(['name' => 'view admin dashboard']);
        Permission::create(['name' => 'delete any post']);
        Permission::create(['name' => 'delete any comment']);

        // Admin-specific permissions for Categories
        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'view category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);

        // Create the 'user' role and assign its permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'create posts',
            'edit own posts',
            'delete own posts',
            'create comments',
            'delete own comments',
        ]);

        // Create the 'admin' role and give it all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
