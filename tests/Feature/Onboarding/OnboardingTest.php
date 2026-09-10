<?php

use App\Enums\PostCategory;
use App\Models\User;
use Database\Seeders\BadgesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->seed([
        RolesAndPermissionsSeeder::class,
        BadgesSeeder::class,
    ]);
});

test('a newly registered user is redirected to onboarding, not the feed or dashboard', function () {
    $component = Volt::test('pages.auth.register')
        ->set('name', 'New Member')
        ->set('email', 'newmember@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('register');

    $component->assertRedirect(route('onboarding', absolute: false));
    $this->assertAuthenticated();
});

test('submitting fewer than 2 interests is rejected with a validation error', function () {
    $user = User::factory()->create(['onboarded_at' => null]);
    $this->actingAs($user);

    Livewire::test('onboarding')
        ->set('selectedInterests', [PostCategory::STOCKS->value])
        ->call('submit')
        ->assertHasErrors(['selectedInterests'])
        ->assertNoRedirect();

    expect($user->fresh()->onboarded_at)->toBeNull();
    expect($user->interests()->count())->toBe(0);
});

test('after completing onboarding, the user is redirected to /learn filtered by their selected interests', function () {
    $user = User::factory()->create(['onboarded_at' => null]);
    $this->actingAs($user);

    $chosenInterests = [PostCategory::STOCKS->value, PostCategory::BASICS->value];

    $expectedUrl = route('learn.index', ['interests' => implode(',', $chosenInterests)]);

    Livewire::test('onboarding')
        ->set('selectedInterests', $chosenInterests)
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect($expectedUrl);

    $user->refresh();
    expect($user->onboarded_at)->not->toBeNull();
    expect($user->interests()->pluck('post_category')->map(fn ($c) => $c->value ?? $c)->toArray())
        ->toEqualCanonicalizing($chosenInterests);
});

test('a returning user who already completed onboarding is not redirected there again', function () {
    $user = User::factory()->create(['onboarded_at' => now()]);
    $this->actingAs($user);

    // Visiting /onboarding as an already-onboarded user redirects away
    $response = $this->get('/onboarding');
    $response->assertRedirect(route('learn.index'));
});
