<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <section class="rounded bg-white p-6 shadow dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            <p class="mt-4 text-gray-700 dark:text-gray-300">{{ $user->bio ?: 'No bio yet.' }}</p>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                {{ $user->posts->count() }} approved posts · {{ $user->comments->count() }} comments
            </div>
        </section>

        <section class="rounded bg-white p-6 shadow dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Posts</h3>
            <div class="space-y-4">
                @forelse ($user->posts as $post)
                    <article class="border-b border-gray-200 pb-4 dark:border-gray-700">
                        <div class="text-sm text-indigo-600">{{ $post->category }}</div>
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $post->title }}</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $post->body }}</p>
                    </article>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">No approved posts yet.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
