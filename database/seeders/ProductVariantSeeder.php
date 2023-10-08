<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run()
    {
        ProductVariant::factory(20)->create();
    }
}
