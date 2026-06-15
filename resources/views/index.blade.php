<!-- <form action="{{ route('posts.index') }}" method="GET">
    <input
        type="text"
        name="search"
        placeholder="Search posts..."
        value="{{ request('search') }}"
    >

    <button type="submit">
        Search
    </button>
</form> -->

<h1>Posts</h1>

<a href="/posts/create">Create Post</a>

@foreach($posts as $post)
  <h3>{{ $post->title}}</h3>
  <p>{{$post->body}}</p>

  <a href="/posts/{{ $post->id}}/edit">Edit</a>
    <a href="/posts/{{ $post->id}}/dekete">Delete</a>
    
    <hr>
    @endforeach
