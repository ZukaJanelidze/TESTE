<x-app-layout>
    <div class="mx-auto max-w-2xl px-4 py-10">
        <h1 class="mb-6 text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Post</h1>

        <form action="{{ route('posts.update', $post) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">

            <select name="category" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                @foreach (['General', 'News', 'Tutorials', 'Personal', 'Announcements'] as $category)
                    <option value="{{ $category }}" @selected(old('category', $post->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>

            <textarea name="body" rows="8" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('body', $post->body) }}</textarea>

            <button type="submit" class="rounded bg-indigo-600 px-4 py-2 font-medium text-white hover:bg-indigo-700">
                Save Changes
            </button>
        </form>
    </div>
</x-app-layout>
