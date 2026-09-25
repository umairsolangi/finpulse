<?php

use App\Enums\ContentTier;
use App\Livewire\LiveSessions\LiveSessionCreate;
use App\Livewire\LiveSessions\LiveSessionIndex;
use App\Livewire\LiveSessions\LiveSessionJoin;
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

test('creating a live session generates a unique, non-guessable agora channel name', function () {
    $host = User::factory()->create();

    $sessionA = LiveSession::create([
        'title' => 'Technical Analysis Masterclass',
        'description' => 'Webinar on candlestick patterns.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addDays(3),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    $sessionB = LiveSession::create([
        'title' => 'Technical Analysis Masterclass',
        'description' => 'Another session with identical title.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addDays(4),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    expect($sessionA->agora_channel_name)->not->toBeEmpty();
    expect($sessionB->agora_channel_name)->not->toBeEmpty();
    expect($sessionA->agora_channel_name)->not->toBe($sessionB->agora_channel_name);
    expect($sessionA->agora_channel_name)->toStartWith('fp-');
    // Ensure random entropy: length must be sufficient and not sequential
    expect(strlen($sessionA->agora_channel_name))->toBeGreaterThan(15);
});

test('token generation endpoint rejects a user who is neither the host nor has a valid booking', function () {
    $host = User::factory()->create();
    $unrelatedUser = User::factory()->create();

    $session = LiveSession::create([
        'title' => 'Private Strategy Webinar',
        'description' => 'Restricted session.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addHour(),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    $this->actingAs($unrelatedUser);

    $response = $this->getJson(route('live-sessions.token', $session));

    $response->assertStatus(403);
    $response->assertJson([
        'error' => 'unauthorized',
    ]);
});

test('token generation endpoint grants a token to the session host', function () {
    $host = User::factory()->create();

    $session = LiveSession::create([
        'title' => 'Host Strategy Room',
        'description' => 'Host session.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addHour(),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    $this->actingAs($host);

    $response = $this->getJson(route('live-sessions.token', $session));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'token',
        'app_id',
        'channel_name',
        'uid',
        'role',
        'is_host',
        'testing_mode',
        'expires_at',
    ]);

    $data = $response->json();
    expect($data['is_host'])->toBeTrue();
    expect($data['channel_name'])->toBe($session->agora_channel_name);
    expect($data['token'])->not->toBeEmpty();
    expect($data['token'])->toStartWith('007');
    expect($data['testing_mode'])->toBeFalse();
});

test('token generation endpoint grants a token to a booked attendee and marks attendance', function () {
    $host = User::factory()->create();
    $attendee = User::factory()->create();

    $session = LiveSession::create([
        'title' => 'Attendee Strategy Room',
        'description' => 'Attendee session.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addHour(),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    $booking = LiveSessionBooking::create([
        'live_session_id' => $session->id,
        'user_id' => $attendee->id,
        'booked_at' => now(),
        'attended' => false,
    ]);

    $this->actingAs($attendee);

    $response = $this->getJson(route('live-sessions.token', $session));

    $response->assertStatus(200);
    $data = $response->json();
    expect($data['is_host'])->toBeFalse();
    expect($data['uid'])->toBe($attendee->id);
    expect($data['token'])->not->toBeEmpty();
    expect($data['token'])->toStartWith('007');

    expect($booking->fresh()->attended)->toBeTrue();
});

test('host cannot schedule overlapping one-on-one sessions', function () {
    $host = User::factory()->create();
    $host->assignRole('Instructor');

    $this->actingAs($host);

    // Existing session tomorrow 14:00 - 15:00
    $existingStart = now()->addDays(2)->setTime(14, 0);
    LiveSession::create([
        'title' => 'First 1-on-1 Mentoring Slot',
        'description' => 'Portfolio clinic.',
        'type' => 'one_on_one',
        'host_id' => $host->id,
        'scheduled_at' => $existingStart,
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
        'max_attendees' => 2,
    ]);

    // Attempt to schedule overlapping slot at 14:30
    $overlapStart = $existingStart->copy()->addMinutes(30)->format('Y-m-d\TH:i');

    Livewire::test(LiveSessionCreate::class)
        ->set('title', 'Conflicting 1-on-1 Slot')
        ->set('description', 'Should be rejected due to time clash.')
        ->set('type', 'one_on_one')
        ->set('scheduled_at', $overlapStart)
        ->set('duration_minutes', 60)
        ->set('tier', 'free')
        ->call('save')
        ->assertHasErrors(['scheduled_at']);

    // Ensure second session was not created
    expect(LiveSession::where('host_id', $host->id)->count())->toBe(1);
});

test('join session button on index page reflects active window vs inactive window', function () {
    $host = User::factory()->create();
    $attendee = User::factory()->create();

    // Joinable session (starts in 5 minutes)
    $activeSession = LiveSession::create([
        'title' => 'Starting in 5 Min',
        'description' => 'Currently open.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addMinutes(5),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    // Inactive session (starts in 2 days)
    $inactiveSession = LiveSession::create([
        'title' => 'Starting in 2 Days',
        'description' => 'Far future.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addDays(2),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    LiveSessionBooking::create([
        'live_session_id' => $activeSession->id,
        'user_id' => $attendee->id,
        'booked_at' => now(),
    ]);

    LiveSessionBooking::create([
        'live_session_id' => $inactiveSession->id,
        'user_id' => $attendee->id,
        'booked_at' => now(),
    ]);

    $this->actingAs($attendee);

    Livewire::test(LiveSessionIndex::class)
        ->assertSee('Join Live Video Room')
        ->assertSee('Join Room (Opens 10m Prior)');
});

test('live session join page rejects unauthorized access and allows booked user', function () {
    $host = User::factory()->create();
    $attendee = User::factory()->create();
    $stranger = User::factory()->create();

    $session = LiveSession::create([
        'title' => 'Live Interactive Masterclass',
        'description' => 'Trading tactics.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addMinutes(5),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    LiveSessionBooking::create([
        'live_session_id' => $session->id,
        'user_id' => $attendee->id,
        'booked_at' => now(),
    ]);

    // Stranger gets 403
    $this->actingAs($stranger);
    $this->get(route('live-sessions.join', $session))->assertStatus(403);

    // Host gets 200
    $this->actingAs($host);
    $this->get(route('live-sessions.join', $session))->assertStatus(200);

    // Booked attendee gets 200
    $this->actingAs($attendee);
    $this->get(route('live-sessions.join', $session))->assertStatus(200);
});

test('falls back to testing mode with null token when agora certificate is not configured', function () {
    config(['services.agora.app_certificate' => null]);

    $host = User::factory()->create();
    $session = LiveSession::create([
        'title' => 'Test Mode Session',
        'description' => 'Session running without certificate.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->addMinutes(10),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    $this->actingAs($host);

    $response = $this->getJson(route('live-sessions.token', $session));

    $response->assertStatus(200);
    $data = $response->json();

    expect($data['testing_mode'])->toBeTrue();
    expect($data['token'])->toBeNull();
    expect($data['app_id'])->toBe(config('services.agora.app_id'));
    expect($data['channel_name'])->toBe($session->agora_channel_name);
});

test('instructor or admin can start an instant live session and is redirected directly to the video room', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin);

    Livewire::test(LiveSessionCreate::class, ['instant' => true])
        ->assertSet('is_instant', true)
        ->set('title', 'Emergency Market Live Update')
        ->set('description', 'Instant live breakdown of interest rate decision.')
        ->set('type', 'webinar')
        ->set('tier', 'free')
        ->call('save')
        ->assertHasNoErrors();

    $session = LiveSession::where('title', 'Emergency Market Live Update')->first();
    expect($session)->not->toBeNull();
    expect($session->isJoinable())->toBeTrue();
    expect($session->isLiveNow())->toBeTrue();
    expect($session->agora_channel_name)->not->toBeEmpty();
});

test('host or admin can end a live session from join room and session is marked ended', function () {
    $host = User::factory()->create();
    $session = LiveSession::create([
        'title' => 'Active Webinar',
        'description' => 'Currently active webinar.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now(),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    expect($session->isEnded())->toBeFalse();
    expect($session->isLiveNow())->toBeTrue();

    $this->actingAs($host);

    Livewire::test(LiveSessionJoin::class, ['session' => $session])
        ->call('endSession')
        ->assertRedirect(route('live-sessions.index'));

    $session->refresh();
    expect($session->isEnded())->toBeTrue();
    expect($session->ended_at)->not->toBeNull();
    expect($session->isLiveNow())->toBeFalse();
    expect($session->isJoinable())->toBeFalse();
    expect($session->isBookable())->toBeFalse();
    expect(LiveSession::upcoming()->where('id', $session->id)->exists())->toBeFalse();
});

test('admin can end a live session from index and attendees cannot', function () {
    $host = User::factory()->create();
    $admin = User::factory()->create();
    $admin->assignRole('Admin');
    $attendee = User::factory()->create();

    $session = LiveSession::create([
        'title' => 'Live Market Briefing',
        'description' => 'Active session.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now(),
        'duration_minutes' => 60,
        'tier' => ContentTier::FREE,
    ]);

    // Unauthorized attendee cannot end session
    $this->actingAs($attendee);
    Livewire::test(LiveSessionIndex::class)
        ->call('endSession', $session->id)
        ->assertSee('Unauthorized');

    $session->refresh();
    expect($session->isEnded())->toBeFalse();

    // Admin can end session
    $this->actingAs($admin);
    Livewire::test(LiveSessionIndex::class)
        ->call('endSession', $session->id)
        ->assertSee('ended successfully');

    $session->refresh();
    expect($session->isEnded())->toBeTrue();
});

test('token request is rejected for an ended session', function () {
    $host = User::factory()->create();
    $session = LiveSession::create([
        'title' => 'Past Live Session',
        'description' => 'Already ended.',
        'type' => 'webinar',
        'host_id' => $host->id,
        'scheduled_at' => now()->subMinutes(30),
        'duration_minutes' => 60,
        'ended_at' => now()->subMinutes(5),
        'tier' => ContentTier::FREE,
    ]);

    $this->actingAs($host);
    $response = $this->getJson(route('live-sessions.token', $session));

    $response->assertStatus(410);
    expect($response->json('error'))->toBe('session_ended');
});
