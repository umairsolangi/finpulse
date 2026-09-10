<?php

namespace App\Livewire;

use App\Models\WeeklyActivityPoint;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Leaderboard extends Component
{
    public string $viewMode = 'list'; // 'list' or 'podium'

    public function setViewMode(string $mode): void
    {
        $this->viewMode = in_array($mode, ['list', 'podium']) ? $mode : 'list';
    }

    public function render()
    {
        $currentWeekStart = Carbon::now()->startOfWeek(CarbonInterface::MONDAY)->toDateString();
        $userId = auth()->id();

        // Top 20 users for the current week
        $topWeeklyPoints = WeeklyActivityPoint::with('user.badges')
            ->where('week_start_date', $currentWeekStart)
            ->where('points', '>', 0)
            ->orderByDesc('points')
            ->orderBy('updated_at')
            ->take(20)
            ->get();

        // Logged-in user's weekly points and rank
        $myWeeklyPoint = WeeklyActivityPoint::where('user_id', $userId)
            ->where('week_start_date', $currentWeekStart)
            ->first();

        $myPoints = $myWeeklyPoint ? $myWeeklyPoint->points : 0;

        // Calculate user's rank: number of users with more points + 1
        $usersAhead = WeeklyActivityPoint::where('week_start_date', $currentWeekStart)
            ->where('points', '>', $myPoints)
            ->count();

        $myRank = $usersAhead + 1;

        // Check if logged in user is in the top 20
        $isInTop20 = $topWeeklyPoints->contains('user_id', $userId);

        $weekEndDate = Carbon::now()->endOfWeek(CarbonInterface::SUNDAY)->format('M d, Y');
        $weekStartDateFormatted = Carbon::parse($currentWeekStart)->format('M d');

        return view('livewire.leaderboard', [
            'topPoints' => $topWeeklyPoints,
            'myPoints' => $myPoints,
            'myRank' => $myRank,
            'isInTop20' => $isInTop20,
            'currentWeekStart' => $currentWeekStart,
            'weekRange' => "{$weekStartDateFormatted} - {$weekEndDate}",
        ]);
    }
}
