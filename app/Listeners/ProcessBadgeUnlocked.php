<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class ProcessBadgeUnlocked implements ShouldQueue
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
     * @param  \App\Events\BadgeUnlocked  $event
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        //$user to recieve the money
        $url = "https://api.paystack.co/transfer";

        $fields = [
            'source' => "balance",
            'amount' => 37800,
            "reference" => "your-unique-reference",
            'recipient' => "RCP_t0ya41mp35flk40",
            'reason' => "Holiday Flexing"
        ];

        #Http::post();
    }


    public function create_recipient()
    {
        $url = "https://api.paystack.co/transferrecipient";

        $fields = [
          'type' => "nuban",
          'name' => "John Doe",
          'account_number' => "0001234567",
          'bank_code' => "058",
          'currency' => "NGN"
        ];

    }
}
