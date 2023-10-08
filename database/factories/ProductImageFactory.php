<?php

namespace Database\Factories;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition()
    {
        return [
            'imageable_type' => function (array $attributes) {
                return $attributes['imageable_type'] === 'shoe' ? 'App\\Models\\Shoe' : 'App\\Models\\Accessory';
            },
            'imageable_id' => function (array $attributes) {
                if ($attributes['imageable_type'] === 'shoe') {
                    return \App\Models\Shoe::all()->random()->id;
                } else {
                    return \App\Models\Accessory::all()->random()->id;
                }
            },
            'image_path' => $this->faker->imageUrl(640, 480, 'product')
        ];
    }
}
