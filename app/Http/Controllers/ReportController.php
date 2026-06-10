<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function storePost(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        Report::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'reason' => $validated['reason'],
        ]);

        return back()->with('status', 'Report sent to managers.');
    }

    public function storeComment(Request $request, Comment $comment): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        Report::create([
            'user_id' => $request->user()->id,
            'comment_id' => $comment->id,
            'reason' => $validated['reason'],
        ]);

        return back()->with('status', 'Report sent to managers.');
    }

    public function resolve(Report $report): RedirectResponse
    {
        $report->update(['status' => 'resolved']);

        return back()->with('status', 'Report resolved.');
    }
}
