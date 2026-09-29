<?php

namespace App\Livewire;

use App\Models\ContentBookmark;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MyLibrary extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterType = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterType(): void
    {
        $this->resetPage();
    }

    public function removeBookmark(int $bookmarkId): void
    {
        ContentBookmark::where('id', $bookmarkId)
            ->where('user_id', auth()->id())
            ->delete();
    }

    public function render(): View
    {
        $bookmarks = ContentBookmark::with('contentItem.author')
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->whereHas('contentItem', function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->whereHas('contentItem', function ($q) {
                    $q->where('type', $this->filterType);
                });
            })
            ->latest()
            ->paginate(12);

        return view('livewire.my-library', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
