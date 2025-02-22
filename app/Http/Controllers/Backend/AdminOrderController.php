<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with('order')->get();
        return view('superuser.orders.index',compact('orderItems'));
    }

    public function transaction()
    {
        $transactions = Order::all();
        return view('admin.pages.transaction.index', compact('transactions'));
    }
    

    public function myOrders(){
        // Fetch order items where the related product has user_id = 1
        $orderItems = OrderItem::with('order', 'product') // Eager load both 'order' and 'product' relationships
        ->whereHas('product', function ($query) {
            $query->where('user_id', 1); // Filter products by user_id = 1
        })
        ->get();
            
        return view('admin.pages.order.index', compact('orderItems'));
    }
}