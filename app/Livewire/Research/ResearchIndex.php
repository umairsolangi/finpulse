<?php

namespace App\Livewire\Research;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Models\ContentItem;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ResearchIndex extends Component
{
    use WithPagination;

    #[Url(as: 'tier')]
    public string $tier = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    public function updatedTier(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['tier', 'search']);
        $this->resetPage();
    }

    public function render()
    {
        $query = ContentItem::query()
            ->with('author')
            ->where('type', ContentType::RESEARCH_SUMMARY)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');

        if ($this->tier !== 'all' && ContentTier::tryFrom($this->tier)) {
            $query->where('tier', $this->tier);
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('body', 'like', "%{$term}%");
            });
        }

        $items = $query->paginate(9);

        return view('livewire.research.research-index', [
            'items' => $items,
            'tiers' => ContentTier::cases(),
        ]);
    }
}
