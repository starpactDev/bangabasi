<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function myOrder()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->whereHas('orderItems.product')
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('myorders', compact('orders'));
    }

    public function placeOrder(OrderRequest $request)
    {
        $user = Auth::user();

        try {
            $order = $this->orderService->createOrder($user, $request);
            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id, "status" => "success"], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }

    public function instantplaceOrder(OrderRequest $request)
    {
        $user = Auth::user();

        try {
            $order = $this->orderService->createOrder($user, $request, true);
            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id, "status" => "success"], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }

    public function cancelOrderItem(Request $request)
    {
        try {
            $orderItem = OrderItem::find($request->order_item_id);
            

            if (!$orderItem) {
                return response()->json(['status' => 'error', 'message' => 'Order Item not found.'], 404);
            }
            

            // Only allow canceling if the order is not already canceled or completed
            if ($orderItem->status == '0' || $orderItem->status == '99') {
                $orderItem->status = 5;
                $orderItem->order_status = 'Cancelled By Customer';
                $orderItem->save();

                ProductSize::where('product_id', $orderItem->product_id)->where('size', $orderItem->sku)->increment('quantity', $orderItem->quantity);
            }
            else{
                return response()->json(['status' => 'error', 'message' => 'Order cannot be canceled.'], 400);
            }

            // Update order item status to canceled



            return response()->json(['status' => 'success', 'message' => 'Order Item canceled successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while canceling the order.'], 500);
        }
    }
}
