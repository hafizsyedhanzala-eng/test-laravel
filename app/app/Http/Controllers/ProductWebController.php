<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductWebController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }

    public function index(): View
    {
        $products = Product::where('user_id', Auth::id())->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());
        return redirect()->route('products.index')->with('status', 'Product submitted for approval.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->user_id === Auth::id(), 403);
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->user_id === Auth::id(), 403);
        $this->service->update($product, $request->validated());
        return redirect()->route('products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless($product->user_id === Auth::id(), 403);
        $this->service->delete($product);
        return redirect()->route('products.index')->with('status', 'Product deleted.');
    }
}
