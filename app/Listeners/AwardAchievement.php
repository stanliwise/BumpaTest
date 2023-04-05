<?php

namespace App\Listeners;

use App\Events\PurchaseCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardAchievement implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PurchaseCompleted  $event
     * @return void
     */
    public function handle(PurchaseCompleted $event)
    {
        #check if achievement has been unlocked

        /**@var \App\Models\User */
        $user = $event->invoice->user;

        #$total_product_count = $user->invoices()->items()

        $user->next_available_achievements()->pluck('id');

        // $unlocked_achievement
        // foreach(){

        // }
    }
}
