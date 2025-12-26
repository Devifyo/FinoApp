<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Define ALL Granular Permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // Projects Module
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',

            // Users Module
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Sub-Admins Module (Strict Access)
            'manage sub_admins', 

            // Earnings & Payouts Module
            'view earnings',
            'manage payouts', // Covers creating/editing payouts

            // Global Settings Module
            'view settings',
            'edit settings',
        ];

        // 3. Create Permissions in Database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 4. Create Roles & Assign Permissions

        // --- SUPER ADMIN (Master Access) ---
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // Admin gets EVERYTHING

        // --- SUB ADMIN (Starts Empty) ---
        // We do NOT assign permissions here because you will do it 
        // dynamically via your new "Manage Sub-Admins" UI.
        $subAdminRole = Role::firstOrCreate(['name' => 'sub_admin']);
        // Optional: Give them dashboard access by default so they don't see a blank screen
        $subAdminRole->givePermissionTo('view dashboard');

        // --- MEMBER (No Admin Access) ---
        $memberRole = Role::firstOrCreate(['name' => 'member']);
        // Members don't need any of these admin permissions.
    }
}