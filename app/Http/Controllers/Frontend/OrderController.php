<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Size;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\IstantBuy;
use App\Models\OrderItem;
use App\Models\PlatformFee;
use App\Models\ProductSize;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CheckoutSession;
use App\Models\OrderItemBreakdown;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\OrderAmountBreakdown;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function myOrder()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch orders for the authenticated user
        $orders = Order::where('user_id', $user->id)
            ->whereHas('orderItems.product') // Filter orders where products exist
            ->with('orderItems.product') // Eager load order items and associated products
            ->latest()->get();

        // Return the view with orders
        return view('myorders', compact('orders'));
    }

    public function showOrderSummary($uniqueId)
    {
        $user = Auth::user();

        // Fetch the order by unique ID and ensure it belongs to the logged-in user
        $order = Order::where('unique_id', $uniqueId)
            ->where('user_id', $user->id)
            ->with([
                'orderItems.product.productImages', // Eager load product + images
                'address' => fn($query) => $query->withTrashed(), // include soft-deleted address
                'amountBreakdown'
            ])
            ->firstOrFail();

        //return response()->json($order);
        return view('order_summary', compact('order'));
    }

    public function placeOrder(Request $request)
    {

        $user = Auth::user();
        $delivery_address = null;

        // Validate incoming request
        $request->validate([
            'total_amount' => 'required|numeric|min:1',
            'checkout_session' => 'required|exists:checkout_sessions,id',
        ]);

        // Retrieve the checkout session from database
        $checkoutSession = CheckoutSession::where('id', $request->checkout_session)
                                            ->where('user_id', $user->id)
                                            ->first();

        if (!$checkoutSession) {
            return response()->json(['message' => 'Invalid checkout session.'], 400);
        }

        // Validate total amount
        if ($checkoutSession->total_amount != $request->total_amount) {
            return response()->json(['message' => 'Total amount mismatch.'], 400);
        }


        // Handle Address
        $delivery_address = $this->_handleAddress($request, $user);
        if (!$delivery_address) {
            return response()->json(['message' => 'Invalid address.'], 400);
        }

        try {
            // Create Order
            $order = $this->_createOrder($user, $checkoutSession, $delivery_address, $request);

            $extra_fee = $checkoutSession->platform_fee + $checkoutSession->shipping_fee - $checkoutSession->coupon_discount;

            // Process Order Items
            $admin_fee = $this->_processOrderItems($order, $user, $extra_fee);
            
            // Store Order Item Breakdown
            $this->_storeOrderItemBreakdown($order);

            // Store Order Amount Breakdown
            $this->_storeOrderAmountBreakdown($order, $checkoutSession, $admin_fee);

            // Clear Checkout Session & Cart
            CheckoutSession::where('id', $request->checkout_session)->delete();
            Cart::where('user_id', $user->id)->delete();

            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id, "status" => "success"], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }



    public function instantplaceOrder(Request $request)
    {

        $user = Auth::user();
        $delivery_address = null;

        // Validate incoming request
        $request->validate([
            'total_amount' => 'required|numeric|min:1',
            'checkout_session' => 'required|exists:checkout_sessions,id',
        ]);
      
        // Retrieve the checkout session from database
        $checkoutSession = CheckoutSession::where('id', $request->checkout_session)
                                            ->where('user_id', $user->id)
                                            ->first();

        if (!$checkoutSession) {
            return response()->json(['message' => 'Invalid checkout session.'], 400);
        }

        // Validate total amount
        if ($checkoutSession->total_amount != $request->total_amount) {
            return response()->json(['message' => 'Total amount mismatch.'], 400);
        }

        // Handle Address
        $delivery_address = $this->_handleAddress($request, $user);
        if (!$delivery_address) {
            return response()->json(['message' => 'Invalid address.'], 400);
        }

        try {
            // Create Order
            $order = $this->_createOrder($user, $checkoutSession, $delivery_address, $request);
           
            $cart = IstantBuy::where('user_id', $user->id)->get();
            
            $extra_fee = $checkoutSession->platform_fee + $checkoutSession->shipping_fee - $checkoutSession->coupon_discount;
            // Process Order Items
            $admin_fee = $this->_processInstantOrderItems($order, $user, $request, $extra_fee);
            
            // Store Order Item Breakdown
            $this->_storeOrderItemBreakdown($order);

            // Store Order Amount Breakdown
            $this->_storeOrderAmountBreakdown($order, $checkoutSession, $admin_fee);
            
            IstantBuy::where('user_id', $user->id)->delete();

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

    private function _handleAddress(Request $request, $user)
    {
        // Custom validation rules
        $rules = [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required|email",
            "street_name" => "required",
            "city" => "required",
            "phone" => "required|digits:10",
            "total_amount" => "required|numeric",
            "pin" => "required|digits:6",
            "state" => "required",
        ];

        // Validate the request if the address is new
        if ($request->address_type == "new") {
            $request->validate($rules);

            // Create a new address
            $address = new UserAddress();
            $address->user_id = $user->id;
            $address->firstname = $request->firstname;
            $address->lastname = $request->lastname;
            $address->email = $request->email;
            $address->street_name = $request->street_name;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = $request->country;
            $address->phone = $request->phone;
            $address->pin = $request->pin;
            $address->apartment = $request->apartment;
            $address->save();

            return $address;
        } elseif ($request->address_type == "old") {
            // Use the existing address if it is old
            return UserAddress::find($request->address_id);
        }

        return null; // In case address type is neither 'new' nor 'old'
    }

    private function _createOrder($user, $checkoutSession, $delivery_address, $request)
    {
        $unique_order_id = time() . "-" . rand(100, 999) . "-" . strtoupper(Str::random(6));

        $order = new Order();
        $order->user_id = $user->id;
        $order->address_id = $delivery_address->id;
        $order->unique_id = $unique_order_id;
        $order->price = $checkoutSession->total_amount;
        $order->additional_info = $request->additional_info;
        $order->payment_method = $request->payment_type;
        $order->status = "pending";
        $order->save();

        return $order;
    }

    private function _processOrderItems($order, $user, $extra_fee)
    {
        $cart = Cart::where('user_id', $user->id)->get();
        $admin_commision = 50; // Hardcoded value

        foreach ($cart as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item->product_id;
            $order_item->sku = $item->sku;
            $order_item->quantity = $item->quantity;
            $order_item->unit_price = $item->unit_price;
            $order_item->status = 0;
            
             // Default GST amount
            $gst_amount = 0;

            // Try to calculate GST if applicable
            $product = \App\Models\Product::find($item->product_id);

            if ($product && $product->hsn_id) {
                $hsn = \App\Models\HsnCode::find($product->hsn_id);

                if ($hsn && $hsn->gst) {
                    $item_total = $item->unit_price * $item->quantity;
                    $gst_amount = round(($item_total * $hsn->gst) / 100, 2);
                }
            }
            
            // Set GST (0 if not applicable)
             $order_item->gst = $gst_amount;
            $order_item->save();

            // Update stock levels
            $this->_updateStock($item);

            // Increase admin fee dynamically (replace hardcoded value)
            $extra_fee += ($admin_commision * $item->quantity); 
        }

        return $extra_fee;
    }

    private function _updateStock($cartItem)
    {
        $productSize = ProductSize::where('product_id', $cartItem->product_id)
                                ->where('size', $cartItem->sku)
                                ->first();

        if ($productSize) {
            $productSize->quantity -= $cartItem->quantity;
            $productSize->save();
        }

        // Check if all sizes for the product are out of stock
        $sizesLeft = ProductSize::where('product_id', $cartItem->product_id)
                                ->where('quantity', '>', 0)
                                ->count();

        if ($sizesLeft === 0) {
            $product = Product::find($cartItem->product_id);
            $product->in_stock = 0;
            $product->save();
        }
    }

    private function _storeOrderAmountBreakdown($order, $checkoutSession, $admin_fee)
    {
        $orderAmountBreakdown = new OrderAmountBreakdown();
        $orderAmountBreakdown->order_id = $order->id;
        $orderAmountBreakdown->platform_fee = $checkoutSession->platform_fee;
        $orderAmountBreakdown->shipping_charge = $checkoutSession->shipping_fee;
        $orderAmountBreakdown->coupon_discount = $checkoutSession->coupon_discount;
        $orderAmountBreakdown->total_paid_by_customer = $checkoutSession->total_amount;
        $orderAmountBreakdown->admin_fee = $admin_fee;
        $orderAmountBreakdown->amount_to_seller = $checkoutSession->total_amount - $admin_fee;
        $orderAmountBreakdown->save();
    }

    private function _storeOrderItemBreakdown($order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $checkoutSession = CheckoutSession::where('user_id', $order->user_id)->first();

        $admin_commision = 50; // Hardcoded value

        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);

            if (!$product) {
                continue; // Skip if product doesn't exist (shouldn't happen)
            }

            $seller_id = $product->user_id;

            // Amount seller receives after deduction
            $amount_to_seller = ($item->quantity * ($item->unit_price - $admin_commision));
            
            // Store breakdown data
            OrderItemBreakdown::create([
                'order_item_id' => $item->id,
                'seller_id' => $seller_id,
                'platform_fee' => $checkoutSession->platform_fee,
                'shipping_charge' => $checkoutSession->shipping_fee,
                'coupon_discount' => $checkoutSession->coupon_discount,
                'item_total' => $item->unit_price * $item->quantity,
                'amount_to_seller' => $amount_to_seller,
            ]);
        }
    }


    private function _processInstantOrderItems($order, $user, $request, $extra_fee)
    {
        $cart = IstantBuy::where('user_id', $user->id)->get();
        $admin_commision = 50; // Hardcoded value

        foreach ($cart as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item->product_id;
            $order_item->sku = $item->sku;
            $order_item->quantity = $item->quantity;
            $order_item->unit_price = $request->total_price;
            
            
          // ðŸ§® Default GST amount
        $gst_amount = 0;

        // âœ… GST calculation if applicable
        $product = \App\Models\Product::find($item->product_id);
        if ($product && $product->hsn_id) {
            $hsn = \App\Models\HsnCode::find($product->hsn_id);
            if ($hsn && $hsn->gst) {
                $item_total = $order_item->unit_price * $order_item->quantity;
                $gst_amount = round(($item_total * $hsn->gst) / 100, 2);
                
            }
        }

        $order_item->gst = $gst_amount; // Store GST amount
        $order_item->save();

            // Update stock
            $this->_updateStock($item);

        // Increase admin fee dynamically (replace hardcoded value)
        $extra_fee += ($admin_commision * $item->quantity);
        }
    }

}
