<?php

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\SkillLevel;
use App\Models\ContentItem;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guest can view /learn and see free tier content', function () {
    $item = ContentItem::factory()->create([
        'title' => 'Introduction to Stock Market Basics',
        'tier' => ContentTier::FREE,
        'published_at' => now(),
    ]);

    $response = $this->get('/learn');
    $response->assertOk()
        ->assertSee('Introduction to Stock Market Basics');
});

test('guest can view a free tier article detail page and see body content', function () {
    $item = ContentItem::factory()->create([
        'title' => 'Understanding Mutual Funds',
        'slug' => 'understanding-mutual-funds',
        'type' => ContentType::ARTICLE,
        'tier' => ContentTier::FREE,
        'body' => 'This is the complete text body of the mutual funds guide.',
        'published_at' => now(),
    ]);

    $response = $this->get('/learn/'.$item->slug);
    $response->assertOk()
        ->assertSee('Understanding Mutual Funds')
        ->assertSee('This is the complete text body of the mutual funds guide.');
});

test('guest can view a free tier video detail page and see video player placeholder', function () {
    $item = ContentItem::factory()->create([
        'title' => 'Video Guide to ETF Investing',
        'slug' => 'video-guide-etf-investing',
        'type' => ContentType::VIDEO,
        'tier' => ContentTier::FREE,
        'body' => 'Video transcript and outline.',
        'published_at' => now(),
    ]);

    $response = $this->get('/learn/'.$item->slug);
    $response->assertOk()
        ->assertSee('Video Guide to ETF Investing')
        ->assertSee('Video Player Placeholder');
});

test('guest viewing registered or paid tier content sees locked teaser state with hidden body', function () {
    $paidItem = ContentItem::factory()->create([
        'title' => 'Advanced Portfolio Optimization Secrets',
        'slug' => 'advanced-portfolio-optimization-secrets',
        'type' => ContentType::ARTICLE,
        'tier' => ContentTier::PAID,
        'body' => 'SECRET_PAID_CONTENT_BODY_THAT_MUST_BE_HIDDEN',
        'published_at' => now(),
    ]);

    $response = $this->get('/learn/'.$paidItem->slug);
    $response->assertOk()
        ->assertSee('Advanced Portfolio Optimization Secrets')
        ->assertSee('This content is locked')
        ->assertDontSee('SECRET_PAID_CONTENT_BODY_THAT_MUST_BE_HIDDEN');
});

test('filtering by skill level returns only matching items', function () {
    $beginnerItem = ContentItem::factory()->create([
        'title' => 'Beginner Budgeting Tips',
        'tier' => ContentTier::FREE,
        'skill_level' => SkillLevel::BEGINNER,
        'published_at' => now(),
    ]);

    $advancedItem = ContentItem::factory()->create([
        'title' => 'Advanced Options Trading',
        'tier' => ContentTier::FREE,
        'skill_level' => SkillLevel::ADVANCED,
        'published_at' => now(),
    ]);

    Livewire::test('learn.learn-index')
        ->set('skillLevel', SkillLevel::BEGINNER->value)
        ->assertSee('Beginner Budgeting Tips')
        ->assertDontSee('Advanced Options Trading');
});

test('search query filters items by matching title', function () {
    $item1 = ContentItem::factory()->create([
        'title' => 'Cryptocurrency Fundamentals',
        'tier' => ContentTier::FREE,
        'published_at' => now(),
    ]);

    $item2 = ContentItem::factory()->create([
        'title' => 'Real Estate Investment Trusts',
        'tier' => ContentTier::FREE,
        'published_at' => now(),
    ]);

    Livewire::test('learn.learn-index')
        ->set('search', 'Cryptocurrency')
        ->assertSee('Cryptocurrency Fundamentals')
        ->assertDontSee('Real Estate Investment Trusts');
});

test('unpublished content where published_at is null never appears in listing or detail page', function () {
    $unpublishedItem = ContentItem::factory()->create([
        'title' => 'Draft Unpublished Lesson',
        'slug' => 'draft-unpublished-lesson',
        'tier' => ContentTier::FREE,
        'published_at' => null,
    ]);

    $responseIndex = $this->get('/learn');
    $responseIndex->assertDontSee('Draft Unpublished Lesson');

    $responseDetail = $this->get('/learn/'.$unpublishedItem->slug);
    $responseDetail->assertNotFound();
});
