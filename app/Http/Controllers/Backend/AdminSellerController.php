<?php

namespace App\Http\Controllers\Backend;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminSellerController extends Controller
{
    public function index(){

        // Fetch sellers and join with users table to get the required data
        $sellers = Seller::select(
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) as name"),
            'users.email',
            'sellers.is_active as status',
            DB::raw("DATE_FORMAT(sellers.created_at, '%Y-%m-%d') as join_on"), // Format date in query
            'sellers.id as seller_id'
        )
        ->join('users', 'sellers.user_id', '=', 'users.id')
        ->get();

        // Pass data to the view
        return view('admin.pages.seller.sellerlist', compact('sellers'));
    }

    public function toggleStatus($id)
    {
        // Find the seller by ID
        $seller = Seller::findOrFail($id);

        // Toggle the `is_active` status
        $seller->is_active = !$seller->is_active;
        $seller->save();

        // Redirect back with a success message
        return redirect()->route('admin_sellerlist')->with('success', 'Seller status updated successfully.');
    }


}