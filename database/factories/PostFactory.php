<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        $content = collect($this->faker->paragraphs(10))
            ->map(fn($paragraph) => "<p>$paragraph</p>")
            ->implode('');

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $content,
            'excerpt' => $this->faker->paragraph(2), // Shorter excerpt
            'featured_image' => 'https://picsum.photos/800/400?random=' . $this->faker->randomNumber(4),
            'status' => $this->faker->randomElement(['draft', 'published', 'published', 'published']),
            'views' => $this->faker->numberBetween(0, 10000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }

    public function withViews(int $views): static
    {
        return $this->state(fn (array $attributes) => [
            'views' => $views,
        ]);
    }
}