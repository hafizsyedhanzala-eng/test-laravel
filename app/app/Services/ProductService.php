<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Create a product for the authenticated vendor.
     */
    public function create(array $data): Product
    {
        $user = Auth::user();
        if (!$user) {
            throw new \RuntimeException('Unauthorized');
        }
        if ($user->role !== 'vendor') {
            throw new \RuntimeException('Only vendors can create products');
        }

        return DB::transaction(function () use ($data, $user) {
            $product = new Product();
            $product->user_id = $user->id;
            $product->code = generateProductCode();
            $product->name = $data['name'];
            $product->description = $data['description'] ?? null;
            $product->price = $data['price'];
            $product->status = Product::STATUS_PENDING;
            $product->save();

            // Fire event
            event(new ProductCreated($product));

            return $product;
        });
    }

    /**
     * Update a vendor's own product if not approved yet.
     */
    public function update(Product $product, array $data): Product
    {
        $user = Auth::user();
        if (!$user || $user->id !== $product->user_id) {
            throw new \RuntimeException('Unauthorized');
        }
        if ($product->status !== Product::STATUS_PENDING) {
            throw new \RuntimeException('Only pending products can be updated');
        }

        $product->fill([
            'name' => $data['name'] ?? $product->name,
            'description' => $data['description'] ?? $product->description,
            'price' => $data['price'] ?? $product->price,
        ]);
        $product->save();

        return $product;
    }

    /**
     * Delete a vendor's own product if not approved yet.
     */
    public function delete(Product $product): void
    {
        $user = Auth::user();
        if (!$user || $user->id !== $product->user_id) {
            throw new \RuntimeException('Unauthorized');
        }
        if ($product->status !== Product::STATUS_PENDING) {
            throw new \RuntimeException('Only pending products can be deleted');
        }
        $product->delete();
    }

    /**
     * Admin approves a product.
     */
    public function approve(Product $product): Product
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            throw new \RuntimeException('Only admin can approve');
        }
        $product->status = Product::STATUS_APPROVED;
        $product->save();
        return $product;
    }

    /**
     * Admin rejects a product.
     */
    public function reject(Product $product): Product
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            throw new \RuntimeException('Only admin can reject');
        }
        $product->status = Product::STATUS_REJECTED;
        $product->save();
        return $product;
    }
}
