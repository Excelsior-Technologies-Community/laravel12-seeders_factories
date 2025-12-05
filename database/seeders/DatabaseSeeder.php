<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear all tables
        Schema::disableForeignKeyConstraints();
        
        User::truncate();
        Category::truncate();
        Post::truncate();
        Comment::truncate();
        
        Schema::enableForeignKeyConstraints();

        // Create specific users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'bio' => 'System Administrator',
            'avatar' => 'https://i.pravatar.cc/300?u=admin',
            'email_verified_at' => now(),
        ]);

        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'bio' => 'Content Editor',
            'avatar' => 'https://i.pravatar.cc/300?u=editor',
            'email_verified_at' => now(),
        ]);

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'bio' => 'Regular website user',
            'avatar' => 'https://i.pravatar.cc/300?u=user',
            'email_verified_at' => now(),
        ]);

        // Create 10 random users
        $users = User::factory()->count(10)->create();

        // Create categories
        $categories = Category::factory()->count(15)->create();

        // Create subcategories
        $mainCategories = $categories->take(5);
        foreach ($mainCategories as $mainCategory) {
            Category::factory()->count(3)
                ->create(['parent_id' => $mainCategory->id]);
        }

        // Get all categories including subcategories
        $allCategories = Category::all();

        // Create posts with categories
        $posts = Post::factory()->count(50)->create();

        // Attach categories to posts
        foreach ($posts as $post) {
            $postCategories = $allCategories->random(rand(1, 3));
            $post->categories()->attach($postCategories);
        }

        // Create comments
        $comments = Comment::factory()->count(200)->create(['is_approved' => true]);

        // Create replies to some comments
        foreach ($comments->take(50) as $parentComment) {
            Comment::factory()->count(rand(1, 3))
                ->create([
                    'parent_id' => $parentComment->id,
                    'is_approved' => true,
                    'post_id' => $parentComment->post_id
                ]);
        }

        // Create some unapproved comments
        Comment::factory()->count(30)->create(['is_approved' => false]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('================================');
        $this->command->info('Admin: admin@example.com / password123');
        $this->command->info('Editor: editor@example.com / password123');
        $this->command->info('User: user@example.com / password123');
        $this->command->info('================================');
        $this->command->info('Total Users: ' . User::count());
        $this->command->info('Total Posts: ' . Post::count());
        $this->command->info('Total Categories: ' . Category::count());
        $this->command->info('Total Comments: ' . Comment::count());
    }
}