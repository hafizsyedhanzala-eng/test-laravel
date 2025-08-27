<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendor = User::where('role', 'vendor')->first();
        if (! $vendor) {
            return;
        }

        Product::updateOrCreate(
            ['code' => generateProductCode()],
            [
                'user_id' => $vendor->id,
                'name' => 'Sample Product A',
                'description' => 'First seeded product pending approval',
                'price' => 19.99,
                'status' => 'pending',
            ]
        );

        Product::updateOrCreate(
            ['code' => generateProductCode()],
            [
                'user_id' => $vendor->id,
                'name' => 'Sample Product B',
                'description' => 'Second seeded product pending approval',
                'price' => 29.99,
                'status' => 'pending',
            ]
        );
    }
}
