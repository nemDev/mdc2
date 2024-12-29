<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'username' => 'Test',
            'email'    => 'test@test.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'username' => 'Test1',
            'email'    => 'test1@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
