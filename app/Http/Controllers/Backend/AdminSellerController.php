<?php

namespace App\Http\Controllers\Backend;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminSellerController extends Controller
{
    public function index()
    {
        $sellers = DB::table('sellers')
            ->join('users', 'sellers.user_id', '=', 'users.id')
            ->leftJoin('order_item_breakdowns', 'order_item_breakdowns.seller_id', '=', 'sellers.user_id')
            ->select([
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) as name"),
                'users.email',
                'sellers.is_active as status',
                DB::raw("DATE_FORMAT(sellers.created_at, '%Y-%m-%d') as join_on"),
                'sellers.id as seller_id',
                DB::raw("COALESCE(SUM(order_item_breakdowns.amount_to_seller), 0) as total_earnings"), // Sum amount earned
                DB::raw("COALESCE(COUNT(order_item_breakdowns.order_item_id), 0) as total_products_sold") // Count of sold products
            ])
            ->groupBy('sellers.id', 'users.firstname', 'users.lastname', 'users.email', 'sellers.is_active', 'sellers.created_at')
            ->get();
            
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