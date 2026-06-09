<h1>Edit Post</h1>

<form method="POST" action="route('post.update'$post">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{$post->title}}">
    <br>
    <textarea name="body">{{$post->body}}</textarea>
    <br>
    <button type="submit">Update</button>
</form>