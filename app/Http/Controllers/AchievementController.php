<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AchievementController extends Controller
{
    public function info(User $user)
    {
        $next_badge = $user->badges()->count() == 0 ? Badge::first() : $user->current_badge()->first()->next_badge();

        return response()->json([
            'unlocked_achievement' => $user->achievements()->pluck('name'),
            'next_available_achievement' => $user->next_available_achievements()->pluck('name'),
            'current_badge' => $user->current_badge()->value('name'),
            'next_badge' => $next_badge->name,
            'remaining_to_unlock_next_badge' => ((int) optional($next_badge)->achievement_count) - ((int) $user->achievements()->count())
        ], Response::HTTP_OK);
    }
}
