<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // If the user is authenticated, redirect to a specific page (e.g., dashboard)
            return redirect('/login')->with('error', 'You must be logged in to access this page.');
        }
        else if(Auth::user()->usertype !== 'user')
        {
            return redirect('/login')->with('error', 'You do not have the required permissions.');
        }

        return $next($request);
    }
}
