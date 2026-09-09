<?php

use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Database\QueryException;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('user can react to a post and reacting again toggles it off', function () {
    $user = User::factory()->create();
    $user->assignRole('Free Member');

    $post = Post::factory()->create();

    $this->actingAs($user);

    // First toggle -> Reaction added
    Livewire::test('feed')
        ->call('toggleReaction', $post->id)
        ->assertHasNoErrors();

    expect(Reaction::where('post_id', $post->id)->where('user_id', $user->id)->count())->toBe(1);

    // Second toggle -> Reaction removed
    Livewire::test('feed')
        ->call('toggleReaction', $post->id)
        ->assertHasNoErrors();

    expect(Reaction::where('post_id', $post->id)->where('user_id', $user->id)->count())->toBe(0);
});

test('unique database constraint prevents duplicate reaction for same user and post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    Reaction::create([
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);

    expect(function () use ($post, $user) {
        Reaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    })->toThrow(QueryException::class);
});

test('reaction count displayed matches actual count in database', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user1->assignRole('Free Member');
    $user2->assignRole('Free Member');

    $post = Post::factory()->create();

    Reaction::create(['post_id' => $post->id, 'user_id' => $user1->id]);
    Reaction::create(['post_id' => $post->id, 'user_id' => $user2->id]);

    $this->actingAs($user1);

    Livewire::test('feed')
        ->assertSeeHtml('<span>2</span>');
});

test('guest trying to react is redirected to login page', function () {
    $post = Post::factory()->create();

    Livewire::test('feed')
        ->call('toggleReaction', $post->id)
        ->assertRedirect(route('login'));
});
