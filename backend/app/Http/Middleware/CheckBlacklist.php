<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlacklist
{
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {

            $user = Auth::user();

            if ($user->is_blacklisted == 1) {

                Auth::logout();

                return redirect('/login')
                    ->with('error', 'Your account has been blacklisted. Contact the administrator.');

            }

        }

        return $next($request);

    }
}