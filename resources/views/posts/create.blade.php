<x-app-layout>

    <div class="max-w-2xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">Create New Post</h1>

        <form action="{{ url('/posts') }}" method="POST" class="space-y-4">
            @csrf

            <input type="text"
                   name="title"
                   placeholder="Title"
                   class="w-full border rounded p-2">

            <select name="category" class="w-full border rounded p-2">
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>

            <textarea name="body"
                      placeholder="Body"
                      class="w-full border rounded p-2"></textarea>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Submit Post
            </button>

        </form>

    </div>

</x-app-layout>
