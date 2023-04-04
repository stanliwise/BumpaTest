<?php

namespace App\Services;

use App\DataWrappers\Cart;
use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Product;
use App\Models\User;

class RewardService
{

    public function __construct()
    {
    }

    /**
     * This service provider is responsible process all archievement a user 
     * 
     * @param User $user that should be considered to be awarded
     */
    public function processAchievements(User $user)
    {
        $user_purchase_count = $user->achievements();
        $achieveables  = Achievement::get(['purchase_count', 'id']);

        foreach ($achieveables as $achieveable) {
            if ($achieveable->purchase_count == $user_purchase_count) {
                $user->achievements()->syncWithoutDetaching($achieveable->id);

                AchievementUnlocked::dispatch($user, $achieveable);
                break;
            }
        }
    }

    /**
     * Get Users next Badge
     */
    public function processBadge(User $user)
    {
    }
}
