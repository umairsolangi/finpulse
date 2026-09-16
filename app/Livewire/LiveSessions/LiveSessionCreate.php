<?php

namespace App\Livewire\LiveSessions;

use App\Models\LiveSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class LiveSessionCreate extends Component
{
    #[Validate('required|string|min:5|max:255')]
    public string $title = '';

    #[Validate('required|string|min:10')]
    public string $description = '';

    #[Validate('required|in:webinar,one_on_one')]
    public string $type = 'webinar';

    #[Validate('required|date|after:now')]
    public string $scheduled_at = '';

    #[Validate('required|integer|min:15|max:240')]
    public int $duration_minutes = 60;

    #[Validate('required|in:free,registered,paid')]
    public string $tier = 'paid';

    #[Validate('required|url')]
    public string $meeting_url = '';

    #[Validate('nullable|integer|min:1')]
    public ?int $max_attendees = 50;

    public function mount(): void
    {
        if (! auth()->check() || ! auth()->user()->hasRole(['Instructor', 'Admin'])) {
            abort(403, 'Only instructors and administrators can schedule live sessions.');
        }

        // Set default scheduled time to tomorrow at 6 PM
        $this->scheduled_at = now()->addDay()->setTime(18, 0)->format('Y-m-d\TH:i');
    }

    public function updatedType($value): void
    {
        if ($value === 'one_on_one') {
            $this->max_attendees = 1;
        } elseif ($this->max_attendees === 1) {
            $this->max_attendees = 50;
        }
    }

    public function save()
    {
        if (! auth()->check() || ! auth()->user()->hasRole(['Instructor', 'Admin'])) {
            abort(403, 'Only instructors and administrators can schedule live sessions.');
        }

        $this->validate();

        $start = Carbon::parse($this->scheduled_at);
        $end = $start->copy()->addMinutes($this->duration_minutes);

        // Check for conflicting session for same host
        $driver = DB::connection()->getDriverName();
        $overlapRaw = $driver === 'sqlite'
            ? "datetime(scheduled_at, '+' || duration_minutes || ' minutes') > ?"
            : 'DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?';

        $hasOverlap = LiveSession::where('host_id', auth()->id())
            ->where(function ($query) use ($start, $end, $overlapRaw) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('scheduled_at', '>=', $start)
                        ->where('scheduled_at', '<', $end);
                })->orWhere(function ($q) use ($start, $overlapRaw) {
                    $q->where('scheduled_at', '<=', $start)
                        ->whereRaw($overlapRaw, [$start]);
                });
            })
            ->exists();

        if ($hasOverlap) {
            $this->addError('scheduled_at', 'You already have another live session scheduled during this time window.');

            return;
        }

        LiveSession::create([
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'host_id' => auth()->id(),
            'scheduled_at' => $start,
            'duration_minutes' => $this->duration_minutes,
            'tier' => $this->tier,
            'meeting_url' => $this->meeting_url,
            'max_attendees' => $this->type === 'one_on_one' ? 1 : $this->max_attendees,
        ]);

        session()->flash('success', 'Live session scheduled successfully!');

        return redirect()->route('live-sessions.index');
    }

    public function render()
    {
        return view('livewire.live-sessions.live-session-create');
    }
}
