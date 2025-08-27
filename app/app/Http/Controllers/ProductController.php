<?php

namespace App\Http\Controllers;

use App\Events\ProductCreated;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $products = Product::where('user_id', $user->id)->latest()->get();
        return response()->json($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->create($request->validated());
        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        if ($product->user_id !== $request->user()->id) {
            abort(403);
        }
        $updated = $this->service->update($product, $request->validated());
        return response()->json($updated);
    }

    public function destroy(Request $request, Product $product): JsonResponse
    {
        if ($product->user_id !== $request->user()->id) {
            abort(403);
        }
        $this->service->delete($product);
        return response()->json(['deleted' => true]);
    }

    public function adminIndex(): JsonResponse
    {
        $products = Product::latest()->get();
        return response()->json($products);
    }

    public function approve(Product $product): JsonResponse
    {
        $approved = $this->service->approve($product);
        return response()->json($approved);
    }

    public function reject(Product $product): JsonResponse
    {
        $rejected = $this->service->reject($product);
        return response()->json($rejected);
    }
}
