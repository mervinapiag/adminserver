<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition()
    {
        $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black'];
        $sizes = ['40 EU', '41 EU', '42 EU', '43 EU', '44 EU'];
        return [
            'shoe_id' => function () {
                return \App\Models\Shoe::all()->random()->id;
            },
            'color' => $this->faker->randomElement($colors),
            'size' => $this->faker->randomElement($sizes),
            'stock' => $this->faker->numberBetween(0, 50)
        ];
    }
}
