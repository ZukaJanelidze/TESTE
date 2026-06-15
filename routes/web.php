<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\NotificationController;
use App\Models\Post;
Route::get('/', function () {
    $posts = Post::where('status', 'approved')->latest()->get();

     return view('welcome', compact('posts'));
});

Route::get('/dashboard', function () {
    $posts = Post::with(['comments.user', 'likedByUsers', 'favoritedByUsers', 'user'])
        ->where(function ($query) {
            $query->where('status', 'approved')
                ->orWhere('user_id', auth()->id());
        })
        ->orderByDesc('is_featured')
        ->latest()
        ->paginate(10);

        $categories = ['General', 'News', 'Tutorials', 'Personal', 'Announcements'];
        $notifications = auth()->user()->notifications()->latest()->take(5)->get();
        $featuredCount = Post::where('status', 'approved')->where('is_featured', true)->count();

        return view('dashboard', compact('posts', 'categories', 'notifications', 'featuredCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class)->except(['index', 'show']);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/posts/{post}/like', [ReactionController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{post}/favorite', [ReactionController::class, 'toggleFavorite'])->name('posts.favorite');
    Route::post('/posts/{post}/report', [ReportController::class, 'storePost'])->name('posts.report');
    Route::post('/comments/{comment}/report', [ReportController::class, 'storeComment'])->name('comments.report');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});

Route::get('/test-view', function () {
    return view('posts.create');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');
});

Route::middleware(['auth', 'manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/', [ManagerController::class, 'index'])->name('index');
    Route::patch('/posts/{post}/approve', [ManagerController::class, 'approve'])->name('posts.approve');
    Route::patch('/posts/{post}/reject', [ManagerController::class, 'reject'])->name('posts.reject');
    Route::patch('/posts/{post}/featured', [ManagerController::class, 'toggleFeatured'])->name('posts.featured');
    Route::patch('/posts/{post}', [ManagerController::class, 'updatePost'])->name('posts.update');
    Route::delete('/posts/{post}', [ManagerController::class, 'destroyPost'])->name('posts.destroy');
    Route::delete('/comments/{comment}', [ManagerController::class, 'destroyComment'])->name('comments.destroy');
    Route::patch('/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');
});
// route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth');
// route::get('/profile', function (){
//             return view('profile'):
// })->middleware('auth');
require __DIR__.'/auth.php';

route::get ('/upload', function() {
    return view('upload');
});
route::post('/upload',[UploadController::class, 'store']);
route::get('/search', [UserController::class, 'search'])->name('search');
Route::get('/users/{user}', [PublicProfileController::class, 'show'])->name('users.show');

route::post('/admin/users/{user}/ban',[AdminController::class, 'ban'])->name('admin.users.ban');
route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');
route::get('/top-liked', [PostController::class, 'topLiked']);
route::get('/statistics',[PostController::class, 'statistics'])->name('statistics');