<!DOCTYPE html>
<html>
<head>
    <title>Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto py-10">

    <h1 class="text-4xl font-bold mb-8">
         Statistics Dashboard
    </h1>

    <!-- Top liked posts -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h2 class="text-2xl font-bold mb-4">🏆 Top 10 Liked Posts</h2>

        @foreach($topPosts as $post)
            <div class="border-b py-2">
                {{ $post->title }}
                <span class="float-right">
                    ❤️ {{ $post->likes_count }}
                </span>
            </div>
        @endforeach
    </div>

    <!-- Latest posts -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h2 class="text-2xl font-bold mb-4">📝 Latest Posts</h2>

        @foreach($latestPosts as $post)
            <div class="border-b py-2">
                {{ $post->title }}
            </div>
        @endforeach
    </div>

    <!-- Latest users -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h2 class="text-2xl font-bold mb-4">👤 Newest Users</h2>

        @foreach($latestUsers as $user)
            <div class="border-b py-2">
                {{ $user->name }}
            </div>
        @endforeach
    </div>

    <!-- Recently liked -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-4">❤️ Recently Liked Posts</h2>

        @foreach($latestLikedPosts as $post)
            <div class="border-b py-2">
                {{ $post->title }}
            </div>
        @endforeach
    </div>

</div>

</body>
</html>