<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id,
            'title' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'category' => fake()->randomElement([
                'General',
                'News',
                'Tutorials',
                'Personal',
                'Announcements'
            ]),
            'status' => 'approved',
            'is_featured' => fake()->boolean(10),
        ];
    }
}