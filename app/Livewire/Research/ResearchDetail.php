<?php

namespace App\Livewire\Research;

use App\Models\ContentItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ResearchDetail extends Component
{
    public ContentItem $contentItem;

    public function mount(string $slug): void
    {
        $this->contentItem = ContentItem::with('author')
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();
    }

    public function render()
    {
        $item = $this->contentItem;
        $isFree = $item->tier->value === 'free';
        $isRegistered = $item->tier->value === 'registered';
        $isPaid = $item->tier->value === 'paid';

        $canAccess = $isFree || (
            auth()->check() && (
                $isRegistered ||
                auth()->user()->hasRole(['Paid Subscriber', 'Instructor', 'Admin'])
            )
        );

        return view('livewire.research.research-detail', [
            'item' => $item,
            'canAccess' => $canAccess,
            'isFree' => $isFree,
            'isRegistered' => $isRegistered,
            'isPaid' => $isPaid,
        ]);
    }
}
