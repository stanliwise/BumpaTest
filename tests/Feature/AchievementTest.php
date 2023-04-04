<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test that the rooute returns a valid json structure
     *
     * @return void
     */
    public function achievement_route_return_valid_structure()
    {
        $user = User::factory()->create();

        $this
            ->get(route('achievement.info', ['user' => $user->id ]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'unlocked_achievement',
                'next_available_achievement',
                'current_badge',
                'next_badge',
                'remaining_to_unlock_next_badge'
            ]);


    }

    public function test_achievement_route_show_valid_info_about_user_with_a_badge(){
        $user = User::factory()->create();

        $user->achievements()->syncWithoutDetaching(Achievement::first());

        $this
        ->get(route('achievement.info', ['user' => $user->id]))
        ->assertJson([
            'next_badge' => Badge::skip(1)->first()->name
        ]);
    }
}
