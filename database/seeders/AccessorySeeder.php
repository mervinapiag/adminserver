<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accessory;

class AccessorySeeder extends Seeder
{
    public function run()
    {
        // Create 10 sample accessories
        Accessory::factory(20)->create();
    }
}
