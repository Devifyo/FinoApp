<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the User
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'], 
            [
                'name' => 'Super Admin',
                'password' => Hash::make('pass@admin'),
                'role' => 'admin', // This is your legacy column
            ]
        );

        // 2. Assign the Spatie Role
        // This grants all the permissions we defined in RolesAndPermissionsSeeder
        $admin->assignRole('admin');
    }
}