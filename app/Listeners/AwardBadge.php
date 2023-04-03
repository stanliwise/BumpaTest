<?php

namespace App\Listeners;

use App\Events\PurchaseCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardBadge
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
        //
    }
}
