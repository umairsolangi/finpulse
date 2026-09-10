<?php

use App\Models\User;
use App\Models\WeeklyActivityPoint;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Database\Seeders\BadgesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed([
        RolesAndPermissionsSeeder::class,
        BadgesSeeder::class,
    ]);
});

test('leaderboard correctly orders users by current week points descending', function () {
    $currentWeekStart = Carbon::now()->startOfWeek(CarbonInterface::MONDAY)->toDateString();

    $userA = User::factory()->create(['name' => 'Alice']);
    $userB = User::factory()->create(['name' => 'Bob']);
    $userC = User::factory()->create(['name' => 'Charlie']);

    WeeklyActivityPoint::create(['user_id' => $userA->id, 'week_start_date' => $currentWeekStart, 'points' => 30]);
    WeeklyActivityPoint::create(['user_id' => $userB->id, 'week_start_date' => $currentWeekStart, 'points' => 80]);
    WeeklyActivityPoint::create(['user_id' => $userC->id, 'week_start_date' => $currentWeekStart, 'points' => 50]);

    $this->actingAs($userA);

    Livewire::test('leaderboard')
        ->assertSeeInOrder(['Bob', 'Charlie', 'Alice'])
        ->assertSee('80')
        ->assertSee('50')
        ->assertSee('30');
});

test('a users activity from a previous week does not count toward current week leaderboard', function () {
    $currentWeekStart = Carbon::now()->startOfWeek(CarbonInterface::MONDAY)->toDateString();
    $previousWeekStart = Carbon::now()->subWeek()->startOfWeek(CarbonInterface::MONDAY)->toDateString();

    $oldActiveUser = User::factory()->create(['name' => 'Old Active Member']);
    $currentActiveUser = User::factory()->create(['name' => 'Current Active Member']);

    // User only had points in the previous week
    WeeklyActivityPoint::create([
        'user_id' => $oldActiveUser->id,
        'week_start_date' => $previousWeekStart,
        'points' => 500,
    ]);

    // Current active member has 20 points this week
    WeeklyActivityPoint::create([
        'user_id' => $currentActiveUser->id,
        'week_start_date' => $currentWeekStart,
        'points' => 20,
    ]);

    $this->actingAs($currentActiveUser);

    Livewire::test('leaderboard')
        ->assertSee('Current Active Member')
        ->assertDontSee('Old Active Member');
});

test('logged in users rank is shown correctly even when outside the top 20', function () {
    $currentWeekStart = Carbon::now()->startOfWeek(CarbonInterface::MONDAY)->toDateString();

    // Create 25 top users with high points
    $topUsers = User::factory()->count(25)->create();
    foreach ($topUsers as $index => $user) {
        WeeklyActivityPoint::create([
            'user_id' => $user->id,
            'week_start_date' => $currentWeekStart,
            'points' => 1000 - ($index * 10), // 1000, 990, 980...
        ]);
    }

    // Create our logged in user who has only 5 points (rank 26)
    $myUser = User::factory()->create(['name' => 'Rank Twenty Six User']);
    WeeklyActivityPoint::create([
        'user_id' => $myUser->id,
        'week_start_date' => $currentWeekStart,
        'points' => 5,
    ]);

    $this->actingAs($myUser);

    Livewire::test('leaderboard')
        ->assertSee('#26 this week');
});

test('guest cannot access leaderboard and is redirected to login', function () {
    $response = $this->get('/leaderboard');
    $response->assertRedirect('/login');
});
