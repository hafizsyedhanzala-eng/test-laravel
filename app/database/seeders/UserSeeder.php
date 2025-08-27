<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $vendor = User::query()->updateOrCreate(
            ['email' => 'vendor@example.com'],
            [
                'name' => 'Vendor',
                'password' => Hash::make('password'),
                'role' => 'vendor',
            ]
        );

        // Create personal access tokens
        $adminToken = $admin->createToken('admin-token')->plainTextToken;
        $vendorToken = $vendor->createToken('vendor-token')->plainTextToken;

        // Save tokens to storage for easy retrieval
        $content = "Admin Token: {$adminToken}\nVendor Token: {$vendorToken}\n";
        Storage::disk('local')->put('tokens.txt', $content);
    }
}
