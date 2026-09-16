<?php

use App\Enums\ContentTier;
use App\Livewire\LiveSessions\LiveSessionIndex;
use App\Models\LiveSession;
use App\Models\LiveSessionBooking;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SessionStartingSoonNotification;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('free user cannot book a paid live session and is redirected to pricing', function () {
    $user = User::factory()->create();
    $host = User::factory()->create();

    $session = LiveSession::create([
        'title' => 'PSX Sector Outlook',
        'description' => 'Detailed sector outlook webinar.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addDays(2),
        'duration_minutes' => 60,
        'tier' => ContentTier::PAID,
        'meeting_url' => 'https://meet.google.com/test-room',
        'max_attendees' => 100,
    ]);

    $this->actingAs($user);

    Livewire::test(LiveSessionIndex::class)
        ->call('bookSession', $session->id)
        ->assertRedirect(route('pricing'));

    expect(LiveSessionBooking::count())->toBe(0);
});

test('paid subscriber can book live session and is prevented from double booking', function () {
    $user = User::factory()->create();
    $host = User::factory()->create();

    Subscription::create([
        'user_id' => $user->id,
        'status' => 'active',
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDays(29),
        'gateway' => 'safepay',
    ]);

    $session = LiveSession::create([
        'title' => 'Live Valuation Clinic',
        'description' => 'Hands on financial modeling clinic.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addDays(2),
        'duration_minutes' => 60,
        'tier' => ContentTier::PAID,
        'meeting_url' => 'https://meet.google.com/test-room',
        'max_attendees' => 50,
    ]);

    $this->actingAs($user);

    // First booking attempt succeeds
    Livewire::test(LiveSessionIndex::class)
        ->call('bookSession', $session->id)
        ->assertSee('Session booked successfully');

    expect(LiveSessionBooking::where('live_session_id', $session->id)->where('user_id', $user->id)->exists())->toBeTrue();

    // Second booking attempt is prevented
    Livewire::test(LiveSessionIndex::class)
        ->call('bookSession', $session->id)
        ->assertSee('You have already booked this session');

    expect(LiveSessionBooking::where('live_session_id', $session->id)->where('user_id', $user->id)->count())->toBe(1);
});

test('join button link is active only within the joinable time window', function () {
    $host = User::factory()->create();

    // Session in 5 minutes (within 10-minute window)
    $upcomingSoon = LiveSession::create([
        'title' => 'Starting Soon Session',
        'description' => 'Starts in 5 minutes.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addMinutes(5),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
        'meeting_url' => 'https://meet.google.com/active-link',
    ]);

    // Session in 2 days (outside window)
    $futureSession = LiveSession::create([
        'title' => 'Far Future Session',
        'description' => 'Starts in 2 days.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addDays(2),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
        'meeting_url' => 'https://meet.google.com/future-link',
    ]);

    expect($upcomingSoon->isJoinable())->toBeTrue();
    expect($futureSession->isJoinable())->toBeFalse();
});

test('session reminder command sends notification for sessions starting in 1 hour', function () {
    Notification::fake();

    $user = User::factory()->create();
    $host = User::factory()->create();

    // Session scheduled in 60 minutes
    $sessionSoon = LiveSession::create([
        'title' => 'Q&A Starting in 1h',
        'description' => 'Urgent session.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addMinutes(60),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
        'meeting_url' => 'https://meet.google.com/room-1h',
    ]);

    LiveSessionBooking::create([
        'live_session_id' => $sessionSoon->id,
        'user_id' => $user->id,
        'booked_at' => now(),
    ]);

    $this->artisan('sessions:send-reminders')
        ->assertSuccessful();

    Notification::assertSentTo($user, SessionStartingSoonNotification::class);
});
