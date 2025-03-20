<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use App\Models\Cart;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder($user, $request, $isInstant = false)
    {
        $delivery_address = $this->getDeliveryAddress($user, $request);

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

        // Fetch cart data (for standard or instant orders)
        $cart = $isInstant ? InstantBuy::where('user_id', $user->id)->get() : Cart::where('user_id', $user->id)->get();

        foreach ($cart as $item) {
            $order_item = $this->createOrderItem($order->id, $item, $request->total_price);
            $this->updateProductSize($item);
            $this->checkProductStock($item);
        }

        // Clear the cart after placing the order
        $this->clearCart($user, $isInstant);

        return $order;
    }

    private function getDeliveryAddress($user, $request)
    {
        if ($request->address_type == "new") {
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
        }

        return UserAddress::find($request->address_id);
    }

    private function createOrderItem($orderId, $item, $unitPrice)
    {
        $order_item = new OrderItem();
        $order_item->order_id = $orderId;
        $order_item->product_id = $item->product_id;
        $order_item->sku = $item->sku;
        $order_item->quantity = $item->quantity;
        $order_item->unit_price = $unitPrice;
        $order_item->save();

        return $order_item;
    }

    private function updateProductSize($item)
    {
        $productSize = ProductSize::where('product_id', $item->product_id)
            ->where('size', $item->sku) // Assuming size is a field in the cart and ProductSize model
            ->first();

        if ($productSize) {
            $productSize->quantity -= $item->quantity;
            $productSize->save();
        }
    }

    private function checkProductStock($item)
    {
        $sizesLeft = ProductSize::where('product_id', $item->product_id)
            ->where('quantity', '>', 0)
            ->count();

        if ($sizesLeft === 0) {
            $product = Product::find($item->product_id);
            $product->in_stock = 0;
            $product->save();
        }
    }

    private function clearCart($user, $isInstant)
    {
        if ($isInstant) {
            InstantBuy::where('user_id', $user->id)->delete();
        } else {
            Cart::where('user_id', $user->id)->delete();
        }
    }
}
