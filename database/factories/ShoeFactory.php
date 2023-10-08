<?php

namespace Database\Factories;

use App\Models\Shoe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoeFactory extends Factory
{
    protected $model = Shoe::class;

    public function definition()
    {
        $shoe_types = ['Sports', 'Casual', 'Formal'];
        $statuses = ['In Stock', 'Pre-Order'];
        $genders = ['Male', 'Female', 'Unisex'];
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 50, 300),
            'type' => $this->faker->randomElement($shoe_types),
            'status' => $this->faker->randomElement($statuses),
            'gender' => $this->faker->randomElement($genders),
            'brand_name' => $this->faker->company,
            'image' => $this->faker->imageUrl(640, 480, 'shoe')
        ];
    }
}
