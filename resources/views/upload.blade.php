<h1>Upload File</h1>

<form method="post" action="/upload" enctype="multipart/form-data">
    @csrf

    <input type="file" name="image">

    <button type="submit">Upload</button>
</form>