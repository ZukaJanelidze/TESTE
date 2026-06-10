<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    

    

    public function index()
    {
        $posts = Post::with(['comments.user'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('dashboard', compact('posts'));
    }

    
    public function create()
    {
        return view('posts.create', [
            'categories' => ['General', 'News', 'Tutorials', 'Personal', 'Announcements'],
        ]);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category' => ['required', 'string', 'max:50'],
        ]);

        Post::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category' => $validated['category'],
            'status' => $request->user()->canModerate() ? 'approved' : 'pending',
        ]);

        return redirect()->route('dashboard')->with('status', 'Post submitted.');
    }

    
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        abort_unless($request->user()->canModerate() || $post->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category' => ['required', 'string', 'max:50'],
        ]);

        $post->update($validated + [
            'status' => $request->user()->canModerate() ? $post->status : 'pending',
            'rejection_reason' => null,
        ]);

        return redirect()->route('dashboard')->with('status', 'Post updated.');
    }

    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        abort_unless(auth()->user()->canModerate() || $post->user_id === auth()->id(), 403);

        $post->delete();

        return redirect()->route('dashboard')->with('status', 'Post deleted.');
    }
    
    public function show (Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        abort_unless(auth()->user()->canModerate() || $post->user_id === auth()->id(), 403);

        return view('posts.edit', compact('post'));
    }

    public function dashboard()
    {
          $posts = Post::with(['comments.user'])->where('status', 'approved')->latest()->get();

          return view ('dashboard', compact('posts'));
    }
}

