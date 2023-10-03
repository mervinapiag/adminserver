<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Accessory;

class AccessoryFactory extends Factory
{
    protected $model = Accessory::class;

    public function definition()
    {
        $categories = ['socks', 'aglets', 'laces', 'soles'];

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 5, 50),
            'category' => $this->faker->randomElement($categories),
            'brand_name' => $this->faker->company,
            'image' => $this->faker->imageUrl(400, 300, 'fashion'),
        ];
    }
}

