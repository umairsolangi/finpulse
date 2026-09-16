<?php

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('valid webhook with correct signature marks payment completed and activates 30-day subscription', function () {
    $user = User::factory()->create();
    $secret = 'test_webhook_secret_key_123';
    config(['subscription.safepay.webhook_secret' => $secret]);

    $tracker = 'tracker_valid_12345';
    $payment = Payment::create([
        'user_id' => $user->id,
        'amount' => 1500,
        'currency' => 'PKR',
        'status' => 'pending',
        'gateway_transaction_id' => $tracker,
    ]);

    $payload = [
        'event' => 'payment.completed',
        'data' => [
            'tracker' => $tracker,
            'amount' => 150000,
            'currency' => 'PKR',
            'status' => 'completed',
        ],
    ];

    $rawPayload = json_encode($payload);
    $signature = hash_hmac('sha512', $rawPayload, $secret);

    $response = $this->withHeaders([
        'X-SFPY-SIGNATURE' => $signature,
        'Content-Type' => 'application/json',
    ])->postJson(route('webhooks.safepay'), $payload);

    $response->assertOk()
        ->assertJson(['status' => 'success']);

    $payment->refresh();
    expect($payment->status)->toBe('completed');
    expect($payment->subscription_id)->not->toBeNull();

    $subscription = Subscription::find($payment->subscription_id);
    expect($subscription)->not->toBeNull();
    expect($subscription->user_id)->toBe($user->id);
    expect($subscription->status)->toBe('active');
    expect($subscription->isActive())->toBeTrue();
    expect($user->hasActiveSubscription())->toBeTrue();
});

test('webhook with forged or invalid signature is rejected and creates no records', function () {
    $user = User::factory()->create();
    $secret = 'test_webhook_secret_key_123';
    config(['subscription.safepay.webhook_secret' => $secret]);

    $tracker = 'tracker_forged_99999';
    $payment = Payment::create([
        'user_id' => $user->id,
        'amount' => 1500,
        'currency' => 'PKR',
        'status' => 'pending',
        'gateway_transaction_id' => $tracker,
    ]);

    $payload = [
        'event' => 'payment.completed',
        'data' => [
            'tracker' => $tracker,
            'status' => 'completed',
        ],
    ];

    $forgedSignature = 'forged_invalid_signature_string';

    $response = $this->withHeaders([
        'X-SFPY-SIGNATURE' => $forgedSignature,
        'Content-Type' => 'application/json',
    ])->postJson(route('webhooks.safepay'), $payload);

    $response->assertStatus(400);

    $payment->refresh();
    expect($payment->status)->toBe('pending');
    expect($payment->subscription_id)->toBeNull();
    expect($user->hasActiveSubscription())->toBeFalse();
});

test('webhook without signature header is rejected with 400', function () {
    $payload = ['foo' => 'bar'];

    $response = $this->postJson(route('webhooks.safepay'), $payload);

    $response->assertStatus(400)
        ->assertJson(['error' => 'Missing signature header']);
});
