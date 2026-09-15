<?php

namespace App\Livewire\Course;

use App\Enums\ContentTier;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class CourseIndex extends Component
{
    use WithPagination;

    #[Url(as: 'level')]
    public string $skillLevel = 'all';

    #[Url(as: 'lang')]
    public string $language = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'tier')]
    public string $tier = 'all';

    public function updatedSkillLevel(): void
    {
        $this->resetPage();
    }

    public function updatedLanguage(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTier(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['skillLevel', 'language', 'search', 'tier']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Course::query()
            ->with('author')
            ->withCount('chapters');

        if (auth()->check()) {
            $query->withCount([
                'progress as completed_chapters_count' => function ($q) {
                    $q->where('user_id', auth()->id())
                        ->whereNotNull('completed_at');
                },
            ]);
        }

        if ($this->skillLevel !== 'all' && SkillLevel::tryFrom($this->skillLevel)) {
            $query->where('skill_level', $this->skillLevel);
        }

        if ($this->language !== 'all' && Language::tryFrom($this->language)) {
            $query->where('language', $this->language);
        }

        if ($this->tier !== 'all' && ContentTier::tryFrom($this->tier)) {
            $query->where('tier', $this->tier);
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', '%'.$term.'%')
                    ->orWhere('description', 'like', '%'.$term.'%');
            });
        }

        $courses = $query->latest()->paginate(9);

        return view('livewire.course.course-index', [
            'courses' => $courses,
            'skillLevels' => SkillLevel::cases(),
            'languages' => Language::cases(),
            'tiers' => ContentTier::cases(),
        ]);
    }
}
