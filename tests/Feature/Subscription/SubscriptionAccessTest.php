<?php

use App\Enums\ContentTier;
use App\Livewire\Course\ChapterViewer;
use App\Livewire\Course\CourseDetail;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('free user sees locked teaser on paid course and paid chapter', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Advanced Valuation',
        'order' => 1,
    ]);

    $this->actingAs($user);

    Livewire::test(CourseDetail::class, ['slug' => $course->slug])
        ->assertViewHas('canAccess', false)
        ->assertSee('This course is locked')
        ->assertSee('Upgrade Membership');

    Livewire::test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', false)
        ->assertSee('This chapter is locked');
});

test('active subscriber can fully access paid course and chapter without locked teasers', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    Subscription::create([
        'user_id' => $user->id,
        'status' => 'active',
        'starts_at' => now()->subDays(5),
        'ends_at' => now()->addDays(25),
        'gateway' => 'safepay',
        'gateway_reference' => 'ref_active_123',
    ]);

    expect($user->hasActiveSubscription())->toBeTrue();
    expect($user->hasPaidAccess())->toBeTrue();

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Discounted Cash Flow Model',
        'order' => 1,
    ]);

    $this->actingAs($user);

    Livewire::test(CourseDetail::class, ['slug' => $course->slug])
        ->assertViewHas('canAccess', true)
        ->assertDontSee('This course is locked');

    Livewire::test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', true)
        ->assertDontSee('This chapter is locked')
        ->assertSee('Discounted Cash Flow Model');
});

test('user with expired subscription is blocked by paywall', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    // Expired subscription
    Subscription::create([
        'user_id' => $user->id,
        'status' => 'expired',
        'starts_at' => now()->subDays(35),
        'ends_at' => now()->subDays(5),
        'gateway' => 'safepay',
        'gateway_reference' => 'ref_expired_999',
    ]);

    expect($user->hasActiveSubscription())->toBeFalse();

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'order' => 1,
    ]);

    $this->actingAs($user);

    Livewire::test(CourseDetail::class, ['slug' => $course->slug])
        ->assertViewHas('canAccess', false)
        ->assertSee('This course is locked');
});
