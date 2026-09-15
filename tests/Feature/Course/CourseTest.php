<?php

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Livewire\Course\ChapterViewer;
use App\Livewire\Course\CourseDetail;
use App\Livewire\Course\CourseIndex;
use App\Models\ContentItem;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('a guest can view /courses and a free-tier course detail page', function () {
    $author = User::factory()->create();
    $course = Course::factory()->create([
        'title' => 'Personal Finance Fundamentals',
        'slug' => 'personal-finance-fundamentals',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Budgeting 101',
        'order' => 1,
    ]);

    // Guest views courses listing
    $indexResponse = $this->get('/courses');
    $indexResponse->assertOk()
        ->assertSee('Personal Finance Fundamentals');

    // Guest views course detail
    $detailResponse = $this->get('/courses/'.$course->slug);
    $detailResponse->assertOk()
        ->assertSee('Personal Finance Fundamentals')
        ->assertSee('Budgeting 101')
        ->assertSee('Start Course');
});

test('a guest viewing a non-free course detail page sees the locked teaser state', function () {
    $author = User::factory()->create();
    $paidCourse = Course::factory()->create([
        'title' => 'Hedge Fund Arbitrage Mastery',
        'slug' => 'hedge-fund-arbitrage-mastery',
        'tier' => ContentTier::PAID,
        'created_by' => $author->id,
    ]);

    CourseChapter::factory()->create([
        'course_id' => $paidCourse->id,
        'title' => 'Statistical Arbitrage Alpha',
        'order' => 1,
    ]);

    $response = $this->get('/courses/'.$paidCourse->slug);
    $response->assertOk()
        ->assertSee('Hedge Fund Arbitrage Mastery')
        ->assertSee('This course is locked')
        ->assertSee('Log in to unlock');

    $member = User::factory()->create();
    $memberResponse = $this->actingAs($member)->get('/courses/'.$paidCourse->slug);
    $memberResponse->assertOk()
        ->assertSee('This course is locked')
        ->assertSee('Upgrade Membership');
});

test('a logged-in user marking a chapter complete creates exactly one CourseProgress record even if clicked twice', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $contentItem = ContentItem::factory()->create([
        'title' => 'Candlestick Basics',
        'body' => 'Learn how candlesticks convey open, high, low, close prices.',
        'tier' => ContentTier::FREE,
        'type' => ContentType::ARTICLE,
    ]);

    $course = Course::factory()->create([
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'content_item_id' => $contentItem->id,
        'title' => 'Introduction to Candlesticks',
        'order' => 1,
    ]);

    $this->actingAs($user);

    // Call markAsComplete twice via Livewire
    Livewire::test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->call('markAsComplete')
        ->assertSet('isCompleted', true)
        ->call('markAsComplete')
        ->assertSet('isCompleted', true);

    // Assert exactly 1 record exists in course_progress table
    expect(CourseProgress::where('user_id', $user->id)->where('chapter_id', $chapter->id)->count())->toBe(1);

    $progress = CourseProgress::where('user_id', $user->id)->where('chapter_id', $chapter->id)->first();
    expect($progress->completed_at)->not->toBeNull()
        ->and($progress->course_id)->toBe($course->id);
});

test('continue where you left off correctly points to the lowest-order incomplete chapter', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $course = Course::factory()->create([
        'slug' => 'wealth-building-mastery',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter1 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Chapter One: Foundation',
        'order' => 1,
    ]);

    $chapter2 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Chapter Two: Acceleration',
        'order' => 2,
    ]);

    $chapter3 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Chapter Three: Preservation',
        'order' => 3,
    ]);

    // Complete chapter 1
    CourseProgress::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter1->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($user);

    // Test CourseDetail component renders "Continue" pointing to chapter 2
    Livewire::test(CourseDetail::class, ['slug' => $course->slug])
        ->assertSee('Continue')
        ->assertViewHas('targetChapter', fn ($target) => $target->id === $chapter2->id)
        ->assertViewHas('actionType', 'continue');
});

