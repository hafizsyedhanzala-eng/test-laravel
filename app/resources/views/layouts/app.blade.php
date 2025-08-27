<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mini Shop' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,"Noto Sans",sans-serif;margin:0;background:#f7fafc;color:#1a202c}
        .container{max-width:960px;margin:0 auto;padding:24px}
        header{background:#fff;border-bottom:1px solid #e2e8f0}
        nav a{margin-right:12px;color:#2b6cb0;text-decoration:none}
        .card{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:16px}
        .btn{display:inline-block;background:#2b6cb0;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none;border:0;cursor:pointer}
        .btn.secondary{background:#4a5568}
        .btn.danger{background:#e53e3e}
        .btn.success{background:#2f855a}
        .muted{color:#718096}
        table{width:100%;border-collapse:collapse}
        th,td{padding:8px;border-bottom:1px solid #edf2f7;text-align:left}
        .status{padding:2px 8px;border-radius:999px;font-size:12px}
        .status.pending{background:#faf089}
        .status.approved{background:#9ae6b4}
        .status.rejected{background:#feb2b2}
        form.inline{display:inline}
        .flash{padding:10px 12px;border-radius:6px;background:#edf2f7;color:#2d3748;margin-bottom:16px}
    </style>
</head>
<body>
<header>
    <div class="container" style="display:flex;align-items:center;justify-content:space-between;gap:12px">
        <div>
            <strong>Mini Shop</strong>
        </div>
        <nav>
            @auth
                <a href="{{ route('home') }}">Home</a>
                @if(auth()->user()->role === 'vendor')
                    <a href="{{ route('products.index') }}">My Products</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.products.index') }}">Admin</a>
                @endif
                <form class="inline" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn secondary" type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
    </div>
</header>
<main>
    <div class="container">
        @if(session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif
        {{ $slot ?? '' }}
        @yield('content')
    </div>
</main>
</body>
</html>
