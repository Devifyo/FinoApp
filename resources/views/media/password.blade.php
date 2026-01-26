<!DOCTYPE html>
<html>
<head>
    <title>Protected Upload</title>
</head>
<body>
    <h2>Enter Password</h2>

    @error('password')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('media.auth') }}">
        @csrf
        <input type="password" name="password" placeholder="Enter password" required>
        <br><br>
        <button type="submit">Unlock</button>
    </form>
</body>
</html>