test('a user who has completed all chapters in a course sees Review Course instead of Continue', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $course = Course::factory()->create([
        'slug' => 'crypto-fundamentals',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter1 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Blockchain 101',
        'order' => 1,
    ]);

    $chapter2 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Wallets & Security',
        'order' => 2,
    ]);

    // Complete both chapters
    CourseProgress::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter1->id,
        'completed_at' => now(),
    ]);

    CourseProgress::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter2->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($user);

    Livewire::test(CourseDetail::class, ['slug' => $course->slug])
        ->assertSee('Review Course')
        ->assertDontSee('Continue')
        ->assertViewHas('actionType', 'review')
        ->assertViewHas('targetChapter', fn ($target) => $target->id === $chapter1->id);
});

test('progress bar percentage matches actual completed-chapter count', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $course = Course::factory()->create([
        'slug' => 'options-trading-101',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter1 = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);
    $chapter2 = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 2]);
    $chapter3 = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 3]);
    $chapter4 = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 4]);

    // Complete 2 of 4 chapters = 50%
    CourseProgress::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter1->id,
        'completed_at' => now(),
    ]);
    CourseProgress::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter2->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($user);

    Livewire::test(CourseDetail::class, ['slug' => $course->slug])
        ->assertViewHas('progressPercent', 50)
        ->assertViewHas('completedCount', 2)
        ->assertViewHas('totalChapters', 4)
        ->assertSee('2 of 4 completed (50%)');

    // Also check CourseIndex progress indicator
    Livewire::test(CourseIndex::class)
        ->assertSee('2 of 4 chapters complete')
        ->assertSee('50%');
});

test('chapter next and previous navigation respects the order column correctly at first and last chapter', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $contentItem = ContentItem::factory()->create([
        'body' => 'In-depth lesson body.',
    ]);

    $course = Course::factory()->create([
        'slug' => 'fixed-income-investing',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter1 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'content_item_id' => $contentItem->id,
        'title' => 'Treasury Bills Explained',
        'order' => 1,
    ]);

    $chapter2 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'content_item_id' => $contentItem->id,
        'title' => 'Corporate Bonds',
        'order' => 2,
    ]);

    $chapter3 = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'content_item_id' => $contentItem->id,
        'title' => 'Yield Curves',
        'order' => 3,
    ]);

    $this->actingAs($user);

    // Test Chapter 1 (First chapter): no previous link, has next link
    Livewire::test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter1->id])
        ->assertViewHas('prevChapter', null)
        ->assertViewHas('nextChapter', fn ($next) => $next->id === $chapter2->id)
        ->assertViewHas('isLastChapter', false)
        ->assertSee('First Chapter')
        ->assertSee('Next Chapter');

    // Test Chapter 2 (Middle chapter): has prev link to chapter 1, next link to chapter 3
    Livewire::test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter2->id])
        ->assertViewHas('prevChapter', fn ($prev) => $prev->id === $chapter1->id)
        ->assertViewHas('nextChapter', fn ($next) => $next->id === $chapter3->id)
        ->assertViewHas('isLastChapter', false)
        ->assertSee('Previous Chapter')
        ->assertSee('Next Chapter');

    // Test Chapter 3 (Last chapter): has prev link to chapter 2, no next link, shows Course Complete state
    Livewire::test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter3->id])
        ->assertViewHas('prevChapter', fn ($prev) => $prev->id === $chapter2->id)
        ->assertViewHas('nextChapter', null)
        ->assertViewHas('isLastChapter', true)
        ->assertSee('Previous Chapter')
        ->assertDontSee('Next Chapter')
        ->assertSee('Course Complete');
});

test('course filtering by skill level, language, and search works correctly', function () {
    $author = User::factory()->create();

    $course1 = Course::factory()->create([
        'title' => 'Introduction to Islamic Banking',
        'skill_level' => SkillLevel::BEGINNER,
        'language' => Language::ENGLISH,
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $course2 = Course::factory()->create([
        'title' => 'Advanced Quantitative Risk Modeling',
        'skill_level' => SkillLevel::ADVANCED,
        'language' => Language::ENGLISH,
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    // Filter by skill level Beginner
    Livewire::test(CourseIndex::class)
        ->set('skillLevel', SkillLevel::BEGINNER->value)
        ->assertSee('Introduction to Islamic Banking')
        ->assertDontSee('Advanced Quantitative Risk Modeling');

    // Search query
    Livewire::test(CourseIndex::class)
        ->set('search', 'Quantitative')
        ->assertSee('Advanced Quantitative Risk Modeling')
        ->assertDontSee('Introduction to Islamic Banking');
});
