<?php

namespace App\Livewire\Learn;

use App\Models\ContentItem;
use App\Models\ContentView;
use App\Services\BadgeAwardService;
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

        if (auth()->check()) {
            $user = auth()->user();
            ContentView::firstOrCreate([
                'user_id' => $user->id,
                'content_item_id' => $this->contentItem->id,
            ]);

            $awardedBadge = app(BadgeAwardService::class)->checkMarketExplorer($user);
            if ($awardedBadge) {
                $this->dispatch('badge-earned', badge: $awardedBadge->name);
            }
        }
    }

    public function render()
    {
        return view('livewire.learn.learn-detail', [
            'item' => $this->contentItem,
        ]);
    }
}
