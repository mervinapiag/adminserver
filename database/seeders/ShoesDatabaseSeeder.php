<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ShoesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed product brands
        $brands = ['Nike', 'Adidas', 'Puma', 'Reebok'];

        foreach ($brands as $brand) {
            DB::table('product_brands')->insert([
                'name' => $brand,
            ]);
        }

        // Seed product types
        $productTypes = ['Running Shoes', 'Sneakers', 'Formal Shoes', 'Casual Shoes'];

        foreach ($productTypes as $type) {
            DB::table('product_types')->insert([
                'name' => $type,
            ]);
        }

        // Seed product sizes
        $productSizes = ['Small', 'Medium', 'Large', 'X-Large'];

        foreach ($productSizes as $size) {
            DB::table('product_sizes')->insert([
                'name' => $size,
            ]);
        }

        // Seed product colors
        $productColors = ['Red', 'Blue', 'Green', 'Black', 'White'];

        foreach ($productColors as $color) {
            DB::table('product_colors')->insert([
                'name' => $color,
            ]);
        }

        // Seed products
        $shoesData = [
            [
                'name' => 'Air Max 270',
                'description' => 'The Nike Air Max 270 is inspired by two icons of big Air: the Air Max 180 and the Air Max 93.',
                'price' => 7499.99,
                'gender' => 'male',
                'socks' => 'mid',
                'brand_id' => 1, // Nike
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Ultra Boost',
                'description' => 'The Adidas Ultra Boost is designed for comfort and performance. Boost technology provides responsive cushioning.',
                'price' => 8999.99,
                'gender' => 'female',
                'socks' => 'low',
                'brand_id' => 2, // Adidas
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Clyde Court',
                'description' => 'Puma Clyde Court is a stylish basketball shoe with a comfortable fit and excellent on-court performance.',
                'price' => 6499.99,
                'gender' => 'male',
                'socks' => 'high',
                'brand_id' => 3, // Puma
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Classic Leather',
                'description' => 'Reebok Classic Leather is a timeless sneaker with a soft leather upper and comfortable cushioning.',
                'price' => 4499.99,
                'gender' => 'female',
                'socks' => 'mid',
                'brand_id' => 4, // Reebok
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Zoom Pegasus Turbo',
                'description' => 'The Nike Zoom Pegasus Turbo is a lightweight running shoe with ZoomX foam for responsive and comfortable runs.',
                'price' => 8999.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'brand_id' => 1, // Nike
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Stan Smith',
                'description' => 'Adidas Stan Smith is a classic tennis shoe known for its clean design and versatile style.',
                'price' => 5999.99,
                'gender' => 'male',
                'socks' => 'low',
                'brand_id' => 2, // Adidas
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Basket Heart',
                'description' => 'Puma Basket Heart is a fashionable sneaker with a unique bow lacing system, adding a feminine touch to your look.',
                'price' => 6999.99,
                'gender' => 'female',
                'socks' => 'mid',
                'brand_id' => 3, // Puma
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Classic Nylon',
                'description' => 'Reebok Classic Nylon is a retro-style sneaker with a nylon and suede upper for a classic and comfortable fit.',
                'price' => 3999.99,
                'gender' => 'unisex',
                'socks' => 'high',
                'brand_id' => 4, // Reebok
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'React Infinity Run',
                'description' => 'The Nike React Infinity Run is a high-mileage running shoe with a plush and responsive React foam midsole.',
                'price' => 9999.99,
                'gender' => 'unisex',
                'socks' => 'mid',
                'brand_id' => 1, // Nike
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'NMD R1',
                'description' => 'Adidas NMD R1 is a modern sneaker with a comfortable Boost midsole and a sock-like Primeknit upper.',
                'price' => 7499.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'brand_id' => 2, // Adidas
                'status' => 'new',
                'image' => ''
            ],
        ];

        foreach ($shoesData as $shoe) {
            $productId = DB::table('products')->insertGetId($shoe);

            // Attach product types, sizes, and colors to the product
            $this->attachProductRelations($productId);
        }
    }

    private function attachProductRelations($productId)
    {
        // Attach random product types to the product
        $productTypes = DB::table('product_types')->pluck('id')->toArray();
        shuffle($productTypes);
        $productTypeId = array_slice($productTypes, 0, rand(1, count($productTypes)));

        foreach ($productTypeId as $typeId) {
            DB::table('product_has_types')->insert([
                'product_id' => $productId,
                'product_type_id' => $typeId,
            ]);
        }

        // Attach random product sizes to the product
        $productSizes = DB::table('product_sizes')->pluck('id')->toArray();
        shuffle($productSizes);
        $productSizeId = array_slice($productSizes, 0, rand(1, count($productSizes)));

        foreach ($productSizeId as $sizeId) {
            DB::table('product_has_sizes')->insert([
                'product_id' => $productId,
                'product_size_id' => $sizeId,
            ]);
        }

        // Attach random product colors to the product
        $productColors = DB::table('product_colors')->pluck('id')->toArray();
        shuffle($productColors);
        $productColorId = array_slice($productColors, 0, rand(1, count($productColors)));

        foreach ($productColorId as $colorId) {
            DB::table('product_has_colors')->insert([
                'product_id' => $productId,
                'product_color_id' => $colorId,
            ]);
        }
    }
}
