<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User if doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@impactguru.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Staff User if doesn't exist
        User::firstOrCreate(
            ['email' => 'staff@impactguru.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );
    }
}