<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Admin */
        User::create([
            'role' => Role::admin->value,
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);
        /* Admin */

        /* User */
        User::create([
            'role' => Role::user->value,
            'name' => 'Regular User',
            'email' => 'user@user.com',
            'password' => Hash::make('123456'),
        ]);
        /* User */
    }
}
