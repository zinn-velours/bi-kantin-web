<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bi-Kantin')</title>
    @yield('head')
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f4f6f8; color: #222; }
        nav { background: #1f7a4d; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; margin-right: 14px; text-decoration: none; }
        nav form { margin: 0; }
        main { max-width: 900px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 20px; box-shadow: 0 1px 3px #0001; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border-bottom: 1px solid #e5e5e5; text-align: left; }
        input { padding: 7px; box-sizing: border-box; }
        button { background: #1f7a4d; color: #fff; border: 0; padding: 8px 14px; border-radius: 5px; cursor: pointer; }
        .btn-gray { background: #777; }
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 14px; }
        .ok { background: #d4edda; }
        .err { background: #f8d7da; }
    </style>
</head>
<body>
    <nav>
                      <div>
            <strong>Bi-Kantin</strong>&nbsp;&nbsp;
            @if(session('user.role') === 'admin')
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/users">Akun</a>
                <a href="/kasir/dashboard">Kasir</a>
            @elseif(session('user.role') === 'kasir')
                <a href="/kasir/dashboard">Pembayaran</a>
            @elseif(session('user.role') === 'siswa')
                <a href="/siswa/dashboard">Menu &amp; Pesanan</a>
            @endif
        </div>
        @if(session('user'))
            <form method="POST" action="/logout">
                @csrf
                {{ session('user.username') }} ({{ session('user.role') }})
                <button class="btn-gray">Logout</button>
            </form>
        @endif
    </nav>

    <main>
        @if(session('success')) <div class="alert ok">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="alert err">{{ session('error') }}</div> @endif
        @if($errors->any())
            <div class="alert err">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>