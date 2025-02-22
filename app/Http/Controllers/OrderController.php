<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function placeOrder(Request $request)
    {

        $user = Auth::user();
        $delivery_address = null;

        try {
            
            if ($request->address_type == "new") {
                $request->validate([
                    "firstname" => "required",
                    "lastname" => "required",
                    "email" => "required|email",
                    "street_name" => "required",
                    "city" => "required",
                    "phone" => "required|digits:10",
                    "total_price" => "required|numeric",
                    "pin" => "required|digits:6",
    
                ]);
    
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
                $address->save();
                $delivery_address = $address;          
                
            }
    
            if ($request->address_type == "old") {
                $delivery_address = UserAddress::find($request->address_id);
            }
    
            $unique_order_id = time()."-".rand(100,999)."-".strtoupper(Str::random(6));
            $order = new Order();
            $order->user_id = $user->id;
            $order->address_id = $delivery_address->id;
            $order->unique_id = $unique_order_id;
            $order->price = $request->total_price;
            $order->additional_info = $request->additional_info;
            $order->payment_method = $request->payment_type;
            $order->status = "pending";
            $order->save();
    
            $cart = Cart::where('user_id', $user->id)->get();
    
            foreach ($cart as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product_id;
                $order_item->quantity = $item->quantity;
                $order_item->unit_price = $item->unit_price;
                $order_item->save();
            }
    
            Cart::where('user_id', $user->id)->delete();
           
    
    
            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id, "status" => "success"], 200);

        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], 500);
        }

        
    }
}
