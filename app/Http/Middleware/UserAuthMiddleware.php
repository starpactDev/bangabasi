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
            // Store the current URL in the session
            session(['url.intended' => url()->current()]);
            // If the user is authenticated, redirect to a specific page (e.g., dashboard)
            return redirect('/login')->with('error', 'You must be logged in to access this page.')->with('redirect_to', url()->current());
        }
        else if(Auth::user()->usertype !== 'user')
        {
            return redirect('/login')->with('error', 'You do not have the required permissions.');
        }

        return $next($request);
    }
}
