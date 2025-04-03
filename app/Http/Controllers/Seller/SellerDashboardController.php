<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
use App\Models\Order;
use App\Models\Seller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\OrderItemBreakdown;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{

    public function dashboard()
    {
        // Get the currently authenticated user (assuming logged in as seller)
        $seller = Auth::user();

        // Count the number of users with 'user' role
        $userCount = User::where('usertype', 'user')->count();


        $authId = Auth::id();
        $sellerId = Seller::where('user_id', $seller->id)->first();

        // Retrieve the order item breakdowns for this seller
        $orderItemBreakdowns = OrderItemBreakdown::where('seller_id', $seller->id)->get();

        // Calculate the total amount that goes to admin
        $totalAdminAmount = $orderItemBreakdowns->sum(function ($orderItem) {
            return $orderItem->item_total - $orderItem->amount_to_seller;
        });

      
        $orderItemCount = OrderItem::whereHas('product', function ($query) use ($authId) {
            $query->where('user_id', $authId);
        })->count();
        
        // Count OrderItems where Product belongs to the authenticated user
        $totalPrice = OrderItem::whereHas('product', function ($query) use ($authId) {
            $query->where('user_id', $authId);
        })->sum('unit_price');
       
        // Get the products purchased by the logged-in seller's orders
        $purchasedProducts = OrderItem::with('product')
            ->whereHas('order', function($query) use ($seller) {
                $query->where('user_id', $seller->id); // Filter orders by seller ID
            })
            ->select('product_id', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('product_id') // Group by product
            ->orderBy('purchase_count', 'DESC') // Order by count
            ->take(4)
            ->get();

        // Get the sales and total price data for the logged-in seller
        $usersWithSalesAndPrice = Order::with('user')
            ->where('user_id', $seller->id) // Only get orders belonging to this seller
            ->get()
            ->groupBy('user_id') // Group orders by user_id
            ->map(function ($orders, $userId) {
                // Compute the sales count for this user
                $salesCount = OrderItem::whereIn('order_id', $orders->pluck('id'))->count();

                // Compute the total price for this user
                $totalPrice = $orders->sum('price');

                // Get user details (using the first order, as all belong to the same user)
                $user = $orders->first()->user;

                // Add sales and total price data to user
                $user->sales = $salesCount;
                $user->total_price = $totalPrice;

                return $user;
            });

        // Get all orders made by the seller
        $orders = Order::where('user_id', $seller->id)->get();

        // Get the order items for this seller (you can filter this if needed, like only items from seller's orders)
        $orderItems = OrderItem::with('order')
            ->whereHas('order', function($query) use ($seller) {
                $query->where('user_id', $seller->id); // Ensure the order belongs to the seller
            })
            ->take(5)
            ->get();

        // Return the view for the seller dashboard with the necessary data
        return view('seller.dashboard', compact('userCount','totalPrice', 'totalAdminAmount', 'orderItemCount', 'purchasedProducts', 'usersWithSalesAndPrice', 'orders', 'orderItems'));
    }

    



}
