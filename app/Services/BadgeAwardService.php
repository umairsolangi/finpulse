<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\ContentView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BadgeAwardService
{
    /**
     * Attempt to award a specific badge to the user.
     * Checks if the badge is already earned; never awards the same badge twice.
     */
    public function awardBadge(User $user, string $badgeName): ?Badge
    {
        $badge = Badge::where('name', $badgeName)->first();

        if (! $badge) {
            Log::warning("Attempted to award non-existent badge: {$badgeName}");

            return null;
        }

        // Check whether the badge is already earned first rather than relying on a caught exception
        $alreadyEarned = $user->badges()->where('badges.id', $badge->id)->exists();

        if ($alreadyEarned) {
            return null;
        }

        $user->badges()->attach($badge->id, [
            'earned_at' => Carbon::now(),
        ]);

        return $badge;
    }

    /**
     * Check and award the "Active Contributor" badge if user's activity_score crosses 50.
     */
    public function checkActiveContributor(User $user): ?Badge
    {
        if ($user->activity_score >= 50) {
            return $this->awardBadge($user, 'Active Contributor');
        }

        return null;
    }

    /**
     * Check and award the "Market Explorer" badge if user viewed >= 5 distinct ContentItems.
     */
    public function checkMarketExplorer(User $user): ?Badge
    {
        $distinctViewsCount = ContentView::where('user_id', $user->id)
            ->distinct('content_item_id')
            ->count('content_item_id');

        if ($distinctViewsCount >= 5) {
            return $this->awardBadge($user, 'Market Explorer');
        }

        return null;
    }
}
