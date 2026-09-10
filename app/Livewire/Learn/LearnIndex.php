<?php

namespace App\Livewire\Learn;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\ContentItem;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class LearnIndex extends Component
{
    use WithPagination;

    #[Url(as: 'type')]
    public string $type = 'all';

    #[Url(as: 'level')]
    public string $skillLevel = 'all';

    #[Url(as: 'lang')]
    public string $language = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'interests')]
    public string $interests = '';

    public function updatedType(): void
    {
        $this->resetPage();
    }

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

    public function updatedInterests(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['type', 'skillLevel', 'language', 'search', 'interests']);
        $this->resetPage();
    }

    public function render()
    {
        $query = ContentItem::query()
            ->where('tier', ContentTier::FREE)
            ->whereNotNull('published_at')
            ->latest('published_at');

        if ($this->type !== 'all' && ContentType::tryFrom($this->type)) {
            $query->where('type', $this->type);
        }

        if ($this->skillLevel !== 'all' && SkillLevel::tryFrom($this->skillLevel)) {
            $query->where('skill_level', $this->skillLevel);
        }

        if ($this->language !== 'all' && Language::tryFrom($this->language)) {
            $query->where('language', $this->language);
        }

        if (trim($this->search) !== '') {
            $query->where('title', 'like', '%'.trim($this->search).'%');
        }

        if (trim($this->interests) !== '') {
            $terms = explode(',', $this->interests);
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $cleaned = str_replace('_', ' ', trim($term));
                    if (! empty($cleaned)) {
                        $q->orWhere('title', 'like', "%{$cleaned}%")
                            ->orWhere('body', 'like', "%{$cleaned}%");
                    }
                }
            });
        }

        $items = $query->paginate(9);

        return view('livewire.learn.learn-index', [
            'items' => $items,
            'types' => ContentType::cases(),
            'skillLevels' => SkillLevel::cases(),
            'languages' => Language::cases(),
        ]);
    }
}
