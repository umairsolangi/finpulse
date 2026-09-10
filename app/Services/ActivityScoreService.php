<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\WeeklyActivityPoint;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class ActivityScoreService
{
    protected ?Badge $lastAwardedBadge = null;

    public function __construct(
        protected BadgeAwardService $badgeAwardService
    ) {}

    /**
     * Record an activity action for a user, updating cumulative activity score,
     * weekly leaderboard points, and checking for badge unlocks.
     */
    public function recordActivity(User $user, string $actionType): ?Badge
    {
        $points = (int) config("gamification.points.{$actionType}", 0);

        if ($points <= 0) {
            return null;
        }

        // Increment cumulative activity score
        $user->increment('activity_score', $points);
        $user->refresh();

        // Increment current week's activity points (week starting Monday)
        $weekStartDate = Carbon::now()->startOfWeek(CarbonInterface::MONDAY)->toDateString();

        $weeklyPoint = WeeklyActivityPoint::firstOrCreate(
            [
                'user_id' => $user->id,
                'week_start_date' => $weekStartDate,
            ],
            [
                'points' => 0,
            ]
        );

        $weeklyPoint->increment('points', $points);

        // Check if user has unlocked the Active Contributor badge
        $badge = $this->badgeAwardService->checkActiveContributor($user);
        if ($badge) {
            $this->lastAwardedBadge = $badge;
        }

        return $badge;
    }

    public function pullLastAwardedBadge(): ?Badge
    {
        $badge = $this->lastAwardedBadge;
        $this->lastAwardedBadge = null;

        return $badge;
    }
}
