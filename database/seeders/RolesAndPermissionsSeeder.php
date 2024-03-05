<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create roles
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage roles']);

        // Assign permissions to roles
        $superadminRole = Role::findByName('superadmin');
        $superadminRole->givePermissionTo(['manage users', 'manage roles']);

        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo('manage users');

        // Assign roles to users if needed
    }
}
