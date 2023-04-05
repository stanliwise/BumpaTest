<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\PurchaseCompleted;
use App\Listeners\AwardAchievement;
use App\Listeners\AwardBadge;
use App\Listeners\ProcessBadgeUnlocked;
use App\Models\Badge;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        BadgeUnlocked::class => [
            ProcessBadgeUnlocked::class
        ],

        PurchaseCompleted::class => [
            AwardAchievement::class,
        ],

        AchievementUnlocked::class => [
            AwardBadge::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
