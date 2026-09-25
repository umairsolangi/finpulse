<?php

namespace App\Http\Controllers;

use App\Models\LiveSession;
use App\Services\AgoraService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgoraTokenController extends Controller
{
    public function __construct(
        protected AgoraService $agoraService
    ) {}

    /**
     * Generate an RTC token for an authenticated user to join a live session.
     *
     * Validates that the requesting user is either the session's host or has
     * an active confirmed booking for the session before issuing any credentials.
     */
    public function token(Request $request, LiveSession $session): JsonResponse
    {
        $user = $request->user();

        $isHost = (int) $session->host_id === (int) $user->id || $user->hasRole('Admin');
        $hasBooking = $session->bookings()->where('user_id', $user->id)->exists();

        // Access control layer: only host/admin or booked attendees can join
        if (! $isHost && ! $hasBooking) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Unauthorized. You must be the host or have a valid booking to join this live session.',
            ], 403);
        }

        if ($session->isEnded()) {
            return response()->json([
                'error' => 'session_ended',
                'message' => 'This live session has already ended.',
            ], 410);
        }

        // Mark attendance for booked attendees upon generating their join credentials
        if ($hasBooking) {
            $session->bookings()
                ->where('user_id', $user->id)
                ->where('attended', false)
                ->update(['attended' => true]);
        }

        $payload = $this->agoraService->generateTokenForSession($session, $user);

        return response()->json($payload);
    }
}
