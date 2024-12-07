<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        // Create Permissions
        $permissions = [
            'manage-concessions',
            'manage-orders',
            'manage-kitchen',
            'view-orders',
            'update-order-status',
            'manage-staff'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $staffRole = Role::create(['name' => 'Staff']);

        $adminRole->givePermissionTo([
            'manage-concessions',
            'manage-orders',
            'manage-kitchen',
            'manage-staff'
        ]);

        $staffRole->givePermissionTo([
            'view-orders',
            'update-order-status',
            'manage-kitchen'
        ]);
    }
}
