<?php

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\PostCategory;
use App\Models\Badge;
use App\Models\ContentItem;
use App\Models\Post;
use App\Models\User;
use App\Services\BadgeAwardService;
use Database\Seeders\BadgesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed([
        RolesAndPermissionsSeeder::class,
        BadgesSeeder::class,
    ]);
});

test('user crossing 50 activity_score for the first time gets the Active Contributor badge exactly once', function () {
    $user = User::factory()->create(['activity_score' => 45]);

    // Create a post (awards 5 points, pushing score to 50)
    Post::create([
        'user_id' => $user->id,
        'category' => PostCategory::STOCKS,
        'body' => 'Post that crosses the 50 point milestone!',
    ]);

    $user->refresh();
    expect($user->activity_score)->toBe(50);
    expect($user->badges()->where('name', 'Active Contributor')->count())->toBe(1);

    // Keep adding more posts so score increases further
    Post::create([
        'user_id' => $user->id,
        'category' => PostCategory::STOCKS,
        'body' => 'Second post pushing score to 55.',
    ]);

    $user->refresh();
    expect($user->activity_score)->toBe(55);
    // Should still have exactly 1 Active Contributor badge
    expect($user->badges()->where('name', 'Active Contributor')->count())->toBe(1);
});

test('viewing 5 distinct content items awards Market Explorer, viewing same item 5 times does not', function () {
    $user = User::factory()->create();
    $items = ContentItem::factory()->count(5)->create([
        'tier' => ContentTier::FREE,
        'type' => ContentType::ARTICLE,
        'published_at' => now(),
    ]);

    $firstItem = $items->first();

    // View the same item 5 times
    $this->actingAs($user);
    for ($i = 0; $i < 5; $i++) {
        Livewire::test('learn.learn-detail', ['slug' => $firstItem->slug]);
    }

    $user->refresh();
    expect($user->badges()->where('name', 'Market Explorer')->count())->toBe(0);

    // Now view remaining 4 distinct items (total 5 distinct items)
    foreach ($items->slice(1) as $item) {
        Livewire::test('learn.learn-detail', ['slug' => $item->slug]);
    }

    $user->refresh();
    expect($user->badges()->where('name', 'Market Explorer')->count())->toBe(1);
});

test('a badge is never awarded twice to the same user', function () {
    $user = User::factory()->create(['activity_score' => 100]);
    $service = app(BadgeAwardService::class);

    $badge1 = $service->awardBadge($user, 'Active Contributor');
    expect($badge1)->not->toBeNull();
    expect($user->badges()->where('name', 'Active Contributor')->count())->toBe(1);

    // Attempting to award again returns null and does not duplicate
    $badge2 = $service->awardBadge($user, 'Active Contributor');
    expect($badge2)->toBeNull();
    expect($user->badges()->where('name', 'Active Contributor')->count())->toBe(1);
});
