<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Dashboard
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="mb-8 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Welcome back, {{ auth()->user()->name }}
                        </h1>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">
                            Read posts, save favorites, join comments, and share your own ideas.
                        </p>
                    </div>
                    <a href="{{ route('posts.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-indigo-700">
                        Create Post
                    </a>
                </div>
            </section>

            @if (session('status'))
                <div class="mb-6 rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($notifications->isNotEmpty())
                <section class="mb-8 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Notifications</h2>
                    <div class="space-y-3">
                        @foreach ($notifications as $notification)
                            <div class="flex flex-col gap-2 rounded bg-gray-50 p-3 dark:bg-gray-900 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $notification->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $notification->body }}</p>
                                </div>
                                @if (! $notification->read_at)
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Mark read</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Sidebar -->
                <aside class="space-y-6 lg:col-span-1">
                    <div class="rounded-2xl bg-white p-5 shadow-lg ring-1 ring-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="h-14 w-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                            <div>
                                <div class="font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                                <div class="text-sm text-slate-500">{{ auth()->user()->email }}</div>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-slate-600">{{ auth()->user()->profile ?? 'A short bio goes here.' }}</p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('profile.edit') }}" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">Edit Profile</a>
                            <a href="{{ route('posts.create') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">New Post</a>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-5 shadow-lg ring-1 ring-gray-100">
                        <h3 class="text-sm font-semibold text-slate-900">Categories</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($categories as $cat)
                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs text-indigo-700">{{ $cat }}</span>
                            @endforeach
                        </div>
                    </div>

                    @if ($notifications->isNotEmpty())
                        <div class="rounded-2xl bg-white p-4 shadow-lg ring-1 ring-gray-100">
                            <h3 class="text-sm font-semibold text-slate-900">Notifications</h3>
                            <div class="mt-3 space-y-2">
                                @foreach ($notifications as $notification)
                                    <div class="rounded-lg bg-slate-50 p-3 text-sm text-slate-700">{{ $notification->title }} — <span class="text-xs text-slate-500">{{ $notification->body }}</span></div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>

                <!-- Main feed -->
                <section class="lg:col-span-2">
                    <div class="mb-6 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl bg-white p-5 shadow-lg ring-1 ring-gray-100">
                            <p class="text-sm text-slate-500">Visible Posts</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $posts->total() }}</p>
                        </div>
                        <div class="rounded-2xl bg-white p-5 shadow-lg ring-1 ring-gray-100">
                            <p class="text-sm text-slate-500">Featured</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $featuredCount }}</p>
                        </div>
                        <div class="rounded-2xl bg-white p-5 shadow-lg ring-1 ring-gray-100">
                            <p class="text-sm text-slate-500">Saved</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">{{ auth()->user()->favoritePosts()->count() }}</p>
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-1">
                        @forelse ($posts as $post)
                            <article class="rounded-2xl bg-white shadow-lg ring-1 ring-gray-100 overflow-hidden transform transition hover:-translate-y-1 hover:shadow-xl">
                                <div class="border-b border-gray-100 p-5">
                            <div class="mb-3 flex flex-wrap gap-2 text-xs">
                                <span class="rounded bg-indigo-100 px-2 py-1 font-medium text-indigo-700">{{ $post->category }}</span>
                                @if ($post->is_featured)
                                    <span class="rounded bg-yellow-100 px-2 py-1 font-medium text-yellow-700">Featured</span>
                                @endif
                                @if ($post->status !== 'approved')
                                    <span class="rounded bg-gray-100 px-2 py-1 font-medium text-gray-700">{{ ucfirst($post->status) }}</span>
                                @endif
                            </div>

                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $post->body }}</p>

                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                By
                                @if ($post->user)
                                    <a href="{{ route('users.show', $post->user) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                        {{ $post->user->name }}
                                    </a>
                                @else
                                    Unknown
                                @endif
                                · {{ $post->created_at->diffForHumans() }}
                            </div>

                            @if ($post->status === 'rejected' && $post->rejection_reason)
                                <p class="mt-3 rounded bg-red-50 p-3 text-sm text-red-700">{{ $post->rejection_reason }}</p>
                            @endif

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <form method="POST" action="{{ route('posts.like', $post) }}">
                                    @csrf
                                    <button class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900">
                                        {{ $post->likedByUsers->contains(auth()->id()) ? 'Liked' : 'Like' }}
                                        {{ $post->likedByUsers->count() }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('posts.favorite', $post) }}">
                                    @csrf
                                    <button class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900">
                                        {{ $post->favoritedByUsers->contains(auth()->id()) ? 'Saved' : 'Save' }}
                                    </button>
                                </form>

                                @if (auth()->user()->canModerate() || $post->user_id === auth()->id())
                                    <a href="{{ route('posts.edit', $post) }}" class="rounded bg-yellow-500 px-3 py-1 text-sm text-white hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this post?')" class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('posts.report', $post) }}" class="mt-4 flex gap-2">
                                @csrf
                                <input name="reason" placeholder="Report reason" class="min-w-0 flex-1 rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <button class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-900">
                                    Report
                                </button>
                            </form>
                        </div>

                            <div class="p-5">
                            <div class="mb-3 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Comments</h3>
                                <span class="text-xs text-gray-400">{{ $post->comments->count() }}</span>
                            </div>

                            <div class="space-y-3">
                                @forelse ($post->comments->take(4) as $comment)
                                    <div class="rounded bg-gray-50 p-3 dark:bg-gray-900">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0 flex-1">
                                                <a href="{{ route('users.show', $comment->user) }}" class="text-xs font-semibold text-gray-700 hover:text-indigo-600 dark:text-gray-200">
                                                    {{ $comment->user->name }}
                                                </a>

                                                @if ($comment->user_id === auth()->id())
                                                    <form method="POST" action="{{ route('comments.update', $comment) }}" class="mt-2 flex gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input name="body" value="{{ $comment->body }}" class="min-w-0 flex-1 rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100">
                                                        <button class="text-xs font-medium text-indigo-600">Save</button>
                                                    </form>
                                                @else
                                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $comment->body }}</p>
                                                @endif
                                            </div>

                                            @if (auth()->user()->canModerate() || $comment->user_id === auth()->id())
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-xs font-medium text-red-500 hover:text-red-700">Delete</button>
                                                </form>
                                            @endif
                                        </div>

                                        <form method="POST" action="{{ route('comments.report', $comment) }}" class="mt-2 flex gap-2">
                                            @csrf
                                            <input name="reason" placeholder="Report reason" class="min-w-0 flex-1 rounded border-gray-300 text-xs dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100">
                                            <button class="text-xs font-medium text-gray-500 hover:text-gray-700">Report</button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
                                @endforelse
                            </div>

                            @if ($post->status === 'approved')
                                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4 space-y-2">
                                    @csrf
                                    <textarea name="body" rows="2" placeholder="Write a comment" class="w-full rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required></textarea>
                                    <button class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700 shadow-sm">
                                        Comment
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl bg-white p-8 text-center text-slate-500 shadow-lg lg:col-span-2">
                        No posts yet.
                    </div>
                @endforelse
            </div>

            <div class="mt-6 flex items-center justify-center">{{ $posts->links() }}</div>
        </div>
    </div>
</x-app-layout>
