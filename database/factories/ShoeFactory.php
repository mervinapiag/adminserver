<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shoe;

class ShoeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shoe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shoeTypes = ['loafers', 'sports', 'boots', 'sandals'];
        $genders = ['male', 'female', 'unisex'];
        $statuses = ['pre-order', 'in stock', 'out of stock'];

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 200),
            'type' => $this->faker->randomElement($shoeTypes),
            'status' => $this->faker->randomElement($statuses),
            'gender' => $this->faker->randomElement($genders),
            'brand_name' => $this->faker->company,
            'image' => $this->faker->imageUrl(400, 300, 'fashion'),  // Sample image URL
        ];
    }
}
