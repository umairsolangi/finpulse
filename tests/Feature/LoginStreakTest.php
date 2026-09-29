<?php

use App\Models\LoginStreak;
use App\Models\User;
use App\Services\StreakService;
use Carbon\Carbon;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('first login creates streak of 1', function () {
    $user = User::factory()->create();
    $service = app(StreakService::class);

    $streak = $service->recordLogin($user);

    expect($streak['current_streak'])->toBe(1)
        ->and($streak['longest_streak'])->toBe(1);

    expect(LoginStreak::where('user_id', $user->id)->count())->toBe(1);
});

test('multiple logins on same day do not increase streak', function () {
    $user = User::factory()->create();
    $service = app(StreakService::class);

    $first = $service->recordLogin($user);
    $second = $service->recordLogin($user);

    expect($first['current_streak'])->toBe(1)
        ->and($second['current_streak'])->toBe(1)
        ->and(LoginStreak::where('user_id', $user->id)->count())->toBe(1);
});

test('consecutive day login increments streak', function () {
    $user = User::factory()->create();
    $service = app(StreakService::class);

    // Simulate yesterday's login
    LoginStreak::create([
        'user_id' => $user->id,
        'login_date' => Carbon::yesterday(),
        'current_streak' => 3,
        'longest_streak' => 5,
    ]);

    $streak = $service->recordLogin($user);

    expect($streak['current_streak'])->toBe(4)
        ->and($streak['longest_streak'])->toBe(5);
});

test('breaking streak resets current streak to 1 but preserves longest', function () {
    $user = User::factory()->create();
    $service = app(StreakService::class);

    // Logged in 3 days ago, missed 2 days
    LoginStreak::create([
        'user_id' => $user->id,
        'login_date' => Carbon::today()->subDays(3),
        'current_streak' => 10,
        'longest_streak' => 10,
    ]);

    $streak = $service->recordLogin($user);

    expect($streak['current_streak'])->toBe(1)
        ->and($streak['longest_streak'])->toBe(10);
});

test('middleware automatically records streak for authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk();

    expect(session('streak_recorded_today'))->toBeTrue()
        ->and(LoginStreak::where('user_id', $user->id)->count())->toBe(1);
});
