@extends('layouts.app')

@section('content')
<div class="card" style="max-width:480px;margin:24px auto;">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div style="margin-top:12px">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:6px">
            @error('email')<div class="muted">{{ $message }}</div>@enderror
        </div>
        <div style="margin-top:12px">
            <label>Password</label>
            <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:6px">
        </div>
        <div style="margin-top:16px">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <div style="margin-top:16px">
            <button class="btn" type="submit">Login</button>
        </div>
        <p class="muted" style="margin-top:12px">Admin: admin@example.com / password<br>Vendor: vendor@example.com / password</p>
    </form>
</div>
@endsection
