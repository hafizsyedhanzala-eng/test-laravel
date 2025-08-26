@extends('layouts.app')

@section('content')
<div class="card" style="max-width:640px">
    <h2>Edit Product</h2>
    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PUT')
        <div style="margin-top:12px">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:6px">
            @error('name')<div class="muted">{{ $message }}</div>@enderror
        </div>
        <div style="margin-top:12px">
            <label>Description</label>
            <textarea name="description" rows="4" style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:6px">{{ old('description', $product->description) }}</textarea>
            @error('description')<div class="muted">{{ $message }}</div>@enderror
        </div>
        <div style="margin-top:12px">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:6px">
            @error('price')<div class="muted">{{ $message }}</div>@enderror
        </div>
        <div style="margin-top:16px">
            <button class="btn" type="submit">Update</button>
            <a class="btn secondary" href="{{ route('products.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
