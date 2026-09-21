<?php

namespace App\Livewire\Learn;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\ContentBookmark;
use App\Models\ContentItem;
use App\Models\ContentView;
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

    #[Url(as: 'saved')]
    public bool $onlyBookmarks = false;

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

    public function updatedOnlyBookmarks(): void
    {
        $this->resetPage();
    }

    public function toggleSavedFilter(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $this->onlyBookmarks = ! $this->onlyBookmarks;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['type', 'skillLevel', 'language', 'search', 'interests', 'onlyBookmarks']);
        $this->resetPage();
    }

    public function render()
    {
        $query = ContentItem::query()
            ->whereNotNull('published_at')
            ->latest('published_at');

        if (! auth()->check() || ! auth()->user()->hasPaidAccess()) {
            $query->whereIn('tier', [ContentTier::FREE, ContentTier::REGISTERED]);
        }

        if ($this->onlyBookmarks && auth()->check()) {
            $bookmarkedIds = ContentBookmark::where('user_id', auth()->id())->pluck('content_item_id');
            $query->whereIn('id', $bookmarkedIds);
        }

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

        $bookmarkedIds = [];
        $completedIds = [];

        if (auth()->check()) {
            $userId = auth()->id();
            $bookmarkedIds = ContentBookmark::where('user_id', $userId)->pluck('content_item_id')->toArray();
            $completedIds = ContentView::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->pluck('content_item_id')
                ->toArray();
        }

        return view('livewire.learn.learn-index', [
            'items' => $items,
            'types' => ContentType::cases(),
            'skillLevels' => SkillLevel::cases(),
            'languages' => Language::cases(),
            'bookmarkedIds' => $bookmarkedIds,
            'completedIds' => $completedIds,
        ]);
    }
}
