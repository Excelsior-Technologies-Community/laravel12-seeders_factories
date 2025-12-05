<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'content' => fake()->paragraph(),
            'parent_id' => null,
            'is_approved' => fake()->boolean(80), // 80% chance of being approved
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    public function unapproved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }

    public function replyTo($commentId): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $commentId,
        ]);
    }
}