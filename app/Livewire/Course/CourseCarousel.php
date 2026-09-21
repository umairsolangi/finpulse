<?php

namespace App\Livewire\Course;

use App\Enums\CourseTopic;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CourseCarousel extends Component
{
    public string $activeTab = 'new';

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // Get topics that currently have at least one course
        $topics = Course::query()
            ->whereNotNull('topic')
            ->distinct()
            ->pluck('topic')
            ->map(fn ($topic) => $topic instanceof CourseTopic ? $topic : CourseTopic::tryFrom($topic))
            ->filter()
            ->values();

        $query = Course::query()
            ->with(['author'])
            ->withCount('progress');

        if ($this->activeTab === 'new') {
            $query->orderByDesc(DB::raw('COALESCE(published_at, created_at)'));
        } elseif ($this->activeTab === 'popular') {
            $query->orderByDesc('progress_count')
                ->orderByDesc(DB::raw('COALESCE(published_at, created_at)'));
        } else {
            $query->where('topic', $this->activeTab)
                ->orderByDesc(DB::raw('COALESCE(published_at, created_at)'));
        }

        $courses = $query->get();

        return view('livewire.course.course-carousel', [
            'courses' => $courses,
            'topics' => $topics,
        ]);
    }
}
