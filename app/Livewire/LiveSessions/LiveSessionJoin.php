<?php

namespace App\Livewire\LiveSessions;

use App\Models\LiveSession;
use App\Services\AgoraService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LiveSessionJoin extends Component
{
    public LiveSession $session;

    public bool $isHost = false;

    public bool $hasBooking = false;

    public bool $isJoinable = false;

    public bool $isEnded = false;

    public ?string $appId = null;

    public ?string $agoraToken = null;

    public string $channelName = '';

    public int $uid = 0;

    public bool $testingMode = false;

    public function mount(LiveSession $session, AgoraService $agoraService): void
    {
        if (! auth()->check()) {
            redirect()->guest(route('login'));

            return;
        }

        $this->session = $session;
        $user = auth()->user();

        // Host is either the session's designated host OR any user with Admin role
        $this->isHost = (int) $session->host_id === (int) $user->id || $user->hasRole('Admin');
        $this->hasBooking = $session->bookings()->where('user_id', $user->id)->exists();

        // Access control: only the host/admin or confirmed booked users can enter
        if (! $this->isHost && ! $this->hasBooking) {
            abort(403, 'Unauthorized. You must be the host or have a valid booking to join this live session.');
        }

        $this->isEnded = $session->isEnded();
        $this->isJoinable = $session->isJoinable();

        // If the session has already ended or is not joinable yet, don't generate credentials
        if ($this->isEnded || (! $this->isJoinable && ! $this->isHost)) {
            return;
        }

        // Generate Agora token credentials
        $payload = $agoraService->generateTokenForSession($session, $user);

        $this->appId = $payload['app_id'];
        $this->agoraToken = $payload['token'];
        $this->channelName = $payload['channel_name'];
        $this->uid = $payload['uid'];
        $this->testingMode = $payload['testing_mode'];

        // Mark attendance for booked attendees upon entering the room
        if ($this->hasBooking) {
            $session->bookings()
                ->where('user_id', $user->id)
                ->where('attended', false)
                ->update(['attended' => true]);
        }
    }

    public function endSession()
    {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $user = auth()->user();
        $isAuthorized = (int) $this->session->host_id === (int) $user->id || $user->hasRole('Admin');

        if (! $isAuthorized) {
            abort(403, 'Unauthorized. Only the session host or an administrator can end this session.');
        }

        $this->session->update([
            'ended_at' => now(),
        ]);

        $this->isEnded = true;
        $this->isJoinable = false;

        $this->dispatch('session-ended');

        session()->flash('success', 'Live session "'.$this->session->title.'" has been ended.');

        return redirect()->route('live-sessions.index');
    }

    public function checkSessionStatus(): void
    {
        $this->session->refresh();
        if ($this->session->isEnded()) {
            $this->isEnded = true;
            $this->isJoinable = false;
            $this->dispatch('session-ended');
        }
    }

    public function render()
    {
        return view('livewire.live-sessions.live-session-join');
    }
}
