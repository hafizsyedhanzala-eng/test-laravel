@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
        <h2>My Products</h2>
        <a class="btn" href="{{ route('products.create') }}">Add Product</a>
    </div>

    <table style="margin-top:12px">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th style="width:220px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
                <tr>
                    <td>{{ $p->code }}</td>
                    <td>{{ $p->name }}</td>
                    <td>${{ number_format($p->price, 2) }}</td>
                    <td><span class="status {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    <td>
                        @if($p->status === 'pending')
                            <a class="btn" href="{{ route('products.edit', $p) }}">Edit</a>
                            <form class="inline" method="POST" action="{{ route('products.destroy', $p) }}" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit">Delete</button>
                            </form>
                        @else
                            <span class="muted">Locked after review</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No products yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px">
        {{ $products->links() }}
    </div>
</div>
@endsection
