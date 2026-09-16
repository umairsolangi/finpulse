<?php

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionExpiringNotification;
use App\Services\SubscriptionService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('expire command marks past due subscriptions as expired', function () {
    $user = User::factory()->create();

    // Subscription that ended yesterday but status is still active
    $pastDue = Subscription::create([
        'user_id' => $user->id,
        'status' => 'active',
        'starts_at' => now()->subDays(31),
        'ends_at' => now()->subDay(),
        'gateway' => 'safepay',
    ]);

    // Active subscription that ends in 10 days
    $active = Subscription::create([
        'user_id' => $user->id,
        'status' => 'active',
        'starts_at' => now()->subDays(5),
        'ends_at' => now()->addDays(10),
        'gateway' => 'safepay',
    ]);

    $this->artisan('subscriptions:expire')
        ->assertSuccessful();

    $pastDue->refresh();
    $active->refresh();

    expect($pastDue->status)->toBe('expired');
    expect($active->status)->toBe('active');
});

test('renewal reminder command dispatches notification for subscriptions expiring within 3 days', function () {
    Notification::fake();

    $userExpiring = User::factory()->create();
    $userSafe = User::factory()->create();

    // Expiring in 2 days
    $expiringSub = Subscription::create([
        'user_id' => $userExpiring->id,
        'status' => 'active',
        'starts_at' => now()->subDays(28),
        'ends_at' => now()->addDays(2),
        'gateway' => 'safepay',
    ]);

    // Safe for 15 days
    $safeSub = Subscription::create([
        'user_id' => $userSafe->id,
        'status' => 'active',
        'starts_at' => now()->subDays(15),
        'ends_at' => now()->addDays(15),
        'gateway' => 'safepay',
    ]);

    $this->artisan('subscriptions:send-reminders')
        ->assertSuccessful();

    Notification::assertSentTo($userExpiring, SubscriptionExpiringNotification::class);
    Notification::assertNotSentTo($userSafe, SubscriptionExpiringNotification::class);
});

test('cancelled subscription maintains active paid access until ends_at', function () {
    $user = User::factory()->create();
    $service = app(SubscriptionService::class);

    $sub = Subscription::create([
        'user_id' => $user->id,
        'status' => 'active',
        'starts_at' => now()->subDays(10),
        'ends_at' => now()->addDays(20),
        'gateway' => 'safepay',
    ]);

    $service->cancelSubscription($sub);

    $sub->refresh();
    expect($sub->status)->toBe('cancelled');
    // Access must remain active until ends_at
    expect($sub->isActive())->toBeTrue();
    expect($user->hasActiveSubscription())->toBeTrue();
    expect($user->hasPaidAccess())->toBeTrue();
});

test('renewing an active subscription extends the ends_at period by 30 days', function () {
    $user = User::factory()->create();
    $service = app(SubscriptionService::class);

    $initialEndsAt = now()->addDays(15);
    $sub = Subscription::create([
        'user_id' => $user->id,
        'status' => 'active',
        'starts_at' => now()->subDays(15),
        'ends_at' => $initialEndsAt,
        'gateway' => 'safepay',
    ]);

    $renewalPayment = Payment::create([
        'user_id' => $user->id,
        'amount' => 1500,
        'currency' => 'PKR',
        'status' => 'pending',
        'gateway_transaction_id' => 'renewal_tr_123',
    ]);

    $extendedSub = $service->processSuccessfulPayment($renewalPayment, 'renewal_tr_123');

    expect($extendedSub->id)->toBe($sub->id);
    expect($extendedSub->status)->toBe('active');
    expect((int) round(abs($extendedSub->ends_at->diffInDays($initialEndsAt))))->toBe(30);
});
