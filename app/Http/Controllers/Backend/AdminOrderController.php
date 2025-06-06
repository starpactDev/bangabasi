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

    public function getOrderSummary()
    {
        $orders = Order::with('amountBreakdown')
                        ->orderBy('created_at', 'desc')
                        ->get();


        return view('admin.pages.order.summary', compact('orders'));
    }

    public function show($orderId)
    {
        // Fetch a single order with its related data
        $order = Order::with(['amountBreakdown', 'orderItems.product.seller.user', 'orderItems.breakdown', 'user', 'address'])
                        ->where('id', $orderId)
                        ->firstOrFail(); // Throws 404 if not found

        // Extract unique sellers from order items
        $sellers = $order->orderItems
                        ->map(fn($item) => $item->product->seller)
                        ->unique('id') // Ensure unique sellers
                        ->values(); // Reset keys

        //return response()->json($sellers);
        return view('admin.pages.order.show', compact('order', 'sellers'));
    }

    public function transaction()
    {
        $transactions = Order::all();
        return view('admin.pages.transaction.index', compact('transactions'));
    }

    public function viewTransaction($orderId)
    {
        $transaction = Order::with(['amountBreakdown', 'orderItems.product.seller.user', 'orderItems.breakdown', 'user', 'address'])
                                ->where('id', $orderId)
                                ->firstOrFail(); // Throws 404 if not found

        return view('admin.pages.transaction.view', compact('transaction'));
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