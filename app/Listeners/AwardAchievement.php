<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\PurchaseCompleted;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;

class AwardAchievement implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
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
    public function handle(PurchaseCompleted $event)
    {
        #check if achievement has been unlocked

        /**@var \App\Models\User */
        $user = $event->invoice->user;

        $total_product_count = $user->invoicesItem()->sum('quantity');

        $available_ids = $user->next_available_achievements()->pluck('id');;
        $achieved = Achievement::whereIn('id', $available_ids->values())->where(function (Builder $query) use ($total_product_count) {
            $query->where('purchase_count', $total_product_count)->orWhere('purchase_count', '<', $total_product_count);
        })->orderBy('purchase_count', 'asc')->get();

        foreach ($achieved as $an_achievement) {
            $user->achievements()->syncWithoutDetaching($an_achievement);
            AchievementUnlocked::dispatch($an_achievement->name, $user);
        }
    }
}
