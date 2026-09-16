<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequiresPaidAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Authentication required.'], 401);
            }

            return redirect()->guest(route('login'));
        }

        if (! $request->user()->hasPaidAccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Active paid subscription required to access this resource.',
                ], 403);
            }

            return redirect()->route('pricing')->with('warning', 'An active Paid Subscriber membership is required to access this feature.');
        }

        return $next($request);
    }
}
