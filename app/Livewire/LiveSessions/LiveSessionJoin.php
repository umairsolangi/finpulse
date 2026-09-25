<?php

namespace App\Livewire\LiveSessions;

use App\Models\LiveSession;
use App\Models\LiveSessionBooking;
use App\Models\User;
use App\Services\AgoraService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.live')]
class LiveSessionJoin extends Component
{
    public LiveSession $session;

    public bool $isHost = false;

    public bool $hasBooking = false;

    public bool $isJoinable = false;

    public bool $isEnded = false;

    public bool $showParticipantsModal = false;

    public string $searchUser = '';

    public string $participantTab = 'all';

    public ?string $feedbackMessage = null;

    public ?string $feedbackType = null;

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

    public function openParticipantsModal(): void
    {
        $user = auth()->user();
        if (! $user || ! ((int) $this->session->host_id === (int) $user->id || $user->hasRole('Admin'))) {
            abort(403, 'Unauthorized. Only session hosts and administrators can manage participants.');
        }

        $this->showParticipantsModal = true;
        $this->feedbackMessage = null;
        $this->feedbackType = null;
    }

    public function closeParticipantsModal(): void
    {
        $this->showParticipantsModal = false;
        $this->searchUser = '';
        $this->feedbackMessage = null;
    }

    public function setParticipantTab(string $tab): void
    {
        $this->participantTab = in_array($tab, ['all', 'booked']) ? $tab : 'all';
    }

    public function addParticipant(int $userId): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $isAuthorized = (int) $this->session->host_id === (int) $user->id || $user->hasRole('Admin');
        if (! $isAuthorized) {
            abort(403, 'Unauthorized. Only session hosts and administrators can add participants.');
        }

        if ($this->session->isEnded()) {
            $this->feedbackType = 'error';
            $this->feedbackMessage = 'Cannot add participants to an ended session.';

            return;
        }

        $targetUser = User::find($userId);
        if (! $targetUser) {
            $this->feedbackType = 'error';
            $this->feedbackMessage = 'User not found.';

            return;
        }

        $alreadyBooked = $this->session->bookings()->where('user_id', $targetUser->id)->exists();
        if ($alreadyBooked) {
            $this->feedbackType = 'info';
            $this->feedbackMessage = "{$targetUser->name} is already a participant in this session.";

            return;
        }

        LiveSessionBooking::create([
            'live_session_id' => $this->session->id,
            'user_id' => $targetUser->id,
            'booked_at' => now(),
            'attended' => false,
        ]);

        $this->feedbackType = 'success';
        $this->feedbackMessage = "Added {$targetUser->name} ({$targetUser->email}) to this live session.";
    }

    public function removeParticipant(int $bookingId): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $isAuthorized = (int) $this->session->host_id === (int) $user->id || $user->hasRole('Admin');
        if (! $isAuthorized) {
            abort(403, 'Unauthorized. Only session hosts and administrators can remove participants.');
        }

        $booking = $this->session->bookings()->with('user')->find($bookingId);
        if ($booking) {
            $name = $booking->user->name ?? 'User';
            $booking->delete();
            $this->feedbackType = 'info';
            $this->feedbackMessage = "Removed {$name} from this live session.";
        }
    }

    public function render()
    {
        $currentBookings = $this->session->bookings()
            ->with(['user', 'user.roles'])
            ->latest('id')
            ->get();

        $bookedUserIds = $currentBookings->pluck('user_id')->all();

        $registeredUsers = collect();
        if ($this->showParticipantsModal && $this->isHost) {
            $registeredUsers = User::query()
                ->when($this->searchUser !== '', function ($q) {
                    $term = '%'.trim($this->searchUser).'%';
                    $q->where(function ($sub) use ($term) {
                        $sub->where('name', 'like', $term)
                            ->orWhere('email', 'like', $term);
                    });
                })
                ->where('id', '!=', $this->session->host_id)
                ->with('roles')
                ->orderBy('name')
                ->limit(40)
                ->get();
        }

        return view('livewire.live-sessions.live-session-join', [
            'currentBookings' => $currentBookings,
            'bookedUserIds' => $bookedUserIds,
            'registeredUsers' => $registeredUsers,
        ]);
    }
}
