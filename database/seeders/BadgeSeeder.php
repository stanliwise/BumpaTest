<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{

    protected $bagdes = [
        ['name' => 'Beginner', 'achievement_count' => 1, 'parent_id' => null],
        ['name' => 'Novice', 'achievement_count' => 5, 'parent_id' => 1],
        ['name' => 'Medium', 'achievement_count' => 10, 'parent_id' => 2],
        ['name' => 'Advance', 'achievement_count' => 20, 'parent_id' => 3],
        ['name' => 'Expert', 'achievement_count' => 20, 'parent_id' => 4],
        ['name' => 'Professional', 'achievement_count' => 25, 'parent_id' => 5],
        ['name' => 'Legend', 'achievement_count' => 30, 'parent_id' => 6]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->bagdes as $bagde) {
            Badge::create($bagde);
        }
    }
}
