<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PostLike;


class PostController extends Controller
{
    

    

    public function index()
    {
    $posts = Post::with(['comments.user'])
        ->where('status', 'approved')
        ->latest()
        ->paginate(10);

    $query =Post::query();
        if ($request->filled('search')){
            
            $query->where('title', 'like', '%'. $request->search .'%')
                  ->orWhere('body', 'like', '%'. $request->search .'%');
                
        
    }
    $posts = $query->latest()->get();

    return view('posts.index', compact('posts'));
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
            $posts = Post::with(['comments.user'])
              ->where('status', 'approved')
              ->latest()
              ->paginate(10);

            $featuredCount = Post::where('status', 'approved')->where('is_featured', true)->count();

            return view('dashboard', compact('posts', 'featuredCount'));
    }

    public function topLiked()
    {
        $posts =Post::withCount('likes')
        ->orderByDesc('likes_count')
        ->take(10)
        ->get();

        return view('posts.top-liked', compact('posts'));
    }

    public function latestPosts()
    {
           $posts = Post::latest()
           ->take(10)
           ->get();

           return view('posts.latest', compact('posts'));
    }

    public function newestUsers()
    {
        $users = User::latest()
        ->take(10)
        ->get();

        return view('users.newest', compact('users'));
    }

    public function statistics()
    {

            $topPosts = Post::withCount('likes')
        ->where('status', 'approved')
        ->orderByDesc('likes_count')
        ->take(10)
        ->get();

    $latestPosts = Post::where('status', 'approved')
        ->latest()
        ->take(10)
        ->get();

    $latestUsers = User::latest()
        ->take(10)
        ->get();

    $latestLikedPosts = Post::whereIn(
            'id',
            PostLike::latest()
                ->take(10)
                ->pluck('post_id')
        )
        ->get();

    return view('statistics', compact(
        'topPosts',
        'latestPosts',
        'latestUsers',
        'latestLikedPosts'
    ));
    
  }

//      public function statistics()
// {
//     $topPosts = Post::withCount('likes')
//         ->where('status', 'approved')
//         ->orderByDesc('likes_count')
//         ->take(10)
//         ->get();

//     $latestPosts = Post::where('status', 'approved')
//         ->latest()
//         ->take(10)
//         ->get();

//     $latestUsers = User::latest()
//         ->take(10)
//         ->get();

//     $latestLikedPosts = Post::whereIn(
//             'id',
//             PostLike::latest()
//                 ->take(10)
//                 ->pluck('post_id')
//         )
//         ->get();

//     return view('statistics', compact(
//         'topPosts',
//         'latestPosts',
//         'latestUsers',
//         'latestLikedPosts'
//     ));
// }

   





}