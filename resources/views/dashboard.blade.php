@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Welcome, {{ $user->name }}</h2>
    <p class="muted">Role: <strong>{{ $user->role }}</strong></p>

    @if($user->role === 'vendor')
        <a class="btn" href="{{ route('products.index') }}">Go to My Products</a>
    @elseif($user->role === 'admin')
        <a class="btn" href="{{ route('admin.products.index') }}">Go to Admin Panel</a>
    @endif
</div>
@endsection
