<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PostController;
use App\Models\Post;
Route::get('/', function () {
    $posts = Post::latest()->get();

     return view('welcome', 'home', compact('posts'));
});

Route::get('/dashboard', function () {
    $posts =Post::all();

    return view('dashboard', compact('posts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);
Route::post('/posts/{id}/update', [PostController::class, 'update']);
Route::get('/posts/{id}/delete', [PostController::class, 'destroy']);
Route::get('/test-view', function () {
    return view('posts.create');
});
route::get('admin', function(){
    if(auth()->role !== 'admin'){
        abort(403);
    }

    return view('admin');
});
// route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth');
// route::get('/profile', function (){
//             return view('profile'):
// })->middleware('auth');
route::get('/admin', function(){
    return "Admin panel";
})->middleware(['auth']);
require __DIR__.'/auth.php';

route::get ('/upload', function() {
    return view('upload');
});
route::post('/upload',[UploadController::class, 'store']);
route::get('/search', [UserController::class, 'search']);
// route::get('/profile', function (){
//     return view('profiles');
// })->middleware('auth')->name('profile');
route::resource('posts',PostController::class);

route::get('/posts', function(){
    $posts =[
        ['id' => 1, 'title' => 'My first post'],
        ['id' => 2, 'title' => 'Learning Laravel'],
        ['id' => 3, 'title' => 'Building my project'],

    ];
    return view('posts.index', compact('posts'));
});



Route::get('/posts', function () {
    $posts = Post::latest()->get();

    return view('posts.index', compact('posts'));
});