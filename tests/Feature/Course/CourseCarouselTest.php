<?php

use App\Enums\ContentTier;
use App\Enums\CourseTopic;
use App\Livewire\Course\CourseCarousel;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('the homepage renders the our courses carousel component', function () {
    $author = User::factory()->create();
    Course::factory()->create([
        'title' => 'PSX Equity Fundamentals',
        'tier' => ContentTier::FREE,
        'topic' => CourseTopic::STOCKS,
        'created_by' => $author->id,
    ]);

    $response = $this->get('/');
    $response->assertOk()
        ->assertSee('Our Courses')
        ->assertSee('PSX Equity Fundamentals');
});

test('filtering by topic returns only matching courses', function () {
    $author = User::factory()->create();

    $stockCourse = Course::factory()->create([
        'title' => 'Stock Market Investing 101',
        'topic' => CourseTopic::STOCKS,
        'created_by' => $author->id,
    ]);

    $mutualFundCourse = Course::factory()->create([
        'title' => 'Mutual Funds Masterclass',
        'topic' => CourseTopic::MUTUAL_FUNDS,
        'created_by' => $author->id,
    ]);

    Livewire::test(CourseCarousel::class)
        ->assertSee('Stock Market Investing 101')
        ->assertSee('Mutual Funds Masterclass')
        ->call('setTab', CourseTopic::STOCKS->value)
        ->assertSet('activeTab', CourseTopic::STOCKS->value)
        ->assertSee('Stock Market Investing 101')
        ->assertDontSee('Mutual Funds Masterclass')
        ->call('setTab', CourseTopic::MUTUAL_FUNDS->value)
        ->assertSet('activeTab', CourseTopic::MUTUAL_FUNDS->value)
        ->assertSee('Mutual Funds Masterclass')
        ->assertDontSee('Stock Market Investing 101');
});

test('popular tab orders courses by real course_progress counts descending', function () {
    $author = User::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    // Course A has 3 enrollments
    $courseA = Course::factory()->create([
        'title' => 'High Enrollment Course A',
        'topic' => CourseTopic::STOCKS,
        'created_by' => $author->id,
        'published_at' => now()->subDays(10),
    ]);
    $chapterA = CourseChapter::factory()->create(['course_id' => $courseA->id]);
    CourseProgress::create(['user_id' => $user1->id, 'course_id' => $courseA->id, 'chapter_id' => $chapterA->id]);
    CourseProgress::create(['user_id' => $user2->id, 'course_id' => $courseA->id, 'chapter_id' => $chapterA->id]);
    CourseProgress::create(['user_id' => $user3->id, 'course_id' => $courseA->id, 'chapter_id' => $chapterA->id]);

    // Course B has 1 enrollment
    $courseB = Course::factory()->create([
        'title' => 'Moderate Enrollment Course B',
        'topic' => CourseTopic::MUTUAL_FUNDS,
        'created_by' => $author->id,
        'published_at' => now()->subDays(5),
    ]);
    $chapterB = CourseChapter::factory()->create(['course_id' => $courseB->id]);
    CourseProgress::create(['user_id' => $user1->id, 'course_id' => $courseB->id, 'chapter_id' => $chapterB->id]);

    // Course C has 0 enrollments
    $courseC = Course::factory()->create([
        'title' => 'Zero Enrollment Course C',
        'topic' => CourseTopic::BASICS,
        'created_by' => $author->id,
        'published_at' => now()->subDays(1),
    ]);
    CourseChapter::factory()->create(['course_id' => $courseC->id]);

    $test = Livewire::test(CourseCarousel::class)
        ->call('setTab', 'popular');

    $courses = $test->viewData('courses');
    expect($courses->first()->id)->toBe($courseA->id)
        ->and($courses[1]->id)->toBe($courseB->id)
        ->and($courses[2]->id)->toBe($courseC->id);
});

test('included with subscription badge only appears for paid courses', function () {
    $author = User::factory()->create();

    $freeCourse = Course::factory()->create([
        'title' => 'Free Introduction to Money',
        'tier' => ContentTier::FREE,
        'topic' => CourseTopic::BASICS,
        'created_by' => $author->id,
    ]);

    $paidCourse = Course::factory()->create([
        'title' => 'Paid Advanced Derivative Trading',
        'tier' => ContentTier::PAID,
        'topic' => CourseTopic::OPTIONS_DERIVATIVES,
        'created_by' => $author->id,
    ]);

    Livewire::test(CourseCarousel::class)
        ->assertSee('Free Introduction to Money')
        ->assertSee('Paid Advanced Derivative Trading')
        ->assertSee('Included with Subscription')
        ->assertSee('Free');
});

test('enrollment count is hidden when zero and displayed when greater than zero', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();

    $activeCourse = Course::factory()->create([
        'title' => 'Active Course With Enrollees',
        'topic' => CourseTopic::STOCKS,
        'created_by' => $author->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $activeCourse->id]);
    CourseProgress::create([
        'user_id' => $student->id,
        'course_id' => $activeCourse->id,
        'chapter_id' => $chapter->id,
    ]);

    $emptyCourse = Course::factory()->create([
        'title' => 'Brand New Empty Course',
        'topic' => CourseTopic::BASICS,
        'created_by' => $author->id,
    ]);
    CourseChapter::factory()->create(['course_id' => $emptyCourse->id]);

    Livewire::test(CourseCarousel::class)
        ->assertSee('1 Enrolled')
        ->assertDontSee('0 Enrolled');
});

test('topics without courses do not display as filter tabs', function () {
    $author = User::factory()->create();

    Course::factory()->create([
        'title' => 'Only Stocks Course Here',
        'topic' => CourseTopic::STOCKS,
        'created_by' => $author->id,
    ]);

    $component = Livewire::test(CourseCarousel::class);
    $topics = $component->viewData('topics');

    expect($topics->pluck('value')->all())->toContain(CourseTopic::STOCKS->value)
        ->and($topics->pluck('value')->all())->not->toContain(CourseTopic::ISLAMIC_FINANCE->value);
});
