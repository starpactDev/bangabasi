<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset(Auth::user()->id)) {
            $user_type = Auth::user()->usertype;
            if ($user_type == 'admin') {
                return $next($request);
            } else {
                session(['url.intended' => url()->current()]);
                return redirect(url('/admin-login'));
            }
        } else {
            session(['url.intended' => url()->current()]);
            return redirect(url('/admin-login'));
            
        }
    }
}
