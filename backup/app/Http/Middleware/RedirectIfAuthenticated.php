<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // Admin
            if (Auth::guard($guard)->check() && auth()->user()->roleUID == '1')
                return redirect(RouteServiceProvider::ADMIN);
            // Area Manager
            if (Auth::guard($guard)->check() && auth()->user()->roleUID == '2')
                return redirect(RouteServiceProvider::AREAMANAGER);
            // Commertial Head
            if (Auth::guard($guard)->check() && auth()->user()->roleUID == '3')
                return redirect(RouteServiceProvider::COMMERTIALHEAD);
            // Commertial Team
            if (Auth::guard($guard)->check() && auth()->user()->roleUID == '4')
                return redirect(RouteServiceProvider::COMMERTIALTEAM);
            // Store User
            if (Auth::guard($guard)->check() && auth()->user()->roleUID == '5')
                return redirect(RouteServiceProvider::STOREUSER);
        }

        return $next($request);
    }
}