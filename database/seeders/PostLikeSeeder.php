<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostLike;
use App\Models\Post;
use App\Models\User;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    PostLike::truncate();

    $users = User::all();
    $posts = Post::all();

    foreach ($posts as $post) {

        $likeCount = rand(5, 20);

        $randomUsers = $users->random(
            min($likeCount, $users->count())
        );

        foreach ($randomUsers as $user) {

            PostLike::firstOrCreate([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
}
