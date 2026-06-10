<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class ReactionController extends Controller
{
    public function toggleLike(Post $post): RedirectResponse
    {
        auth()->user()->likedPosts()->toggle($post->id);

        return back();
    }

    public function toggleFavorite(Post $post): RedirectResponse
    {
        auth()->user()->favoritePosts()->toggle($post->id);

        return back();
    }
}
