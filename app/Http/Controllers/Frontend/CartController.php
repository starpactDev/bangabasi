<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $products = Product::join('carts', 'products.id', '=', 'carts.product_id')
                             ->where('carts.user_id', $user->id)
                             ->orderBy('carts.created_at', 'desc')
                             ->select('products.*', "carts.*", "carts.id as cart_id")
                             ->with('productImages') // Eager load product images
                             ->get();

                            
        $total_price = 0;
        if($products->isEmpty()){
            return view('cart', compact('products', 'total_price'));
        }

        foreach ($products as $item) {
            $total_price += $item->unit_price * $item->quantity;
        }
        $total_price = round($total_price, 2);

        // Collect subcategory IDs from cart products
        $subCategoryIds = $products->pluck('sub_category')->unique();

        // Fetch up to 15 interested products from these subcategories
        $interestedProducts = Product::whereIn('sub_category', $subCategoryIds)
                                                ->whereNotIn('id', $products->pluck('product_id')) // Exclude products already in the cart
                                                ->with([
                                                    'productImages',
                                                    'reviews',
                                                    'subCategoryDetails',
                                                    'categoryDetails',
                                                ]) // Eager load relationships
                                                ->take(15)
                                                ->get();
                                                

        return view('cart', compact('products', 'total_price', 'interestedProducts'));
    }

    public function update(Request $request)
    {
        $id = $request->cart_id;
        $cart = Cart::find($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->get();

        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item->unit_price * $item->quantity;
        }

        $total_price = round($total_price, 2);

        return response()->json(['message' => 'Cart updated successfully', 'total_price' => $total_price]);
    }

    public function delete($id)
    {
        $cart = Cart::find($id);
      
        $cart->delete();
        return redirect()->back();
    }

    public function emptyCart()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->delete();
        return redirect()->back();
    }

    public function checkout()
    {
        $user = Auth::user();

        $products = Product::join('carts', 'products.id', '=', 'carts.product_id')
                             ->where('carts.user_id', $user->id)
                             ->orderBy('carts.created_at', 'desc')
                             ->select('products.*', "carts.*", "carts.id as cart_id")
                             ->with('productImages') // Eager load product images
                             ->get();

        $original_price = 0;
        foreach ($products as $item) {
            $original_price += $item->original_price * $item->quantity;
        }
        $original_price = round($original_price, 2);

        $total_price = 0;
        foreach ($products as $item) {
            $total_price += $item->unit_price * $item->quantity;
            $item->subtotal = $item->unit_price * $item->quantity;
        }
        $total_price = round($total_price, 2);

        $coupon_discount = 0;

        // Retrieve the coupon ID from the session
        $couponId = session('coupon_applied');

        if ($couponId) {
            $coupon = Coupon::find($couponId);
            if ($coupon) {
                if ($coupon->discount_percentage) {
                    $coupon_discount = round(($total_price * $coupon->discount_percentage) / 100, 2);
                } else {
                    $coupon_discount = $coupon->discount_amount;
                }
            }
        }


        

        $platform_fee = 20;

        $shipping_fee = 0;

        if ($total_price > 50 && $total_price <= 299) {
            $shipping_fee = 10;
        } else if ($total_price > 300 && $total_price <= 599) {
            $shipping_fee = 15;
        } else if ($total_price > 600 && $total_price <= 899) {
            $shipping_fee = 20;
        } else if ($total_price > 900) {
            $shipping_fee = 25;
        } else {
            $shipping_fee = 5;
        }

        $total_amount = $total_price - $coupon_discount + $platform_fee + $shipping_fee;

        $user_addresses = UserAddress::where('user_id', $user->id)->get();


        $address_type = $user_addresses->isEmpty() ? "new" : "old";
        dd($products);
        return view('checkout', compact('products', 'total_price', 'original_price', 'coupon_discount', 'platform_fee', 'shipping_fee', 'total_amount', 'user_addresses', 'address_type'));
    }

    public function checkStock(Request $request)
    {
        $productId = $request->input('product_id');

        $sku = $request->input('sku');  // size (sku) of the product

        // Fetch the available quantity from product sizes
        $productSize = ProductSize::where('product_id', $productId)
                                ->where('size', $sku)
                                ->first();

        if ($productSize) {
            return response()->json(['available_quantity' => $productSize->quantity]);
        }

        return response()->json(['error' => 'Product size not found'], 404);
    }

    public function checkAvailability(Request $request)
    {
        $productData = $request->input('products'); // Expecting an array of product data

        $availability = [];

        foreach ($productData as $product) {
            $productSize = ProductSize::where('product_id', $product['id'])
                                    ->where('size', $product['size'])
                                    ->first();

            if ($productSize && $productSize->quantity >= $product['quantity']) {
                $availability[] = ['product_id' => $product['id'], 'size' => $product['size'], 'available' => true];
            } else {
                $availability[] = ['product_id' => $product['id'], 'size' => $product['size'], 'available' => false];
            }
        }

        return response()->json(['availability' => $availability]);
    }

    public function instantCheckout(Request $request)
    {
        $user = Auth::user();

        // Input data
        $product_id = $request->input('product_id');
        $product_size = $request->input('product_size'); // Size
        $product_quantity = $request->input('product_quantity'); // Quantity

        if (!$product_id) {
            return redirect()->back()->withErrors('Product ID is required for instant checkout.');
        }

        // Fetch the product
        $product = Product::where('id', $product_id)
                        ->with('productImages') // Eager load images
                        ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Create a products array consistent with the Blade template
        $products = [
            [
                'product_id' => $product->id,
                'name' => $product->name,
                'unit_price' => $product->offer_price,
                'sku' => $product_size, // Use size in place of SKU
                'quantity' => $product_quantity,
                'subtotal' => $product->offer_price * $product_quantity,
                'updated_at' => now(),
            ]
        ];

        $original_price = round($product->original_price * $product_quantity);

        // Total price
        $total_price = round($products[0]['subtotal'], 2);

        $coupon_discount = 0;

        // Retrieve the coupon ID from the session
        $couponId = session('coupon_applied');

        if ($couponId) {
            $coupon = Coupon::find($couponId);
            if ($coupon) {
                if ($coupon->discount_percentage) {
                    $coupon_discount = round(($total_price * $coupon->discount_percentage) / 100, 2);
                } else {
                    $coupon_discount = $coupon->discount_amount;
                }
            }
        }

        $platform_fee = 20;

        $shipping_fee = 0;

        if ($total_price > 50 && $total_price <= 299) {
            $shipping_fee = 10;
        } else if ($total_price > 300 && $total_price <= 599) {
            $shipping_fee = 15;
        } else if ($total_price > 600 && $total_price <= 899) {
            $shipping_fee = 20;
        } else if ($total_price > 900) {
            $shipping_fee = 25;
        } else {
            $shipping_fee = 5;
        }

        $total_amount = $total_price - $coupon_discount + $platform_fee + $shipping_fee;

        // User addresses
        $user_addresses = UserAddress::where('user_id', $user->id)->get();
        $address_type = $user_addresses->isEmpty() ? "new" : "old";

        // Pass data to the view
        return view('instant_checkout', compact('products', 'original_price', 'total_price', 'coupon_discount', 'platform_fee', 'shipping_fee', 'total_amount', 'user_addresses', 'address_type'));
    }

    public function couponCheck(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'coupon_code' => 'required|string|exists:coupons,coupon_code',
        ]);

        $couponCode = $request->input('coupon_code');

        // Find the coupon from the database
        $coupon = Coupon::where('coupon_code', $couponCode)->first();

        // Check if the coupon exists
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon not found.'], 400);
        }

        // Check if the coupon has expired
        $currentDate = Carbon::now();
        if (Carbon::parse($coupon->expiration_date)->isBefore($currentDate)) {
            return response()->json(['success' => false, 'message' => 'Coupon has expired.'], 400);
        }

        // Store the coupon ID in the session for later use
        session(['coupon_applied' => $coupon->id]);

        // Coupon is valid
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount_amount' => $coupon->discount_amount,
            'discount_percentage' => $coupon->discount_percentage
        ]);
    }


}
