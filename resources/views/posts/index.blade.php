<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-6">📚 Latest Posts</h1>

    <div class="space-y-4">
        @forelse ($posts as $post)
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $post->title }}
                </h2>

                <p class="text-gray-600 mt-2">
                    {{ $post->body ?? 'No content yet...' }}
                </p>

                <p class="text-sm text-gray-400 mt-3">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        @empty
            <p class="text-gray-500">No posts found.</p>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>

</body>
</html>
