<?php

namespace App\Livewire\Admin\Batches;

use App\Models\Batch;
use App\Models\BatchEnrollment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Batch $batch;

    #[Url(as: 'q')]
    public string $search = '';

    public ?int $confirmRemoveUserId = null;

    public function mount(int $id): void
    {
        $this->batch = Batch::with(['course', 'creator'])->findOrFail($id);

        abort_unless($this->canManage(), 403);
    }

    /**
     * Determine if the current user can manage this batch's students.
     * Admins can manage any batch; Instructors only batches for courses they created.
     */
    private function canManage(): bool
    {
        $user = auth()->user();

        if (! $user->can('batches.manage-students')) {
            return false;
        }

        if ($user->can('batches.create')) {
            return true; // Admin
        }

        // Instructor: only batches for their courses
        return $this->batch->course->created_by === $user->id;
    }

    public function addStudent(int $userId): void
    {
        abort_unless($this->canManage(), 403);

        $this->validate([
            'search' => ['nullable', 'string'],
        ]);

        // Prevent duplicate enrollment (unique constraint also covers this at DB level)
        $alreadyEnrolled = BatchEnrollment::where('batch_id', $this->batch->id)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyEnrolled) {
            session()->flash('error', 'This user is already enrolled in this batch.');

            return;
        }

        BatchEnrollment::create([
            'batch_id' => $this->batch->id,
            'user_id' => $userId,
            'added_by' => auth()->id(),
            'enrolled_at' => now(),
        ]);

        $this->search = '';
        session()->flash('success', 'Student added to batch.');
    }

    public function confirmRemove(int $userId): void
    {
        $this->confirmRemoveUserId = $userId;
    }

    public function removeStudent(): void
    {
        abort_unless($this->canManage(), 403);

        if (! $this->confirmRemoveUserId) {
            return;
        }

        BatchEnrollment::where('batch_id', $this->batch->id)
            ->where('user_id', $this->confirmRemoveUserId)
            ->delete();

        $this->confirmRemoveUserId = null;
        session()->flash('success', 'Student removed from batch.');
    }

    public function cancelRemove(): void
    {
        $this->confirmRemoveUserId = null;
    }

    public function render()
    {
        $enrollments = BatchEnrollment::where('batch_id', $this->batch->id)
            ->with(['user', 'addedBy'])
            ->latest('enrolled_at')
            ->get();

        $enrolledUserIds = $enrollments->pluck('user_id')->all();

        $searchResults = collect();
        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $searchResults = User::whereNotIn('id', $enrolledUserIds)
                ->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                })
                ->with('roles')
                ->limit(10)
                ->get();
        }

        return view('livewire.admin.batches.show', [
            'batch' => $this->batch,
            'enrollments' => $enrollments,
            'searchResults' => $searchResults,
        ]);
    }
}
