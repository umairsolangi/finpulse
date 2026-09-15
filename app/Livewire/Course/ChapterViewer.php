<?php

namespace App\Livewire\Course;

use App\Enums\ContentTier;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\CertificateService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ChapterViewer extends Component
{
    public Course $course;

    public CourseChapter $chapter;

    public ?Quiz $quiz = null;

    public bool $isCompleted = false;

    public bool $hasPassedQuiz = false;

    public bool $showQuiz = false;

    public bool $quizSubmitted = false;

    public ?QuizAttempt $latestAttempt = null;

    /** @var array<int, int> */
    public array $selectedAnswers = [];

    public function mount(string $slug, int $chapterId): void
    {
        $this->course = Course::where('slug', $slug)->firstOrFail();

        $this->chapter = CourseChapter::where('course_id', $this->course->id)
            ->where('id', $chapterId)
            ->with(['contentItem', 'quiz.questions.options'])
            ->firstOrFail();

        $this->quiz = $this->chapter->quiz;

        if (auth()->check()) {
            $this->isCompleted = CourseProgress::where('user_id', auth()->id())
                ->where('chapter_id', $this->chapter->id)
                ->whereNotNull('completed_at')
                ->exists();

            if ($this->quiz) {
                $this->hasPassedQuiz = $this->quiz->attempts()
                    ->where('user_id', auth()->id())
                    ->where('passed', true)
                    ->exists();

                $this->latestAttempt = $this->quiz->attempts()
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->first();
            }
        }
    }

    public function markAsComplete(CertificateService $certificateService): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        // If chapter has a quiz attached, must pass quiz first
        if ($this->quiz && ! $this->hasPassedQuiz) {
            $this->showQuiz = true;

            return;
        }

        CourseProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'chapter_id' => $this->chapter->id,
            ],
            [
                'course_id' => $this->course->id,
                'completed_at' => now(),
            ]
        );

        $this->isCompleted = true;

        $certificateService->checkAndIssueCertificate(auth()->user(), $this->course);
    }

    public function submitQuiz(CertificateService $certificateService): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if (! $this->quiz) {
            return;
        }

        $questions = $this->quiz->questions()->with('options')->get();
        if ($questions->isEmpty()) {
            return;
        }

        $correctCount = 0;
        foreach ($questions as $question) {
            $selectedOptionId = $this->selectedAnswers[$question->id] ?? null;
            if ($selectedOptionId) {
                $option = $question->options->first(fn ($opt) => (int) $opt->id === (int) $selectedOptionId);
                if ($option && $option->is_correct) {
                    $correctCount++;
                }
            }
        }

        $score = (int) round(($correctCount / $questions->count()) * 100);
        $passThreshold = (int) config('gamification.quiz_pass_percentage', 70);
        $passed = $score >= $passThreshold;

        $this->latestAttempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $this->quiz->id,
            'score' => $score,
            'passed' => $passed,
            'completed_at' => now(),
        ]);

        $this->quizSubmitted = true;

        if ($passed) {
            $this->hasPassedQuiz = true;

            CourseProgress::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'chapter_id' => $this->chapter->id,
                ],
                [
                    'course_id' => $this->course->id,
                    'completed_at' => now(),
                ]
            );

            $this->isCompleted = true;

            $certificateService->checkAndIssueCertificate(auth()->user(), $this->course);
        }
    }

    public function retakeQuiz(): void
    {
        $this->selectedAnswers = [];
        $this->quizSubmitted = false;
    }

    public function render()
    {
        $chapters = $this->course->chapters()
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $currentIndex = $chapters->search(fn ($ch) => $ch->id === $this->chapter->id);
        $totalChapters = $chapters->count();

        $prevChapter = ($currentIndex !== false && $currentIndex > 0)
            ? $chapters[$currentIndex - 1]
            : null;

        $nextChapter = ($currentIndex !== false && $currentIndex < $totalChapters - 1)
            ? $chapters[$currentIndex + 1]
            : null;

        $isLastChapter = ($currentIndex !== false && $currentIndex === $totalChapters - 1);

        $completedChapterIds = [];
        if (auth()->check()) {
            $completedChapterIds = CourseProgress::where('user_id', auth()->id())
                ->where('course_id', $this->course->id)
                ->whereNotNull('completed_at')
                ->pluck('chapter_id')
                ->all();
        }

        $isFreeTier = ($this->course->tier?->value ?? $this->course->tier) === ContentTier::FREE->value;

        return view('livewire.course.chapter-viewer', [
            'course' => $this->course,
            'chapter' => $this->chapter,
            'quiz' => $this->quiz,
            'chapters' => $chapters,
            'currentIndex' => $currentIndex !== false ? $currentIndex + 1 : 1,
            'totalChapters' => $totalChapters,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
            'isLastChapter' => $isLastChapter,
            'completedChapterIds' => $completedChapterIds,
            'isFreeTier' => $isFreeTier,
        ]);
    }
}
