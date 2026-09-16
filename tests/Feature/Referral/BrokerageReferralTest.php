<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('authenticated user clicking brokerage referral records timestamp and redirects to broker URL', function () {
    $user = User::factory()->create([
        'brokerage_referral_clicked_at' => null,
    ]);

    $brokerUrl = 'https://www.ktrade.pk/open-account';
    config(['subscription.brokerage_url' => $brokerUrl]);

    $this->actingAs($user);

    $response = $this->get(route('referral.brokerage'));

    $response->assertRedirect($brokerUrl);

    $user->refresh();
    expect($user->brokerage_referral_clicked_at)->not->toBeNull();
    expect($user->brokerage_referral_clicked_at->isToday())->toBeTrue();
});

test('guest clicking referral link is redirected to broker URL', function () {
    $brokerUrl = 'https://www.ktrade.pk/open-account';
    config(['subscription.brokerage_url' => $brokerUrl]);

    $response = $this->get(route('referral.brokerage'));

    $response->assertRedirect($brokerUrl);
});
