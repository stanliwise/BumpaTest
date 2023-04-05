<?php

namespace Tests\Feature;

use App\DataWrappers\Cart;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Product;
use App\Models\User;
use App\Services\CashierService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementBadgeTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that the rooute returns a valid json structure
     *
     * @return void
     */
    public function test_achievement_route_return_valid_structure()
    {
        /**@var User */
        $user = User::factory()->create([
            'amount' => 15000
        ]);

        $product = Product::factory()->create([
            'quantity' => 6,
            'price' => 500,
        ]);

        $cart = new Cart();

        $cart->add($product, 6);

        $cashier = new CashierService();

        $cashier->process($cart, $user);

        $this
            ->get(route('achievement.info', ['user' => $user->id ]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'unlocked_achievement',
                'next_available_achievement',
                'current_badge',
                'next_badge',
                'remaining_to_unlock_next_badge'
            ])->assertJson(
                [
                    'current_badge' => "Beginner",
                    'remaining_to_unlock_next_badge' => 3
                ]
            );


    }

    public function test_achievement_route_show_valid_info_about_user_with_a_badge(){
        $user = User::factory()->create();

        $this
        ->get(route('achievement.info', ['user' => $user->id]))
        ->assertJson([
            'next_badge' => 'Beginner'
        ]);
    }
}
