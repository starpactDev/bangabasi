<?php

namespace App\Http\Controllers\Backend;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminConfigurationController extends Controller
{
    public function index()
    {
        // Fetch all coupons with activation status
        $coupons = Coupon::all();
    
        // Return view with the coupons data
        return view('admin.pages.configuration.index', compact('coupons'));
    }

    public function couponStore(Request $request)
    {

        // Validate input
        $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'coupon_type' => 'required|in:amount,percentage',
            'discount_amount' => 'nullable|numeric',
            'discount_percentage' => 'nullable|numeric',
            'expiration_date' => 'required|date|after:today',
        ]);

        // Creating the coupon
        $couponData = [
            'coupon_code' => $request->coupon_code,
            'expiration_date' => $request->expiration_date,
        ];

        if ($request->coupon_type == 'amount') {
            // For amount-based coupon
            $couponData['discount_amount'] = $request->discount_amount;
            $couponData['discount_percentage'] = null; // Null the other field
        } else {
            // For percentage-based coupon
            $couponData['discount_percentage'] = $request->discount_percentage;
            $couponData['discount_amount'] = null; // Null the other field
        }

        // Store the coupon
        Coupon::create($couponData);

        return redirect()->route('admin.configuration')->with('success', 'Coupon created successfully');
            

    }
    
}
