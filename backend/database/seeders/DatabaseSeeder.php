<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
          'email' => 'user@user.test',
          'password' => Hash::make('1234'),
          'name' => 'demo user'
        ]);

        \App\Models\Category::factory()->count(10)->create();
        \App\Models\Product::factory()->count(150)->create();
        \App\Models\Images::factory()->count(250)->create();
    }
}
