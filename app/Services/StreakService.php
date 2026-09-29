<?php

namespace App\Services;

use App\Models\LoginStreak;
use App\Models\User;
use Carbon\Carbon;

class StreakService
{
    /**
     * Record today's login for the user and update their streak.
     * Returns the updated streak data.
     *
     * @return array{current_streak: int, longest_streak: int, login_date: string}
     */
    public function recordLogin(User $user): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $existing = LoginStreak::where('user_id', $user->id)
            ->where('login_date', $today)
            ->first();

        if ($existing) {
            return [
                'current_streak' => $existing->current_streak,
                'longest_streak' => $existing->longest_streak,
                'login_date' => $today->toDateString(),
            ];
        }

        $yesterdayEntry = LoginStreak::where('user_id', $user->id)
            ->where('login_date', $yesterday)
            ->first();

        $currentStreak = $yesterdayEntry ? $yesterdayEntry->current_streak + 1 : 1;

        $previousLongest = LoginStreak::where('user_id', $user->id)
            ->max('longest_streak') ?? 0;

        $longestStreak = max($currentStreak, $previousLongest);

        $streak = LoginStreak::create([
            'user_id' => $user->id,
            'login_date' => $today,
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
        ]);

        return [
            'current_streak' => $streak->current_streak,
            'longest_streak' => $streak->longest_streak,
            'login_date' => $today->toDateString(),
        ];
    }

    /**
     * Get the current streak data for a user without recording.
     *
     * @return array{current_streak: int, longest_streak: int, last_7_days: array<string, bool>}
     */
    public function getStreakData(User $user): array
    {
        $today = Carbon::today();

        $latestStreak = LoginStreak::where('user_id', $user->id)
            ->orderBy('login_date', 'desc')
            ->first();

        $currentStreak = 0;
        $longestStreak = 0;

        if ($latestStreak) {
            $daysSinceLastLogin = $today->diffInDays($latestStreak->login_date);

            if ($daysSinceLastLogin <= 1) {
                $currentStreak = $latestStreak->current_streak;
            }

            $longestStreak = LoginStreak::where('user_id', $user->id)
                ->max('longest_streak') ?? 0;
        }

        // Get last 7 days activity for mini calendar in a single query
        $startDate = $today->copy()->subDays(6)->toDateString();
        $recentLogins = LoginStreak::where('user_id', $user->id)
            ->whereDate('login_date', '>=', $startDate)
            ->pluck('login_date')
            ->map(fn ($d) => Carbon::parse($d)->toDateString())
            ->flip()
            ->all();

        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateStr = $today->copy()->subDays($i)->toDateString();
            $last7Days[$dateStr] = isset($recentLogins[$dateStr]);
        }

        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'last_7_days' => $last7Days,
        ];
    }
}
