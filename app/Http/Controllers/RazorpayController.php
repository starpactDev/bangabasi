<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Product;
use App\Models\IstantBuy;
use App\Models\OrderItem;
use App\Models\ProductSize;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class RazorpayController extends Controller
{
    public function createRazorpayOrder(Request $request)
    {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));
        $amount = $request->total_price * 100; // Amount in paise (Razorpay works in paise)
        $currency = 'INR'; // Currency

        try {
            $order = $api->order->create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_capture' => 1 // Automatic capture
            ]);

            return response()->json([
                'status' => 'success',
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function completePayment(Request $request)
    {
        $payment_id = $request->payment_id;
        $order_id = $request->order_id;
        $delivery_address = null;

        if ($request->address_type == "new") {

            $address = new UserAddress();
            $address->user_id = $request->user_id;
            $address->firstname = $request->firstname;
            $address->lastname = $request->lastname;
            $address->email = $request->email;
            $address->street_name = $request->street_name;
            $address->city = $request->city;
            $address->state = $request->state ? $request->state : ' ';
            $address->country = $request->country;
            $address->phone = $request->phone;
            $address->pin = $request->pin;
            $address->save();
            $delivery_address = $address;
        }

        if ($request->address_type == "old") {
            $delivery_address = UserAddress::find($request->address_id);
        }

        $unique_order_id = time() . "-" . rand(100, 999) . "-" . strtoupper(Str::random(6));
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->address_id = $delivery_address->id;
        $order->unique_id = $unique_order_id;
        $order->price = $request->total_price;
        $order->additional_info = $request->additional_info;
        $order->payment_method = $request->payment_type;
        $order->status = "pending";
        $order->save();



        if ($order && $order->payment_method === 'prePaid') {
            // Verify the payment using Razorpay API
            $api = new Api(config('razorpay.key'), config('razorpay.secret'));
            $payment = $api->payment->fetch($payment_id);

            if ($payment->status == 'captured' || $payment->status == 'authorized') {
                // Payment successful

                $order->online_payment_id = $request->payment_id; // Update status to confirmed
                $order->save();

                $cart = IstantBuy::where('user_id', $request->user_id)->get();

                foreach ($cart as $item) {

                    $order_item = new OrderItem();
                    $order_item->order_id = $order->id;
                    $order_item->product_id = $item->product_id;
                    $order_item->sku = $item->sku;
                    $order_item->quantity = $item->quantity;
                    $order_item->unit_price = $order->price;
                    $order_item->save();

                    $manageStock = ProductSize::where('product_id', $item->product_id)->where('size', $item->sku)->first();
                    $manageStock->quantity = $manageStock->quantity - $item->quantity;
                    $manageStock->save();

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

                IstantBuy::where('user_id', $request->user_id)->delete();

                // Process cart items and update stock as in postPaid

                // (Same as your postPaid logic)

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment successful, order placed!'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment verification failed.'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid order or payment.'
        ]);
    }
    public function instantcompletePayment(Request $request)
    {

        $payment_id = $request->payment_id;
        $order_id = $request->order_id;
        $delivery_address = null;

        if ($request->address_type == "new") {


            $address = new UserAddress();
            $address->user_id = $request->user_id;
            $address->firstname = $request->firstname;
            $address->lastname = $request->lastname;
            $address->email = $request->email;
            $address->street_name = $request->street_name;
            $address->city = $request->city;
            $address->state = $request->state ? $request->state : ' ';
            $address->country = $request->country;
            $address->phone = $request->phone;
            $address->pin = $request->pin;
            $address->save();
            $delivery_address = $address;
        }

        if ($request->address_type == "old") {
            $delivery_address = UserAddress::find($request->address_id);
        }

        $unique_order_id = time() . "-" . rand(100, 999) . "-" . strtoupper(Str::random(6));
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->address_id = $delivery_address->id;
        $order->unique_id = $unique_order_id;
        $order->price = $request->total_price;
        $order->additional_info = $request->additional_info;
        $order->payment_method = $request->payment_type;
        $order->status = "pending";
        $order->save();



        if ($order && $order->payment_method === 'prePaid') {
            // Verify the payment using Razorpay API
            $api = new Api(config('razorpay.key'), config('razorpay.secret'));
            $payment = $api->payment->fetch($payment_id);

            if ($payment->status == 'captured' || $payment->status == 'authorized') {
                // Payment successful

                $order->online_payment_id = $request->payment_id; // Update status to confirmed
                $order->save();

                $cart = Cart::where('user_id', $request->user_id)->get();

                foreach ($cart as $item) {

                    $order_item = new OrderItem();
                    $order_item->order_id = $order->id;
                    $order_item->product_id = $item->product_id;
                    $order_item->sku = $item->sku;
                    $order_item->quantity = $item->quantity;
                    $order_item->unit_price = $order->price;
                    $order_item->save();

                    $manageStock = ProductSize::where('product_id', $item->product_id)->where('size', $item->sku)->first();
                    $manageStock->quantity = $manageStock->quantity - $item->quantity;
                    $manageStock->save();

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

                Cart::where('user_id', $request->user_id)->delete();

                // Process cart items and update stock as in postPaid

                // (Same as your postPaid logic)

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment successful, order placed!'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment verification failed.'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid order or payment.'
        ]);
    }
}
