<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->load([
            'posts' => fn ($query) => $query->where('status', 'approved')->latest(),
            'comments.post',
        ]);

        return view('users.show', compact('user'));
    }
}
