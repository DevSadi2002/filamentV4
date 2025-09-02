<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        // make fake values for database seeder of products , brands , categories
        // Create fake brands
        Brand::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'is_active' => true
        ]);
        Brand::create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'is_active' => true
        ]);
        Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'is_active' => true
        ]);


        // Example: Create a fake product
        \App\Models\Product::create([
            'brand_id' => 1,
            'category_id' => 2,
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'image' => 'products/iphone-15-pro.jpg',
            'description' => 'Latest Apple iPhone 15 Pro with advanced features.',
            'price' => 1299.99,
            'is_active' => true,
            'is_featured' => true,
            'in_stock' => 50,
            'on_sale' => false,
        ]);
        \App\Models\Product::create([
            'brand_id' => 2,
            'category_id' => 2,
            'name' => 'Samsung S25 Ultra',
            'slug' => 'samsung-s25-ultra',

            'image' => 'products/samsung-s25-ultra.jpg',
            'description' => 'Samsung S25 Ultra with cutting-edge technology and features.',
            'price' => 1199.99,
            'is_active' => true,
            'is_featured' => true,
            'in_stock' => 40,
            'on_sale' => false,
        ]);
    }
}
