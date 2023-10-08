<?php

namespace Database\Factories;

use App\Models\Accessory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryFactory extends Factory
{
    protected $model = Accessory::class;

    public function definition()
    {
        $categories = ['shoelace', 'aglets', 'socks'];
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 5, 50),
            'category' => $this->faker->randomElement($categories),
            'brand_name' => $this->faker->company,
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => $this->faker->imageUrl(640, 480, 'accessory')
        ];
    }
}
