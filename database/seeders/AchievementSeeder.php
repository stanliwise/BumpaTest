<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{

    protected $achievables = [
        ['name' => '1 Purchase', 'purchase_count' => 1, 'parent_id' => null],
        ['name' => '5 Purchase', 'purchase_count' => 5, 'parent_id' => 1],
        ['name' => '10 Purchase', 'purchase_count' => 10, 'parent_id' => 2],
        ['name' => '20 Purchase', 'purchase_count' => 20, 'parent_id' => 3],
        ['name' => '30 Purchase', 'purchase_count' => 30, 'parent_id' => 4],
        ['name' => '45 Purchase', 'purchase_count' => 45, 'parent_id' => 5],
        ['name' => '45 Purchase', 'purchase_count' => 45, 'parent_id' => 6],
        ['name' => '80 Purchase', 'purchase_count' => 80, 'parent_id' => 7],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->achievables as $achievable){
            Achievement::create($achievable);
        }

    }
}
