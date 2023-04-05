<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\PurchaseCompleted;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardBadge implements ShouldQueue
{
    /**
     * @var AchievementUnlocked
     */
    protected $achievementUnlocked;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create the event listener.
     *
     * 
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $nextBadge = $event->user->next_badge();

        if ($event->user->achievements()->count() >= $nextBadge->achievement_count) {
            $event->user->badges()->syncWithoutDetaching($nextBadge);
            BadgeUnlocked::dispatch($nextBadge->name, $event->user);
        }
    }
}
