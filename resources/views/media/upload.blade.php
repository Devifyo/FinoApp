<!DOCTYPE html>
<html>
<head>
    <title>Upload Media</title>
</head>
<body>
    <h2>Upload Media (Max 80MB)</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('file_url'))
        <p>
            Uploaded File Link:<br>
            <a href="{{ session('file_url') }}" target="_blank">
                {{ session('file_url') }}
            </a>
        </p>
    @endif

    @error('media')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="media" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>