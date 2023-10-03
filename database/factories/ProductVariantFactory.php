<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductVariant;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition()
    {
        $productTypes = ['shoe', 'accessory'];
        $colors = ['red', 'blue', 'green', 'yellow', 'black'];
        $sizes = ['small', 'medium', 'large', '42 EU', '44 EU'];

        return [
            'product_id' => function (array $attributes) {
                if ($attributes['product_type'] === 'shoe') {
                    return \App\Models\Shoe::all()->random()->id;
                } else {
                    return \App\Models\Accessory::all()->random()->id;
                }
            },
            'product_type' => $this->faker->randomElement($productTypes),
            'color' => $this->faker->randomElement($colors),
            'size' => $this->faker->randomElement($sizes),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}

