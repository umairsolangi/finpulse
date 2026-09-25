<?php

namespace App\Livewire\LiveSessions;

use App\Models\LiveSession;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LiveSessionCreate extends Component
{
    public string $title = '';

    public string $description = '';

    public string $type = 'webinar';

    public string $scheduled_at = '';

    public int $duration_minutes = 60;

    public string $tier = 'paid';

    public bool $is_instant = false;

    public ?string $meeting_url = null;

    public ?int $max_attendees = 50;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10',
            'type' => 'required|in:webinar,one_on_one',
            'scheduled_at' => $this->is_instant ? 'nullable' : 'required|date|after:now - 2 minutes',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'tier' => 'required|in:free,registered,paid',
            'meeting_url' => 'nullable|url',
            'max_attendees' => 'nullable|integer|min:1',
        ];
    }

    protected function messages(): array
    {
        return [
            'scheduled_at.after' => 'The session start time must be in the future or starting now.',
            'meeting_url.url' => 'The custom meeting link must be a valid URL (or leave blank for built-in Agora room).',
        ];
    }

    public function mount(?bool $instant = null): void
    {
        if (! auth()->check() || ! auth()->user()->hasRole(['Instructor', 'Admin'])) {
            abort(403, 'Only instructors and administrators can schedule live sessions.');
        }

        if ($instant || request()->boolean('instant')) {
            $this->is_instant = true;
            $this->title = 'Live Session — '.now()->format('M d, h:i A');
            $this->description = 'Instant live session hosted by '.auth()->user()->name.'.';
            $this->scheduled_at = now()->format('Y-m-d\TH:i');
        } else {
            $this->scheduled_at = now()->addDay()->setTime(18, 0)->format('Y-m-d\TH:i');
        }
    }

    public function updatedIsInstant($value): void
    {
        if ($value) {
            $this->scheduled_at = now()->format('Y-m-d\TH:i');
            if (empty($this->title)) {
                $this->title = 'Live Session — '.now()->format('M d, h:i A');
            }
            if (empty($this->description)) {
                $this->description = 'Instant live session hosted by '.auth()->user()->name.'.';
            }
        } else {
            $this->scheduled_at = now()->addDay()->setTime(18, 0)->format('Y-m-d\TH:i');
        }
    }

    public function updatedType($value): void
    {
        if ($value === 'one_on_one') {
            $this->max_attendees = 2;
        } elseif ($this->max_attendees === 2 || $this->max_attendees === 1) {
            $this->max_attendees = 50;
        }
    }

    public function save()
    {
        if (! auth()->check() || ! auth()->user()->hasRole(['Instructor', 'Admin'])) {
            abort(403, 'Only instructors and administrators can schedule live sessions.');
        }

        $this->validate();

        $start = $this->is_instant ? now() : Carbon::parse($this->scheduled_at);

        if (LiveSession::hostHasOverlap(auth()->id(), $start, $this->duration_minutes)) {
            $this->addError('scheduled_at', 'You already have another live session scheduled during this time window.');

            return;
        }

        $channelName = LiveSession::generateChannelName($this->title);

        $session = LiveSession::create([
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'host_id' => auth()->id(),
            'scheduled_at' => $start,
            'duration_minutes' => $this->duration_minutes,
            'tier' => $this->tier,
            'agora_channel_name' => $channelName,
            'meeting_url' => $this->meeting_url,
            'max_attendees' => $this->type === 'one_on_one' ? 2 : $this->max_attendees,
        ]);

        if (empty($session->meeting_url)) {
            $session->forceFill(['meeting_url' => route('live-sessions.join', $session)])->saveQuietly();
        }

        if ($this->is_instant) {
            session()->flash('success', 'Instant live session started! Entering video room...');

            return redirect()->route('live-sessions.join', $session);
        }

        session()->flash('success', 'Live session scheduled successfully!');

        return redirect()->route('live-sessions.index');
    }

    public function render()
    {
        return view('livewire.live-sessions.live-session-create');
    }
}
