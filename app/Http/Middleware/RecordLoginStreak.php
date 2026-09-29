<?php

namespace App\Http\Middleware;

use App\Services\StreakService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordLoginStreak
{
    public function __construct(
        public StreakService $streakService,
    ) {}

    /**
     * Record the user's daily login streak. Uses a session flag so we only
     * hit the DB once per session rather than on every single request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! session()->has('streak_recorded_today')) {
            $this->streakService->recordLogin(auth()->user());
            session()->put('streak_recorded_today', true);
        }

        return $next($request);
    }
}
