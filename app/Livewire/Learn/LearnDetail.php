<?php

namespace App\Livewire\Learn;

use App\Models\ContentItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LearnDetail extends Component
{
    public ContentItem $contentItem;

    public function mount(string $slug): void
    {
        $this->contentItem = ContentItem::where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.learn.learn-detail', [
            'item' => $this->contentItem,
        ]);
    }
}
