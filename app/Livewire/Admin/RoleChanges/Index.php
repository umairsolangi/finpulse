<?php

namespace App\Livewire\Admin\RoleChanges;

use App\Models\RoleChangeLog;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'target')]
    public string $targetFilter = '';

    #[Url(as: 'actor')]
    public string $actorFilter = '';

    public function updatedTargetFilter(): void
    {
        $this->resetPage();
    }

    public function updatedActorFilter(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['targetFilter', 'actorFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $query = RoleChangeLog::with(['targetUser', 'changedByUser'])
            ->latest('created_at');

        if (trim($this->targetFilter) !== '') {
            $term = trim($this->targetFilter);
            $query->whereHas('targetUser', function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        }

        if (trim($this->actorFilter) !== '') {
            $term = trim($this->actorFilter);
            $query->whereHas('changedByUser', function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        }

        $logs = $query->paginate(25);

        return view('livewire.admin.role-changes.index', [
            'logs' => $logs,
        ]);
    }
}
