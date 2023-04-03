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
        $next_badge = $$user->current_badge()->count() == 0 ? Badge::first() : $user->current_badge()->first()->next_badge();

        return response()->json([
            'unlocked_achievement' => $user->achievements()->pluck('name'),
            'next_available_achievement' => Achievement::where(
                'purchase_count',
                '>',
                $user->current_achievement()->value('purchase_count') ?: 0
            )->pluck('name'),
            'current_badge' => $user->current_badge()->value('name'),
            'next_badge' => $user->current_badge()->count() == 0 ? Badge::pluck('name')->first() : $user->current_badge()->first()->next_badge()->value('name'),
            'remaining_to_unlock_next_badge' => ((int) $next_badge->achievement_count) - ((int) $user->achievements()->count())
        ], Response::HTTP_OK);
    }
}
