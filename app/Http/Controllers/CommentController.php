<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\AppNotification;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $post->comments()->create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        if ($post->user_id && $post->user_id !== $request->user()->id) {
            AppNotification::create([
                'user_id' => $post->user_id,
                'title' => 'New comment',
                'body' => $request->user()->name.' commented on "'.$post->title.'".',
            ]);
        }

        return back()->with('status', 'Comment added.');
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        abort_unless($comment->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update($validated);

        return back()->with('status', 'Comment updated.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        abort_unless(
            auth()->user()->isAdmin() || $comment->user_id === auth()->id(),
            403
        );

        $comment->delete();

        return back()->with('status', 'Comment deleted.');
    }
}
