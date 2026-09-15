<?php

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Livewire\Course\ChapterViewer;
use App\Livewire\Course\CourseDetail;
use App\Livewire\NotificationBell;
use App\Livewire\Research\ResearchCreate;
use App\Livewire\Research\ResearchDetail;
use App\Livewire\Research\ResearchIndex;
use App\Models\Certificate;
use App\Models\ContentItem;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Notifications\NewChapterPublished;
use App\Notifications\NewResearchSummaryPublished;
use App\Services\CertificateService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

/*
|--------------------------------------------------------------------------
| Part 1: Quizzes & Chapter Gating
|--------------------------------------------------------------------------
*/

test('quiz evaluates user answers, enforces 70 percent pass threshold, and gates chapter completion', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();

    $course = Course::factory()->create([
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Technical Analysis Basics',
        'order' => 1,
    ]);

    $quiz = Quiz::create(['course_chapter_id' => $chapter->id]);

    // Question 1
    $q1 = QuizQuestion::create([
        'quiz_id' => $quiz->id,
        'question' => 'What does RSI measure?',
        'order' => 1,
    ]);
    $q1Correct = QuizOption::create([
        'quiz_question_id' => $q1->id,
        'option_text' => 'Momentum oscillator',
        'is_correct' => true,
    ]);
    $q1Wrong = QuizOption::create([
        'quiz_question_id' => $q1->id,
        'option_text' => 'Dividend yield',
        'is_correct' => false,
    ]);

    // Question 2
    $q2 = QuizQuestion::create([
        'quiz_id' => $quiz->id,
        'question' => 'What is a bull market?',
        'order' => 2,
    ]);
    $q2Correct = QuizOption::create([
        'quiz_question_id' => $q2->id,
        'option_text' => 'A rising market',
        'is_correct' => true,
    ]);
    $q2Wrong = QuizOption::create([
        'quiz_question_id' => $q2->id,
        'option_text' => 'A declining market',
        'is_correct' => false,
    ]);

    // 1. User fails quiz (0% or 50% < 70%)
    Livewire::actingAs($user)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->set('selectedAnswers.'.$q1->id, $q1Wrong->id)
        ->set('selectedAnswers.'.$q2->id, $q2Wrong->id)
        ->call('submitQuiz')
        ->assertSet('hasPassedQuiz', false)
        ->assertSet('quizSubmitted', true)
        ->assertSee('Assessment Not Passed')
        ->assertSee('Retake Quiz');

    expect(QuizAttempt::where('user_id', $user->id)->where('quiz_id', $quiz->id)->first()->passed)->toBeFalse();

    // Verify markAsComplete is blocked when quiz is not passed
    Livewire::actingAs($user)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->call('markAsComplete');

    expect(CourseProgress::where('user_id', $user->id)->where('chapter_id', $chapter->id)->first()?->is_completed)->toBeFalsy();

    // 2. User retakes and passes quiz (100% >= 70%)
    Livewire::actingAs($user)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->call('retakeQuiz')
        ->set('selectedAnswers', [
            $q1->id => $q1Correct->id,
            $q2->id => $q2Correct->id,
        ])
        ->call('submitQuiz')
        ->assertSet('hasPassedQuiz', true)
        ->assertSet('isCompleted', true);

    expect(QuizAttempt::where('user_id', $user->id)->where('quiz_id', $quiz->id)->latest('id')->first()->passed)->toBeTrue();

    // User can also call markAsComplete
    Livewire::actingAs($user)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->call('markAsComplete')
        ->assertSet('isCompleted', true);

    expect(CourseProgress::where('user_id', $user->id)->where('chapter_id', $chapter->id)->first()->is_completed)->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Part 2: Certificates
|--------------------------------------------------------------------------
*/

test('completing a course issues a certificate which can be securely downloaded by owner but forbidden to others', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $author = User::factory()->create();

    $course = Course::factory()->create([
        'title' => 'Algorithmic Risk Management',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Value at Risk (VaR)',
        'order' => 1,
    ]);

    // Mark chapter completed
    CourseProgress::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter->id,
        'is_completed' => true,
        'completed_at' => now(),
    ]);

    $certificateService = app(CertificateService::class);
    $cert = $certificateService->issueIfEligible($user, $course);

    expect($cert)->not->toBeNull()
        ->and($cert->user_id)->toBe($user->id)
        ->and($cert->course_id)->toBe($course->id)
        ->and($cert->certificate_number)->toStartWith('FP-');

    // Duplicate call should return existing certificate without re-creating
    $sameCert = $certificateService->issueIfEligible($user, $course);
    expect($sameCert->id)->toBe($cert->id);

    // Course detail shows download certificate button for completed course
    Livewire::actingAs($user)
        ->test(CourseDetail::class, ['slug' => $course->slug])
        ->assertSee('Download Certificate')
        ->assertSee(route('certificates.download', $cert->id));

    // Owner downloads certificate -> 200 OK
    $this->actingAs($user)
        ->get(route('certificates.download', $cert->id))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');

    // Other user downloads certificate -> 403 Forbidden
    $this->actingAs($otherUser)
        ->get(route('certificates.download', $cert->id))
        ->assertForbidden();

    // Guest gets redirected to login
    auth()->logout();
    $this->get(route('certificates.download', $cert->id))
        ->assertRedirect(route('login'));

    // Profile page shows certificate
    $this->actingAs($user)
        ->get(route('profile'))
        ->assertOk()
        ->assertSee('Algorithmic Risk Management')
        ->assertSee($cert->certificate_number)
        ->assertSee(route('certificates.download', $cert->id));
});

