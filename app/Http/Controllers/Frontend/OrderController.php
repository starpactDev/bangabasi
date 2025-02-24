<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Size;
use App\Models\Order;
use App\Models\Product;
use App\Models\IstantBuy;
use App\Models\OrderItem;
use App\Models\ProductSize;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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

    public function placeOrder(Request $request)
    {

        $user = Auth::user();
        $delivery_address = null;

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

        if ($request->address_type == "new") {
            $request->validate($rules);
            $address = new UserAddress();
            $address->user_id = $user->id;
            $address->firstname = $request->firstname;
            $address->lastname = $request->lastname;
            $address->email = $request->email;
            $address->street_name = $request->street_name;
            $address->city = $request->city;
            $address->state = "";
            $address->country = $request->country;
            $address->phone = $request->phone;
            $address->pin = $request->pin;
            $address->state = $request->state;
            $address->apartment = $request->apartment;
            $address->save();
            $delivery_address = $address;
        } elseif ($request->address_type == "old") {
            $delivery_address = UserAddress::find($request->address_id);
        }

        try {
            $unique_order_id = time() . "-" . rand(100, 999) . "-" . strtoupper(Str::random(6));
            $order = new Order();
            $order->user_id = $user->id;
            $order->address_id = $delivery_address->id;
            $order->unique_id = $unique_order_id;
            $order->price = $request->total_amount;
            $order->additional_info = $request->additional_info;
            $order->payment_method = $request->payment_type;
            $order->status = "pending";
            $order->save();

           
            $cart = Cart::where('user_id', $user->id)->get();

            foreach ($cart as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product_id;
                $order_item->sku = $item->sku;
                $order_item->quantity = $item->quantity;
                $order_item->unit_price = $item->unit_price;
                $order_item->status = (int) 0;
                $order_item->save();

                // Update the quantity in ProductSize model
                $productSize = ProductSize::where('product_id', $item->product_id)
                    ->where('size', $item->sku) // Assuming size is a field in the cart and ProductSize model
                    ->first();

                if ($productSize) {
                    $productSize->quantity -= $item->quantity;
                    $productSize->save();
                }
                // Check if all sizes for the product have a quantity of 0
                $sizesLeft = ProductSize::where('product_id', $item->product_id)
                    ->where('quantity', '>', 0)
                    ->count();

                if ($sizesLeft === 0) {
                    // Update the in_stock field to 0 in the Product model
                    $product = Product::find($item->product_id);
                    $product->in_stock = 0;
                    $product->save();
                }
            }

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

        // Custom validation rules
        $rules = [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required|email",
            "street_name" => "required",
            "city" => "required",
            "phone" => "required|digits:10",
            "total_amount" => "required|numeric",
            "total_price" => "required|numeric",
            "pin" => "required|digits:6",
            "state" => "required",
        ];

        if ($request->address_type == "new") {
            $request->validate($rules);
            $address = new UserAddress();
            $address->user_id = $user->id;
            $address->firstname = $request->firstname;
            $address->lastname = $request->lastname;
            $address->email = $request->email;
            $address->street_name = $request->street_name;
            $address->city = $request->city;
            $address->state = $request->state ? $request->state : ' ';
            $address->country = $request->country;
            $address->phone = $request->phone;
            $address->pin = $request->pin;
            $address->state = $request->state;
            $address->apartment = $request->apartment;
            $address->save();
            $delivery_address = $address;
        } elseif ($request->address_type == "old") {
            $delivery_address = UserAddress::find($request->address_id);
        }

        try {
            $unique_order_id = time() . "-" . rand(100, 999) . "-" . strtoupper(Str::random(6));
            $order = new Order();
            $order->user_id = $user->id;
            $order->address_id = $delivery_address->id;
            $order->unique_id = $unique_order_id;
            $order->price = $request->total_amount;
            $order->additional_info = $request->additional_info;
            $order->payment_method = $request->payment_type;
            $order->status = "pending";
            $order->save();

           
            $cart = IstantBuy::where('user_id', $user->id)->get();
            
            foreach ($cart as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product_id;
                $order_item->sku = $item->sku;
                $order_item->quantity = $item->quantity;
                $order_item->unit_price = $request->total_price;
                $order_item->save();

                // Update the quantity in ProductSize model
                $productSize = ProductSize::where('product_id', $item->product_id)
                    ->where('size', $item->sku) // Assuming size is a field in the cart and ProductSize model
                    ->first();

                if ($productSize) {
                    $productSize->quantity -= $item->quantity;
                    $productSize->save();
                    
                }
                // Check if all sizes for the product have a quantity of 0
                $sizesLeft = ProductSize::where('product_id', $item->product_id)
                    ->where('quantity', '>', 0)
                    ->count();

                if ($sizesLeft === 0) {
                    // Update the in_stock field to 0 in the Product model
                    $product = Product::find($item->product_id);
                    $product->in_stock = 0;
                    $product->save();
                }
            }

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
}
