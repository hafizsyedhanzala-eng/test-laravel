<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }

    public function index(): View
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function approve(Product $product): RedirectResponse
    {
        $this->service->approve($product);
        return back()->with('status', 'Product approved.');
    }

    public function reject(Product $product): RedirectResponse
    {
        $this->service->reject($product);
        return back()->with('status', 'Product rejected.');
    }
}
