<?php

namespace App\Livewire\Admin\Batches;

use App\Enums\BatchStatus;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    use AuthorizesRequests;

    public string $name = '';

    public string $courseId = '';

    public string $startDate = '';

    public string $status = 'upcoming';

    public bool $showCreateForm = false;

    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('batches.create') || auth()->user()->can('batches.manage-students'),
            403
        );
    }

    public function toggleCreateForm(): void
    {
        abort_unless(auth()->user()->can('batches.create'), 403);
        $this->showCreateForm = ! $this->showCreateForm;
    }

    public function createBatch(): void
    {
        abort_unless(auth()->user()->can('batches.create'), 403);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'courseId' => ['required', 'exists:courses,id'],
            'startDate' => ['nullable', 'date'],
            'status' => ['required', 'in:upcoming,active,completed'],
        ]);

        $course = Course::findOrFail($validated['courseId']);

        // Auto-enable restricted_to_batches on the course if not already set
        if (! $course->restricted_to_batches) {
            $course->update(['restricted_to_batches' => true]);
        }

        Batch::create([
            'name' => $validated['name'],
            'course_id' => $course->id,
            'created_by' => auth()->id(),
            'start_date' => $validated['startDate'] ?: null,
            'status' => $validated['status'],
        ]);

        $this->reset(['name', 'courseId', 'startDate', 'status', 'showCreateForm']);
        $this->status = 'upcoming';

        session()->flash('success', 'Batch created successfully.');
    }

    public function render()
    {
        $user = auth()->user();

        $batchQuery = Batch::with(['course', 'creator'])
            ->withCount('enrollments');

        // Instructors only see batches for courses they created
        if (! $user->can('batches.create')) {
            $batchQuery->whereHas('course', fn ($q) => $q->where('created_by', $user->id));
        }

        $batches = $batchQuery->latest()->get();

        $courses = Course::orderBy('title')->get();

        return view('livewire.admin.batches.index', [
            'batches' => $batches,
            'courses' => $courses,
            'statuses' => BatchStatus::cases(),
        ]);
    }
}
