<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    
    public function create()
    {
        return view('posts.create');
    }

    
    public function store(Request $request)
    {
        Post::create([
            'title' => $request->title,
            'body'  => $request->body,
        ]);

        return redirect('/posts');
    }

    
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'body'  => $request->body,
        ]);

        return redirect('/posts');
    }

    
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return redirect('/posts');
    }
    
    public function show (Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }
}

