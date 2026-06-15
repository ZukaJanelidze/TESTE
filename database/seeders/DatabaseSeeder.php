<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();
        Post::factory(60)->create([
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        Comment::factory()
        ->count(200)
        ->make()
        ->each(function ($comment) {
            $comment->user_id = User::inRandomOrder()->first()->id;
            $comment->post_id = Post::inRandomOrder()->first()->id;
            $comment->save();
        });
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
 $this->call(PostLikeSeeder::class);
        User::firstOrCreate(
            ['email' => 'User@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}

