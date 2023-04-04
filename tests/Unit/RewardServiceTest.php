<?php

namespace Tests\Unit;

use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Services\RewardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RewardServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var RewardService
     */
    protected $rewardServiceProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->rewardServiceProvider = new RewardService;
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_processing_achievement()
    {
        Event::fake();

        $user = User::factory()->create();
        $this->assertTrue($this->rewardServiceProvider->processAchievements($user));
        Event::assertDispatched(AchievementUnlocked::class);
    }
}
