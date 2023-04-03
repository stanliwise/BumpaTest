<?php

namespace App\Services;

use App\DataWrappers\Cart;
use App\Models\Product;
use App\Models\User;

class RewardService
{
        protected $achievables = [
            '1 Purchase' => 1,
            '5 Purchase' => 5,
            '10 Purchase' => 10,
            '20 Purchase' => 20,
            '30 Purchase' => 30,
            '45 Purchase' => 45,
            '60 Purchase' => 60,
            '80 Purchase' => 80,
        ];

    protected $badges = [
        'Beginner' => 5,
        'Intermediate' => 20,
        'Advanced' => 40,
        'Super Customer' => 60,
        'Legend Customer' => 80,
    ];

    public function __construct()
    {
    }

    public function awardAchievements(User $user)
    {
        $purchase_count = $user->purchase()->count();

        foreach ($this->achievables as $key => $amount) {
            if ($amount == $purchase_count) {
                $user->achievements()->create([
                    'name' => $key
                ]);

                break;
            }
        }
    }

    /**
     * Get Users next Badge
     */
    public function nextBagdge(User $user)
    {
        $collection = collect($this->achievables);
        $collection->next();
    }
}
