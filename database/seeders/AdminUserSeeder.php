<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin user.
     */
    public function run(): void
    {
        // updateOrCreate keeps this idempotent — safe to run multiple times.
        // The User model casts 'password' => 'hashed', so it is hashed automatically.
        User::updateOrCreate(
            ['email' => 'admin@infotech.com'],
            [
                'name' => 'Admin',
                'password' => 'Password@infotech',
            ]
        );
    }
}
