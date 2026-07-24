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

        if(Auth::check()){


            if(Auth::user()->is_blacklisted){


                Auth::logout();


                return redirect('/login')
                    ->with(
                        'error',
                        'Your account has been blacklisted due to inactivity.'
                    );

            }

        }


        return $next($request);

    }

}