<?php

use App\Enums\PostCategory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use Database\Seeders\BadgesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    $this->seed([
        RolesAndPermissionsSeeder::class,
        BadgesSeeder::class,
    ]);
});

test('creating a post increases user activity_score by configured amount', function () {
    $user = User::factory()->create(['activity_score' => 0]);
    $configuredPoints = config('gamification.points.post_created');

    Post::create([
        'user_id' => $user->id,
        'category' => PostCategory::STOCKS,
        'body' => 'Checking stock market momentum today.',
    ]);

    $user->refresh();
    expect($user->activity_score)->toBe($configuredPoints);
});

test('creating a comment increases user activity_score correctly', function () {
    $author = User::factory()->create();
    $commenter = User::factory()->create(['activity_score' => 0]);

    $post = Post::create([
        'user_id' => $author->id,
        'category' => PostCategory::BASICS,
        'body' => 'What is compound interest?',
    ]);

    $configuredCommentPoints = config('gamification.points.comment_created');

    Comment::create([
        'post_id' => $post->id,
        'user_id' => $commenter->id,
        'body' => 'Compound interest is the interest on interest!',
    ]);

    $commenter->refresh();
    expect($commenter->activity_score)->toBe($configuredCommentPoints);
});

test('toggling a reaction on increases score, toggling off does not decrease it', function () {
    $author = User::factory()->create();
    $reactor = User::factory()->create(['activity_score' => 0]);

    $post = Post::create([
        'user_id' => $author->id,
        'category' => PostCategory::NEWS,
        'body' => 'Fed announces interest rate update.',
    ]);

    $configuredReactionPoints = config('gamification.points.reaction_given');

    // Toggle reaction on
    $reaction = Reaction::create([
        'post_id' => $post->id,
        'user_id' => $reactor->id,
    ]);

    $reactor->refresh();
    expect($reactor->activity_score)->toBe($configuredReactionPoints);

    // Toggle reaction off (delete reaction)
    $reaction->delete();

    $reactor->refresh();
    // Activity score reflects historical participation, should NOT decrement
    expect($reactor->activity_score)->toBe($configuredReactionPoints);
});

test('point values are read from config and not hardcoded', function () {
    $user = User::factory()->create(['activity_score' => 0]);

    Config::set('gamification.points.post_created', 25);

    Post::create([
        'user_id' => $user->id,
        'category' => PostCategory::STOCKS,
        'body' => 'High point post testing dynamic configuration.',
    ]);

    $user->refresh();
    expect($user->activity_score)->toBe(25);
});
