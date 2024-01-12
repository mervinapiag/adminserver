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
        /* 
            HOW TO RUN
            open terminal, run
            php artisan db:seed --clas="ShoesDatabaseSeeder"
        */

        // Truncate tables
        DB::table('product_has_types')->truncate();
        DB::table('product_has_sizes')->truncate();
        DB::table('product_has_colors')->truncate();
        DB::table('products')->truncate();
        DB::table('product_brands')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('product_types')->truncate();
        DB::table('product_sizes')->truncate();
        DB::table('product_colors')->truncate();

        // initialize data

        // Seed product categories
        $categories = ['Shoes', 'Socks', 'Accessories']; // add more

        foreach ($categories as $category) {
            DB::table('product_categories')->insert([
                'name' => $category,
            ]);
        }

        // Seed product brands
        $brands = ['Nike', 'Adidas', 'Jordan', 'Converse']; // add more

        foreach ($brands as $brand) {
            DB::table('product_brands')->insert([
                'name' => $brand,
            ]);
        }

        // Seed product types
        $productTypes = ['Lifestyle', 'Running', 'Basketball', 'Training']; // add more

        foreach ($productTypes as $type) {
            DB::table('product_types')->insert([
                'name' => $type,
            ]);
        }

        // Seed product sizes
        $productSizes = ['7', '7.5', '8', '8.5', '9', '9.5', '10', '10.5']; // add more

        foreach ($productSizes as $size) {
            DB::table('product_sizes')->insert([
                'name' => $size,
            ]);
        }

        // Seed product colors
        $productColors = ['Red', 'Blue', 'Green', 'Black', 'White']; // add more

        foreach ($productColors as $color) {
            DB::table('product_colors')->insert([
                'name' => $color,
            ]);
        }

        // run seeders
        $this->seedShoes();
        $this->seedSocks();
        $this->seedAccessories();
    }

    private function seedShoes()
    {
        // Seed products for shoes
        $shoesData = [
            [
                'name' => 'Air Max 270',
                'description' => 'The Nike Air Max 270 is inspired by two icons of big Air: the Air Max 180 and the Air Max 93.',
                'price' => 7499.99,
                'gender' => 'male',
                'socks' => 'mid',
                'product_category_id' => 1,
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
                'product_category_id' => 1,
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
                'product_category_id' => 1,
                'brand_id' => 3, // Jordan
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Classic Leather',
                'description' => 'Reebok Classic Leather is a timeless sneaker with a soft leather upper and comfortable cushioning.',
                'price' => 4499.99,
                'gender' => 'female',
                'socks' => 'mid',
                'product_category_id' => 1,
                'brand_id' => 4, // Converse
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Zoom Pegasus Turbo',
                'description' => 'The Nike Zoom Pegasus Turbo is a lightweight running shoe with ZoomX foam for responsive and comfortable runs.',
                'price' => 8999.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'product_category_id' => 1,
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
                'product_category_id' => 1,
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
                'product_category_id' => 1,
                'brand_id' => 3, // Jordan
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Classic Nylon',
                'description' => 'Reebok Classic Nylon is a retro-style sneaker with a nylon and suede upper for a classic and comfortable fit.',
                'price' => 3999.99,
                'gender' => 'unisex',
                'socks' => 'high',
                'product_category_id' => 1,
                'brand_id' => 4, // Converse
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'React Infinity Run',
                'description' => 'The Nike React Infinity Run is a high-mileage running shoe with a plush and responsive React foam midsole.',
                'price' => 9999.99,
                'gender' => 'unisex',
                'socks' => 'mid',
                'product_category_id' => 1,
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
                'product_category_id' => 1,
                'brand_id' => 2, // Adidas
                'status' => 'new',
                'image' => ''
            ],
            // add more
        ];

        foreach ($shoesData as $shoe) {
            $productId = DB::table('products')->insertGetId($shoe);

            $this->attachProductRelations($productId);
        }
    }

    private function seedSocks()
    {
        // Seed products for socks
        $socksData = [
            [
                'name' => 'Comfort Crew Socks',
                'description' => 'Soft and comfortable crew socks for everyday wear.',
                'price' => 999.99,
                'gender' => 'unisex',
                'socks' => 'mid',
                'product_category_id' => 2,
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Active Ankle Socks',
                'description' => 'Breathable ankle socks designed for active lifestyles.',
                'price' => 799.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'product_category_id' => 2,
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Cozy Wool Socks',
                'description' => 'Warm and cozy wool socks for chilly days.',
                'price' => 1299.99,
                'gender' => 'unisex',
                'socks' => 'high',
                'product_category_id' => 2,
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Running Compression Socks',
                'description' => 'Compression socks designed to enhance performance during runs.',
                'price' => 1099.99,
                'gender' => 'unisex',
                'socks' => 'mid',
                'product_category_id' => 2,
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Patterned Knee-High Socks',
                'description' => 'Stylish knee-high socks with unique patterns.',
                'price' => 899.99,
                'gender' => 'female',
                'socks' => 'high',
                'product_category_id' => 2,
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            // add more
        ];

        foreach ($socksData as $sock) {
            $productId = DB::table('products')->insertGetId($sock);

            $this->attachProductRelations($productId);
        }
    }

    private function seedAccessories()
    {
        // Seed products for accessories
        $accessoriesData = [
            [
                'name' => 'Sporty Backpack',
                'description' => 'A versatile backpack for carrying your essentials with style.',
                'price' => 1499.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'product_category_id' => 3, 
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Leather Belt',
                'description' => 'Classic leather belt for a timeless look.',
                'price' => 599.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'product_category_id' => 3, 
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Reflective Running Armband',
                'description' => 'Stay visible during night runs with this reflective armband.',
                'price' => 299.99,
                'gender' => 'unisex',
                'socks' => 'low',
                'product_category_id' => 3, 
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Knit Beanie',
                'description' => 'Keep warm in style with this cozy knit beanie.',
                'price' => 799.99,
                'gender' => 'unisex',
                'socks' => 'mid',
                'product_category_id' => 3, 
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            [
                'name' => 'Smartphone Holder Arm Band',
                'description' => 'Convenient arm band for securely holding your smartphone during workouts.',
                'price' => 499.99,
                'gender' => 'unisex',
                'socks' => 'mid',
                'product_category_id' => 3, 
                'brand_id' => $this->getRandomBrandId(),
                'status' => 'new',
                'image' => ''
            ],
            // add more
        ];

        foreach ($accessoriesData as $accessory) {
            $productId = DB::table('products')->insertGetId($accessory);

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

    private function getRandomBrandId()
    {
        $brands = DB::table('product_brands')->pluck('id')->toArray();

        if (empty($brands)) {
            return null;
        }

        shuffle($brands);

        return array_shift($brands);
    }
}
