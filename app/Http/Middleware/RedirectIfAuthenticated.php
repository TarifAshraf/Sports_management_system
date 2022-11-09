<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }

        if (Auth::guard($guard)->check())
        {
            $role = Auth()->user()->role;

            if($role == 'player')
            {
                return '/player/dashboard';
            }
            elseif($role == 'agent')
            {
                return '/agent/dashboard';
            }
            elseif($role == 'club')
            {
                return '/club/dashboard';
            }
            elseif($role == 'sponsor')
            {
                return '/sponsor/dashboard';
            }
            elseif($role == 'user')
            {
                return '/user/dashboard';
            }
            else
            {
                return redirect(RouteServiceProvider::LOGOUTROUTE);
            }
        }

        return $next($request);
    }
}
