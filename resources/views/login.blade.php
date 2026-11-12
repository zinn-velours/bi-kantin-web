<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Bi-Kantin</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; display: flex; justify-content: center; padding-top: 80px; }
        .card { background: #fff; padding: 24px; border-radius: 8px; width: 320px; box-shadow: 0 1px 4px #0002; }
        input { width: 100%; padding: 8px; margin: 4px 0 12px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #1f7a4d; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        .error { background: #f8d7da; padding: 8px; border-radius: 4px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login Bi-Kantin</h2>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>