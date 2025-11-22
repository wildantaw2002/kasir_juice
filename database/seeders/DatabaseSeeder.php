<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Kasir',
            'email' => 'admin@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_handphone' => '081234567890',
            'foto' => null,
        ]);

        // Kasir 1
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'no_handphone' => '081234567891',
            'foto' => null,
        ]);
    }
}
