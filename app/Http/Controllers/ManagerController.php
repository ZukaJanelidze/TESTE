<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    public function index(): View
    {
        return view('manager', [
            'pendingPosts' => Post::with('user')->where('status', 'pending')->latest()->get(),
            'approvedPosts' => Post::with('user')->where('status', 'approved')->latest()->get(),
            'reports' => Report::with(['user', 'post', 'comment.user'])->where('status', 'open')->latest()->get(),
        ]);
    }

    public function approve(Post $post): RedirectResponse
    {
        $post->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        $this->notifyPostOwner($post, 'Post approved', 'Your post "'.$post->title.'" is now live.');

        return back()->with('status', 'Post approved.');
    }

    public function reject(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $post->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        $this->notifyPostOwner($post, 'Post rejected', $post->rejection_reason ?: 'Your post needs changes before it can go live.');

        return back()->with('status', 'Post rejected.');
    }

    public function toggleFeatured(Post $post): RedirectResponse
    {
        $post->update(['is_featured' => ! $post->is_featured]);

        return back()->with('status', 'Featured status updated.');
    }

    public function updatePost(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category' => ['required', 'string', 'max:50'],
        ]);

        $post->update($validated);

        return back()->with('status', 'Post updated.');
    }

    public function destroyPost(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('status', 'Post deleted.');
    }

    public function destroyComment(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('status', 'Comment deleted.');
    }

    private function notifyPostOwner(Post $post, string $title, string $body): void
    {
        if (! $post->user_id) {
            return;
        }

        AppNotification::create([
            'user_id' => $post->user_id,
            'title' => $title,
            'body' => $body,
        ]);
    }
}
