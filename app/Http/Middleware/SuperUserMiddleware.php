<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperUserMiddleware
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
            if ($user_type == 'seller' || $user_type == 'admin') {
                return $next($request);
            } else {
                return redirect(url('/seller/login'));
            }
        } else {
            return redirect(url('/seller/login'));
        }
    }
}
