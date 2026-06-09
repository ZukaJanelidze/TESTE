<h1>Create Post</h1>

<form method="POST" action="/posts">
    @csrf
    <input type="text" name="title" placeholder="Title">
    <br>
    <textarea name="body" placeholder="Body"></textarea>
    <br>
    <button type="submit">Save</button>
</form>