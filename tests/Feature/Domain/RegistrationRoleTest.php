<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Auth\Events\Registered;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('newly registered user is auto-assigned Free Member role via Registered event', function () {
    $user = User::factory()->create();

    event(new Registered($user));

    expect($user->hasRole('Free Member'))->toBeTrue();
});
