<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (isset($user->id)) {
            $user_type = $user->usertype;

            if ($user_type == 'seller') {
                // Get seller's registration step and is_active status
                $seller = DB::table('sellers')->where('user_id', $user->id)->first();

                if (!$seller) {
                    // Handle case where the seller record does not exist
                    return redirect()->route('seller_registration')->with('error', 'Seller not found. Please register to proceed.');
                }

                // Check if the registration is complete
                if ($seller->registration_step < 5) {
                    return redirect()->route('seller_sellerverification');
                }

                // Check if the seller is active
                if ($seller->is_active == 1) {
                    return $next($request); // Allow access
                } else {
                    // Redirect to a "Pending Approval" or success page
                    return redirect()->route('seller_success');
                }
            } else {
                return redirect()->route('seller_login')->with('error', 'You are not authorized to access this page. Please log in as a seller.'); // Not a seller
            }
        }

        return redirect()->route('seller_login')->with('error', 'You need to log in to continue.'); // Not logged in
    }
}