<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductImage;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition()
    {
        $imageableTypes = ['shoe', 'accessory'];

        return [
            'imageable_id' => $this->faker->randomNumber(), // Same concern as with ProductVariant. Link to actual Shoe or Accessory IDs.
            'imageable_type' => function (array $attributes) {
                return $attributes['imageable_type'] === 'shoe' ? 'App\Models\Shoe' : 'App\Models\Accessory';
            },
            'image_path' => $this->faker->imageUrl(400, 300, 'fashion'),
        ];
    }
}
