<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'bio' => 'System Administrator',
            'avatar' => 'https://i.pravatar.cc/300?u=admin',
        ]);

        User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'bio' => 'Content Editor',
            'avatar' => 'https://i.pravatar.cc/300?u=editor',
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'bio' => 'Regular website user',
            'avatar' => 'https://i.pravatar.cc/300?u=user',
        ]);

        User::factory(10)->create();

        $this->command->info('Users seeded successfully!');
    }
}