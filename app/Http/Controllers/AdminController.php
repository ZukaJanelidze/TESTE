<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $role = $request->query('role');

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(in_array($role, ['user', 'manager', 'admin'], true), function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->get();

        return view('admin', [
            'users' => $users,
            'posts' => Post::latest()->get(),
            'userCount' => User::count(),
            'postCount' => Post::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'search' => $search,
            'selectedRole' => in_array($role, ['user', 'manager', 'admin'], true) ? $role : '',
        ]);
    }

    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:user,manager,admin'],
        ]);

        $user->update($validated);

        return back()->with('status', 'User role updated.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return back()->with('status', 'User deleted.');
    }

    public function destroyPost(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('status', 'Post deleted.');
    }
}
