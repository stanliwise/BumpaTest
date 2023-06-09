<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AchievementSeeder::class,
            BadgeSeeder::class
        ]);


        Product::factory(10)->create();
        // \App\Models\User::factory(10)->create();
    }
}
