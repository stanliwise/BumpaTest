<?php

namespace App\Services;

use App\DataWrappers\Cart;
use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Http;

class PayStackService
{

    public function __construct()
    {
    }

    /**
     * This service provider is responsible for processing payment to users 
     * 
     * @param User $user that should be considered to be awarded
     */
    public function processPaystack(User $user)
    {
    }

    protected function create_transfer_recipient(User $user)
    {
        $url = "https://api.paystack.co/transferrecipient";

        $fields = [
            'type' => "nuban",
            'name' => "John Doe",
            'account_number' => "0001234567",
            'bank_code' => "058",
            'currency' => "NGN"
        ];


        //code...
        $response =  Http::withToken(config('paystack.token'))
            ->withHeaders([
                'Cache-Control' =>  'no-cache'
            ])
            ->post($url, $fields);

        if (!$response->ok())
            response()->throw();
    }

    /**
     * Get Users next Badge
     */
    public function processBadge(User $user)
    {
    }
}