/*
|--------------------------------------------------------------------------
| Part 3: Research Summaries
|--------------------------------------------------------------------------
*/

test('research catalog displays published items and enforces tier gating', function () {
    $author = User::factory()->create();

    $publishedFree = ContentItem::create([
        'title' => 'Macro Liquidity Trends 2026',
        'slug' => 'macro-liquidity-trends-2026',
        'type' => ContentType::RESEARCH_SUMMARY,
        'tier' => ContentTier::FREE,
        'language' => Language::ENGLISH,
        'skill_level' => SkillLevel::ADVANCED,
        'body' => 'Comprehensive liquidity analysis across global central banks.',
        'duration_minutes' => 7,
        'published_at' => now()->subDay(),
        'created_by' => $author->id,
    ]);

    $publishedPaid = ContentItem::create([
        'title' => 'Sovereign Debt Default Scenarios',
        'slug' => 'sovereign-debt-default-scenarios',
        'type' => ContentType::RESEARCH_SUMMARY,
        'tier' => ContentTier::PAID,
        'language' => Language::ENGLISH,
        'skill_level' => SkillLevel::ADVANCED,
        'body' => 'Confidential sovereign balance sheet stress tests.',
        'duration_minutes' => 12,
        'published_at' => now()->subHours(2),
        'created_by' => $author->id,
    ]);

    $futureScheduled = ContentItem::create([
        'title' => 'Future Crypto Regulatory Roadmap',
        'slug' => 'future-crypto-regulatory-roadmap',
        'type' => ContentType::RESEARCH_SUMMARY,
        'tier' => ContentTier::FREE,
        'language' => Language::ENGLISH,
        'skill_level' => SkillLevel::INTERMEDIATE,
        'body' => 'Upcoming forecast.',
        'published_at' => now()->addDays(3),
        'created_by' => $author->id,
    ]);

    // Public catalog
    Livewire::test(ResearchIndex::class)
        ->assertSee('Macro Liquidity Trends 2026')
        ->assertSee('Sovereign Debt Default Scenarios')
        ->assertDontSee('Future Crypto Regulatory Roadmap');

    // Free item detail is accessible to guest
    Livewire::test(ResearchDetail::class, ['slug' => $publishedFree->slug])
        ->assertSee('Macro Liquidity Trends 2026')
        ->assertSee('Comprehensive liquidity analysis across global central banks.')
        ->assertDontSee('Premium Institutional Access Required');

    // Paid item detail shows lock prompt to guest
    Livewire::test(ResearchDetail::class, ['slug' => $publishedPaid->slug])
        ->assertSee('Sovereign Debt Default Scenarios')
        ->assertSee('Premium Institutional Access Required');
});

