<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => config('app.admin_name'),
            'email' => config('app.admin_email'),
            'password' => bcrypt(config('app.admin_password')),
            'lastname' => config('app.admin_lastname'),
            'firstname' => config('app.admin_firstname'),
            'user_type' => "admin"
        ]);
    }
}
