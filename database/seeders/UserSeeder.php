<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin testowy
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.pl',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Kandydat testowy
        User::create([
            'name' => 'Jan Kowalski',
            'email' => 'kandydat@test.pl',
            'password' => Hash::make('kandydat123'),
            'role' => 'kandydat',
        ]);
    }
}