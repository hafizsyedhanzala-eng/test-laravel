@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Admin • Products</h2>
    <table style="margin-top:12px">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Vendor</th>
                <th>Price</th>
                <th>Status</th>
                <th style="width:260px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
                <tr>
                    <td>#{{ $p->id }}</td>
                    <td>{{ $p->code }}</td>
                    <td>{{ $p->name }}</td>
                    <td class="muted">{{ optional($p->user)->email }}</td>
                    <td>${{ number_format($p->price, 2) }}</td>
                    <td><span class="status {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    <td>
                        @if($p->status === 'pending')
                            <form class="inline" method="POST" action="{{ route('admin.products.approve', $p) }}">
                                @csrf
                                <button class="btn success" type="submit">Approve</button>
                            </form>
                            <form class="inline" method="POST" action="{{ route('admin.products.reject', $p) }}">
                                @csrf
                                <button class="btn danger" type="submit">Reject</button>
                            </form>
                        @else
                            <span class="muted">Reviewed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">No products.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:12px">{{ $products->links() }}</div>
</div>
@endsection
