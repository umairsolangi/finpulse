<?php

use App\Enums\ContentType;
use App\Livewire\MyLibrary;
use App\Models\ContentBookmark;
use App\Models\ContentItem;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guest cannot access my library', function () {
    $this->get(route('my-library'))
        ->assertRedirect(route('login'));
});

test('user can view my library with their bookmarks', function () {
    $user = User::factory()->create();
    $item = ContentItem::factory()->create(['title' => 'Understanding PSX Dividends']);

    ContentBookmark::create([
        'user_id' => $user->id,
        'content_item_id' => $item->id,
    ]);

    Livewire::actingAs($user)
        ->test(MyLibrary::class)
        ->assertSee('Understanding PSX Dividends');
});

test('user can filter bookmarks by type', function () {
    $user = User::factory()->create();
    $article = ContentItem::factory()->create([
        'title' => 'Stock Fundamentals Article',
        'type' => ContentType::ARTICLE,
    ]);
    $video = ContentItem::factory()->create([
        'title' => 'Chart Patterns Video',
        'type' => ContentType::VIDEO,
    ]);

    ContentBookmark::create(['user_id' => $user->id, 'content_item_id' => $article->id]);
    ContentBookmark::create(['user_id' => $user->id, 'content_item_id' => $video->id]);

    Livewire::actingAs($user)
        ->test(MyLibrary::class)
        ->set('filterType', 'video')
        ->assertSee('Chart Patterns Video')
        ->assertDontSee('Stock Fundamentals Article');
});

test('user can search within bookmarks', function () {
    $user = User::factory()->create();
    $item1 = ContentItem::factory()->create(['title' => 'Mutual Funds Guide']);
    $item2 = ContentItem::factory()->create(['title' => 'Real Estate Investment']);

    ContentBookmark::create(['user_id' => $user->id, 'content_item_id' => $item1->id]);
    ContentBookmark::create(['user_id' => $user->id, 'content_item_id' => $item2->id]);

    Livewire::actingAs($user)
        ->test(MyLibrary::class)
        ->set('search', 'Mutual')
        ->assertSee('Mutual Funds Guide')
        ->assertDontSee('Real Estate Investment');
});

test('user can remove bookmark from library', function () {
    $user = User::factory()->create();
    $item = ContentItem::factory()->create(['title' => 'Temporary Bookmark']);

    $bookmark = ContentBookmark::create([
        'user_id' => $user->id,
        'content_item_id' => $item->id,
    ]);

    Livewire::actingAs($user)
        ->test(MyLibrary::class)
        ->call('removeBookmark', $bookmark->id);

    expect(ContentBookmark::where('id', $bookmark->id)->exists())->toBeFalse();
});
