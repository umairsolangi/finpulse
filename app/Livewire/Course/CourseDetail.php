<?php

namespace App\Livewire\Course;

use App\Enums\ContentTier;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Services\CertificateService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CourseDetail extends Component
{
    public Course $course;

    public function mount(string $slug): void
    {
        $this->course = Course::where('slug', $slug)
            ->with('author')
            ->firstOrFail();
    }

    public function render(CertificateService $certificateService)
    {
        $chapters = $this->course->chapters()
            ->orderBy('order')
            ->orderBy('id')
            ->with(['contentItem', 'quiz'])
            ->get();

        $totalChapters = $chapters->count();
        $completedChapterIds = [];
        $completedCount = 0;
        $hasStarted = false;
        $progressPercent = 0;
        $targetChapter = null;
        $actionType = null; // 'start', 'continue', 'review'
        $certificate = null;

        $firstChapter = $chapters->first();

        if (auth()->check()) {
            $completedChapterIds = CourseProgress::where('user_id', auth()->id())
                ->where('course_id', $this->course->id)
                ->whereNotNull('completed_at')
                ->pluck('chapter_id')
                ->all();

            $completedCount = count($completedChapterIds);
            $hasStarted = $completedCount > 0;
            $progressPercent = $totalChapters > 0 ? (int) round(($completedCount / $totalChapters) * 100) : 0;

            if ($totalChapters > 0 && $completedCount >= $totalChapters) {
                $actionType = 'review';
                $targetChapter = $firstChapter;

                // Check or issue certificate
                $certificate = Certificate::where('user_id', auth()->id())
                    ->where('course_id', $this->course->id)
                    ->first();

                if (! $certificate) {
                    $certificate = $certificateService->checkAndIssueCertificate(auth()->user(), $this->course);
                }
            } elseif ($hasStarted) {
                $actionType = 'continue';
                $targetChapter = $chapters->first(fn ($ch) => ! in_array($ch->id, $completedChapterIds)) ?? $firstChapter;
            } else {
                $actionType = 'start';
                $targetChapter = $firstChapter;
            }
        } else {
            $actionType = 'start';
            $targetChapter = $firstChapter;
        }

        $isFreeTier = ($this->course->tier?->value ?? $this->course->tier) === ContentTier::FREE->value;

        return view('livewire.course.course-detail', [
            'course' => $this->course,
            'chapters' => $chapters,
            'totalChapters' => $totalChapters,
            'completedChapterIds' => $completedChapterIds,
            'completedCount' => $completedCount,
            'hasStarted' => $hasStarted,
            'progressPercent' => $progressPercent,
            'targetChapter' => $targetChapter,
            'actionType' => $actionType,
            'isFreeTier' => $isFreeTier,
            'certificate' => $certificate,
        ]);
    }
}
