<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@masjidtech.com'],
            [
                'name' => 'Admin Ustaz Hafiz',
                'email' => 'admin@masjidtech.com',
                'password' => Hash::make('password'),
                'phone' => '0123456789',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Regular member
        User::updateOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Ahmad Zaki',
                'email' => 'member@example.com',
                'password' => Hash::make('password'),
                'phone' => '0198765432',
                'role' => 'member',
                'email_verified_at' => now(),
            ]
        );
    }
}