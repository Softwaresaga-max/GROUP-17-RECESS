<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOnboardingCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            // 1. Block rejected users completely
            if (auth()->user()->onboarding_status === 'rejected') {
                auth()->logout();
                abort(403, 'Account rejected');
            }

            // 2. Force onboarding if not accepted yet
            if (auth()->user()->onboarding_status !== 'accepted') {
                return redirect()->route('onboarding');
            }
        }

        // 3. Otherwise continue normally
        return $next($request);
    }
}