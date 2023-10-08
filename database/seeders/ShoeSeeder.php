<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shoe;

class ShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Shoe::factory(20)->create();
    }
}
