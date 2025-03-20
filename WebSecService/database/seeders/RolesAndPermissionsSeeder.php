<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Create permissions
        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'view users',
            'edit users',
            'delete users',
            'add students',
            'edit students',
            'delete students',
            'view students'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo(Permission::all()); // Admin gets all permissions
        $user->givePermissionTo('create posts'); // Users can only create posts

        // Assign all student management permissions to admin
        $admin->givePermissionTo(['add students', 'edit students', 'delete students', 'view students']);

        // Assign a basic permission to regular users
        $user->givePermissionTo('view students');
    }
}