test('authorized users can publish research and notify active users', function () {
    Notification::fake();

    $instructor = User::factory()->create();
    $instructor->assignRole('Instructor');

    $activeUser = User::factory()->create([
        'last_login_at' => now()->subDays(5),
    ]);

    $inactiveUser = User::factory()->create([
        'last_login_at' => now()->subDays(45),
    ]);

    Livewire::actingAs($instructor)
        ->test(ResearchCreate::class)
        ->set('title', 'Global Central Bank Yield Curve Strategies')
        ->set('tier', 'free')
        ->set('durationMinutes', 8)
        ->set('body', 'Detailed institutional overview of central bank rate swap mechanisms.')
        ->set('publishedAt', now()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    $createdItem = ContentItem::where('title', 'Global Central Bank Yield Curve Strategies')->first();
    expect($createdItem)->not->toBeNull()
        ->and($createdItem->type)->toBe(ContentType::RESEARCH_SUMMARY);

    // Active user receives notification, inactive user does not
    Notification::assertSentTo($activeUser, NewResearchSummaryPublished::class, function ($notification) use ($createdItem) {
        return $notification->contentItem->id === $createdItem->id;
    });

    Notification::assertNotSentTo($inactiveUser, NewResearchSummaryPublished::class);
});

/*
|--------------------------------------------------------------------------
| Part 4: Notifications & Notification Bell
|--------------------------------------------------------------------------
*/

test('adding a new chapter triggers notification for learners with course progress', function () {
    Notification::fake();

    $author = User::factory()->create();
    $enrolledLearner = User::factory()->create();
    $uninvolvedLearner = User::factory()->create();

    $course = Course::factory()->create([
        'title' => 'Options Trading Foundation',
        'tier' => ContentTier::FREE,
        'created_by' => $author->id,
    ]);

    $firstChapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Calls vs Puts',
        'order' => 1,
    ]);

    // Enrolled learner has progress
    CourseProgress::create([
        'user_id' => $enrolledLearner->id,
        'course_id' => $course->id,
        'chapter_id' => $firstChapter->id,
        'is_completed' => true,
        'completed_at' => now(),
    ]);

    // Now a new chapter is added to the course
    $newChapter = CourseChapter::create([
        'course_id' => $course->id,
        'title' => 'Iron Condor & Strangles',
        'order' => 2,
    ]);

    // Enrolled learner should receive NewChapterPublished notification
    Notification::assertSentTo($enrolledLearner, NewChapterPublished::class, function ($notification) use ($course, $newChapter) {
        return $notification->course->id === $course->id && $notification->chapter->id === $newChapter->id;
    });

    Notification::assertNotSentTo($uninvolvedLearner, NewChapterPublished::class);
});

test('notification bell renders unread count, marks notification as read, and marks all as read', function () {
    $user = User::factory()->create();

    $author = User::factory()->create();
    $course = Course::factory()->create([
        'title' => 'Fixed Income Analytics',
        'created_by' => $author->id,
    ]);
    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'title' => 'Duration & Convexity',
        'order' => 1,
    ]);

    // Send a notification to the user
    $user->notify(new NewChapterPublished($course, $chapter));

    expect($user->unreadNotifications()->count())->toBe(1);

    $notification = $user->unreadNotifications()->first();

    // Notification bell shows unread count 1
    Livewire::actingAs($user)
        ->test(NotificationBell::class)
        ->assertSee('1')
        ->assertSee('Fixed Income Analytics')
        ->call('markAsRead', $notification->id)
        ->assertRedirect(route('courses.chapter', ['slug' => $course->slug, 'chapterId' => $chapter->id]));

    expect($notification->fresh()->read_at)->not->toBeNull();

    // Send another notification and test mark all as read
    $user->notify(new NewChapterPublished($course, $chapter));
    expect($user->unreadNotifications()->count())->toBe(1);

    Livewire::actingAs($user)
        ->test(NotificationBell::class)
        ->call('markAllAsRead');

    expect($user->unreadNotifications()->count())->toBe(0);
});
