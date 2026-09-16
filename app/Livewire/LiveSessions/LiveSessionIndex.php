<?php

namespace App\Livewire\LiveSessions;

use App\Models\LiveSession;
use App\Models\LiveSessionBooking;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LiveSessionIndex extends Component
{
    public function bookSession(int $sessionId)
    {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $user = auth()->user();
        $session = LiveSession::findOrFail($sessionId);

        if (! $session->isBookable()) {
            session()->flash('error', 'This live session is already in the past and cannot be booked.');

            return;
        }

        // Tier check
        $isPaid = ($session->tier?->value ?? $session->tier) === 'paid';
        if ($isPaid && ! $user->hasPaidAccess()) {
            session()->flash('warning', 'An active Paid Subscriber membership is required to book this live session.');

            return redirect()->route('pricing');
        }

        // Prevent double-booking
        $alreadyBooked = LiveSessionBooking::where('live_session_id', $session->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyBooked) {
            session()->flash('info', 'You have already booked this session.');

            return;
        }

        // Check capacity
        if ($session->isFull()) {
            session()->flash('error', 'Sorry, this session is fully booked.');

            return;
        }

        // For 1-on-1 sessions, verify user has no overlapping 1-on-1 booking
        if ($session->type === 'one_on_one') {
            $sessionEnd = $session->scheduled_at->copy()->addMinutes($session->duration_minutes);
            $hasOverlap = LiveSessionBooking::where('user_id', $user->id)
                ->whereHas('session', function ($query) use ($session, $sessionEnd) {
                    $query->where('scheduled_at', '<', $sessionEnd)
                        ->whereRaw('DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?', [$session->scheduled_at]);
                })
                ->exists();

            if ($hasOverlap) {
                session()->flash('error', 'You already have another session booked during this time window.');

                return;
            }
        }

        LiveSessionBooking::create([
            'live_session_id' => $session->id,
            'user_id' => $user->id,
            'booked_at' => now(),
        ]);

        session()->flash('success', 'Session booked successfully! A notification and meeting link will be available prior to the start time.');
    }

    public function cancelBooking(int $bookingId)
    {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $booking = LiveSessionBooking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $booking->delete();

        session()->flash('info', 'Your booking has been cancelled.');
    }

    public function render()
    {
        $sessions = LiveSession::upcoming()
            ->with(['host', 'bookings'])
            ->get();

        $userBookings = auth()->check()
            ? auth()->user()->liveSessionBookings()
                ->with('session')
                ->get()
                ->keyBy('live_session_id')
            : collect();

        return view('livewire.live-sessions.live-session-index', [
            'sessions' => $sessions,
            'userBookings' => $userBookings,
            'isInstructorOrAdmin' => auth()->check() && auth()->user()->hasRole(['Instructor', 'Admin']),
            'hasPaidAccess' => auth()->check() ? auth()->user()->hasPaidAccess() : false,
        ]);
    }
}
