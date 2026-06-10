<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
             Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 dark:bg-gray-900 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- TOP HERO -->
            <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-purple-600 text-white rounded-3xl p-8 shadow-xl mb-8">
                <h1 class="text-3xl font-bold">
                    Welcome back, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-blue-100 mt-2">
                    Manage your posts, track content, and grow your blog.
                </p>
            </div>

            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <p class="text-gray-500 dark:text-gray-400">Total Posts</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $posts->count() }}
                    </h3>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <p class="text-gray-500 dark:text-gray-400">Latest Post</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-2">
                        {{ optional($posts->first())->title ?? 'No posts yet' }}
                    </h3>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <p class="text-gray-500 dark:text-gray-400">Status</p>
                    <h3 class="text-2xl font-bold text-green-500 mt-2">
                        Active
                    </h3>
                </div>

            </div>

            <!-- HEADER ACTION BAR -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">

                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                    Your Posts
                </h2>

                <a href="{{ url('/posts/create') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow-md transition text-center">
                    + Create New Post
                </a>

            </div>

            <!-- POSTS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($posts as $post)

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-2xl transition overflow-hidden">

                        <!-- Card Top Accent -->
                        <div class="h-2 bg-gradient-to-r from-indigo-500 via-blue-500 to-purple-500"></div>

                        <div class="p-6">

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                {{ $post->title }}
                            </h3>

                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                {{ $post->content }}
                            </p>

                            <div class="flex justify-between items-center mt-4">

                                <a href="{{ route('posts.edit', $post->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('Delete this post?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                        Delete
                                    </button>
                                </form>

                            </div>

                            <p class="text-xs text-gray-400 mt-4">
                                {{ $post->created_at->diffForHumans() }}
                            </p>

                        </div>
                    </div>

                @empty

                    <div class="col-span-3 text-center text-gray-500 mt-10">
                        No posts yet — create your first one 🚀
                    </div>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>