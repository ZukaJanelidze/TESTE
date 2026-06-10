<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Manager Panel
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded bg-white p-5 shadow dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pending Posts</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingPosts->count() }}</p>
            </div>
            <div class="rounded bg-white p-5 shadow dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Approved Posts</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $approvedPosts->count() }}</p>
            </div>
            <div class="rounded bg-white p-5 shadow dark:bg-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Open Reports</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $reports->count() }}</p>
            </div>
        </div>

        <section class="rounded bg-white shadow dark:bg-gray-800">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pending Approval</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($pendingPosts as $post)
                    <article class="p-5">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div>
                                <p class="text-xs font-medium text-indigo-600">{{ $post->category }}</p>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h4>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $post->body }}</p>
                                <p class="mt-2 text-xs text-gray-400">By {{ $post->user->name ?? 'Unknown' }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <form method="POST" action="{{ route('manager.posts.approve', $post) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('manager.posts.reject', $post) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input name="rejection_reason" placeholder="Reason" class="w-40 rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                    <button class="rounded bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Reject</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="p-5 text-sm text-gray-500 dark:text-gray-400">No pending posts.</div>
                @endforelse
            </div>
        </section>

        <section class="rounded bg-white shadow dark:bg-gray-800">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Approved Posts</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($approvedPosts as $post)
                    <article class="p-5">
                        <form method="POST" action="{{ route('manager.posts.update', $post) }}" class="grid gap-3 lg:grid-cols-[1fr_160px_auto]">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-2">
                                <input name="title" value="{{ $post->title }}" class="w-full rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <textarea name="body" rows="3" class="w-full rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ $post->body }}</textarea>
                            </div>
                            <select name="category" class="h-10 rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                @foreach (['General', 'News', 'Tutorials', 'Personal', 'Announcements'] as $category)
                                    <option value="{{ $category }}" @selected($post->category === $category)>{{ $category }}</option>
                                @endforeach
                            </select>
                            <button class="h-10 rounded bg-indigo-600 px-4 text-sm font-medium text-white hover:bg-indigo-700">Save</button>
                        </form>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('manager.posts.featured', $post) }}">
                                @csrf
                                @method('PATCH')
                                <button class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900">
                                    {{ $post->is_featured ? 'Unfeature' : 'Feature' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('manager.posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this post?')" class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="p-5 text-sm text-gray-500 dark:text-gray-400">No approved posts.</div>
                @endforelse
            </div>
        </section>

        <section class="rounded bg-white shadow dark:bg-gray-800">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Reports Queue</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($reports as $report)
                    <article class="p-5">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Reported by {{ $report->user->name }}
                                </p>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $report->reason }}</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    @if ($report->post)
                                        Post: {{ $report->post->title }}
                                    @elseif ($report->comment)
                                        Comment by {{ $report->comment->user->name ?? 'Unknown' }}: {{ $report->comment->body }}
                                    @endif
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if ($report->comment)
                                    <form method="POST" action="{{ route('manager.comments.destroy', $report->comment) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">Delete Comment</button>
                                    </form>
                                @endif
                                @if ($report->post)
                                    <form method="POST" action="{{ route('manager.posts.destroy', $report->post) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">Delete Post</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('manager.reports.resolve', $report) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900">Resolve</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="p-5 text-sm text-gray-500 dark:text-gray-400">No open reports.</div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
