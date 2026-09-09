<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('free member explicitly lacks content.view-paid permission', function () {
    $user = User::factory()->create();
    $user->assignRole('Free Member');

    expect($user->hasPermissionTo('content.view-paid'))->toBeFalse()
        ->and($user->can('content.view-paid'))->toBeFalse();
});

test('paid subscriber successfully evaluates can content.view-paid as true', function () {
    $user = User::factory()->create();
    $user->assignRole('Paid Subscriber');

    expect($user->hasPermissionTo('content.view-paid'))->toBeTrue()
        ->and($user->can('content.view-paid'))->toBeTrue();
});
