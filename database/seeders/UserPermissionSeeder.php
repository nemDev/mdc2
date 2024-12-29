<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@admin.com')->firstOrFail();
        $user->permissions()->attach([1,2,3]);

        $user = User::where('email', 'test@test.com')->firstOrFail();
        $user->permissions()->attach([2,3]);
    }
}
