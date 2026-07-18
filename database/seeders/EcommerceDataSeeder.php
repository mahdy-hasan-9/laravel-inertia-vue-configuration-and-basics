<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EcommerceDataSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign keys to avoid truncation errors
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('vendors')->truncate();
        DB::table('brands')->truncate();
        DB::table('categories')->truncate();
        DB::table('sub_categories')->truncate();
        DB::table('products')->truncate();
        DB::table('comments')->truncate();
        DB::table('orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $passwordHash = Hash::make('password');

        // 1. Seed Users (Using 'role' column as defined in migration)
        $usersData = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => $passwordHash, 'role' => 'super-admin'],
            ['name' => 'ajax', 'email' => 'ajax@gmail.com', 'password' => $passwordHash, 'role' => 'admin'],
        ];

        for ($i = 1; $i <= 5; $i++) {
            $usersData[] = [
                'name' => "vendor-{$i}",
                'email' => "vendor{$i}@gmail.com",
                'password' => $passwordHash,
                'role' => 'vendor'
            ];
        }

        for ($i = 1; $i <= 15; $i++) {
            $usersData[] = [
                'name' => "user-{$i}",
                'email' => "user{$i}@gmail.com",
                'password' => $passwordHash,
                'role' => 'user'
            ];
        }

        DB::table('users')->insert($usersData);

        // Fetch user IDs based on corrected 'role' column
        $vendorUserIds = DB::table('users')->where('role', 'vendor')->pluck('id')->toArray();
        $regularUserIds = DB::table('users')->where('role', 'user')->pluck('id')->toArray();

        // 2. Seed Vendors Profiles
        $vendorsData = [];
        foreach ($vendorUserIds as $index => $userId) {
            $num = $index + 1;
            $vendorsData[] = [
                'user_id' => $userId,
                'name' => "Vendor Store {$num}",
                'slug' => Str::slug("Vendor Store {$num}"),
                'phone' => "0171234567{$num}",
                'address' => "Dhaka, Bangladesh, Shop No: {$num}",
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('vendors')->insert($vendorsData);
        $vendorIds = DB::table('vendors')->pluck('id')->toArray();

        // 3. Seed Brands
        $brandMapping = [
            'PC' => ['Asus', 'Mac', 'HP', 'Dell', 'Lenovo'],
            'Mobile' => ['iPhone', 'Samsung', 'Oppo', 'Xiaomi', 'Vivo']
        ];

        $brandsData = [];
        $brandCounter = 0;
        foreach ($brandMapping as $type => $names) {
            foreach ($names as $name) {
                $brandsData[] = [
                    'vendor_id' => $vendorIds[$brandCounter % count($vendorIds)],
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $brandCounter++;
            }
        }
        DB::table('brands')->insert($brandsData);
        $allBrands = DB::table('brands')->get();

        // 4. Seed Categories
        $categoriesData = [];
        foreach ($allBrands as $brand) {
            $catName = in_array($brand->name, ['Asus', 'Mac', 'HP', 'Dell', 'Lenovo']) ? 'Laptops & PC' : 'Smartphones';

            $categoriesData[] = [
                'brand_id' => $brand->id,
                'name' => $catName,
                'slug' => Str::slug($catName . '-' . $brand->name),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('categories')->insert($categoriesData);
        $allCategories = DB::table('categories')->get();

        // 5. Seed Sub-Categories
        $subCategoriesData = [];
        $subCatNames = ['Gaming', 'Accessories', 'Flagship', 'Budget', 'Premium', 'Refurbished', 'Business', 'Student', 'Slim', 'Pro', 'Ultra', 'Mini'];

        for ($i = 0; $i < 12; $i++) {
            $matchedCategory = $allCategories[$i % $allCategories->count()];

            $subCategoriesData[] = [
                'brand_id' => $matchedCategory->brand_id,
                'category_id' => $matchedCategory->id,
                'name' => $subCatNames[$i],
                'slug' => Str::slug($matchedCategory->name . '-' . $subCatNames[$i]),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('sub_categories')->insert($subCategoriesData);

        // 6. Seed Products
        $productsData = [];
        for ($i = 1; $i <= 85; $i++) {
            $randomCategory = $allCategories->random();
            $randomBrand = $allBrands->where('id', $randomCategory->brand_id)->first();

            $price = rand(500, 2500);
            $isDiscount = rand(0, 1);
            $discountPrice = $isDiscount ? ($price - rand(50, 300)) : 0;

            $productsData[] = [
                'id' => $i,
                'vendor_id' => $randomBrand->vendor_id,
                'brand_id' => $randomBrand->id,
                'category_id' => $randomCategory->id,
                'name' => "Product Premium Model {$i}",
                'slug' => Str::slug("Product Premium Model {$i}-" . Str::random(5)),
                'description' => "This is high quality optimized standard product description text for product model number {$i}.",
                'image' => "https://picsum.photos/id/" . rand(1, 100) . "/600/600",
                'rating' => rand(3, 5),
                'price' => $price,
                'discount_price' => $discountPrice,
                'is_active' => 1,
                'is_featured' => rand(0, 1),
                'is_toprated' => rand(0, 1),
                'is_discount' => $isDiscount,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('products')->insert($productsData);

        // 7. Seed Comments
        $commentsData = [];
        $sampleComments = [
            'Awesome product, highly recommended!',
            'The performance is premium but delivery took time.',
            'Value for money, standard packaging.',
            'Absolute trash, do not buy this item.',
            'Quality is decent according to the price tag.'
        ];

        foreach ($productsData as $product) {
            $commentCount = rand(2, 5);
            for ($k = 0; $k < $commentCount; $k++) {
                $commentsData[] = [
                    'vendor_id' => $product['vendor_id'],
                    'user_id' => $regularUserIds[array_rand($regularUserIds)],
                    'product_id' => $product['id'],
                    'comment' => $sampleComments[array_rand($sampleComments)],
                    'rating' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chunk inserts to optimize performance and memory safety
        foreach (array_chunk($commentsData, 500) as $chunk) {
            DB::table('comments')->insert($chunk);
        }

        // 8. Seed Orders (Make sure orders table migration uses 'status' or matching column name)
        $ordersData = [];
        $orderStatuses = ['pending', 'delivery', 'done'];

        for ($o = 1; $o <= 60; $o++) {
            $randomProduct = $productsData[array_rand($productsData)];
            $qty = rand(1, 3);
            $unitPrice = $randomProduct['discount_price'] > 0 ? $randomProduct['discount_price'] : $randomProduct['price'];

            $ordersData[] = [
                'vendor_id' => $randomProduct['vendor_id'],
                'user_id' => $regularUserIds[array_rand($regularUserIds)],
                'product_id' => $randomProduct['id'],
                'quantity' => $qty,
                'amount' => $unitPrice * $qty,
                'is_paid' => rand(0, 1),
                // Note: If you changed orders migration column name to 'status', change this key to 'status'
                'status' => $orderStatuses[array_rand($orderStatuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('orders')->insert($ordersData);
    }
}
