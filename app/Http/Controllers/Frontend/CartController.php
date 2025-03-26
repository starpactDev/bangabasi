<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\PlatformFee;
use App\Models\ProductSize;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\CheckoutSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

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
        Cart::where('user_id', $user->id)->delete();
        return redirect()->back();
    }

    public function checkout()
    {
        $user = Auth::user();

        // Fetch products in cart
        $products = Product::join('carts', 'products.id', '=', 'carts.product_id')
                            ->where('carts.user_id', $user->id)
                            ->orderBy('carts.created_at', 'desc')
                            ->select('products.*', "carts.*", "carts.id as cart_id")
                            ->with('productImages') // Eager load product images
                            ->get();

        // Calculate all checkout details
        $checkoutDetails = $this->_calculateCheckoutDetails($user, $products);

        // Store session data
        $checkoutSession = $this->_storeCheckoutSession($user, $products, $checkoutDetails);

        // Fetch user addresses
        $user_addresses = UserAddress::where('user_id', $user->id)->get();
        $address_type = $user_addresses->isEmpty() ? "new" : "old";

        return view('checkout', array_merge(compact('products', 'user_addresses', 'address_type'), $checkoutDetails, ['checkoutSession' => $checkoutSession] ));
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

        $platform_fee = 0;

        $platform_fee = round(PlatformFee::latest()->first()->amount);

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

        // Checkout details
        $checkoutDetails = [
            'original_price' => $original_price,
            'total_price' => $total_price,
            'coupon_discount' => $coupon_discount,
            'platform_fee' => $platform_fee,
            'shipping_fee' => $shipping_fee,
            'total_amount' => $total_amount,
        ];

        // Call the private function to store the checkout session
        $this->_storeCheckoutSession($user, $products, $checkoutDetails);

        // User addresses
        $user_addresses = UserAddress::where('user_id', $user->id)->get();
        $address_type = $user_addresses->isEmpty() ? "new" : "old";

        // Pass data to the view
        return view('instant_checkout', compact('products', 'original_price', 'total_price', 'coupon_discount', 'platform_fee', 'shipping_fee', 'total_amount', 'user_addresses', 'address_type'));
    }

    public function couponCheck(Request $request)
    {
        // Validate incoming request
        $request->validate([
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

    public function removeCoupon()
    {
        session()->forget('coupon_applied');
        return redirect()->back();
    }

    private function _storeCheckoutSession($user, $products, $checkoutDetails)
    {

        if (empty($products)) {
            return null; // No items in cart, no need to store session
        }
        
        // Check if $products is an array or a Collection
        if (is_array($products)) {
            // Use array_map() if $products is a regular array
            $cartData = array_map(function($product) {

                return [
                    'id' => $product['product_id'],           // Assuming array keys for product attributes
                    'sku' => $product['sku'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                ];
            }, $products);
        } else {
            // If $products is a Collection, use map()
            $cartData = $products->map(function($product) {
                return [
                    'id' => $product->id,           
                    'sku' => $product->sku,         
                    'quantity' => $product->quantity, 
                    'unit_price' => $product->unit_price, 
                ];
            });
        }

        // Store session data
        $checkoutSession = CheckoutSession::updateOrCreate(
            ['user_id' => $user->id],
            [
                'cart_data' => json_encode($cartData), // Storing cart items
                'original_price' => $checkoutDetails['original_price'],
                'total_price' => $checkoutDetails['total_price'],
                'coupon_discount' => $checkoutDetails['coupon_discount'],
                'platform_fee' => $checkoutDetails['platform_fee'],
                'shipping_fee' => $checkoutDetails['shipping_fee'],
                'total_amount' => $checkoutDetails['total_amount'],
            ]
        );

        return $checkoutSession;
    }

    


    private function _calculateCheckoutDetails($user, $products)
    {
        // Ensure $products is a collection (even for instantCheckout)
        $products = collect($products);

        // Calculate total original price
        $original_price = $products->sum(fn($item) => $item['original_price'] * $item['quantity']);
        $original_price = round($original_price, 2);

        // Calculate total price
        $total_price = $products->sum(fn($item) => $item['unit_price'] * $item['quantity']);
        $total_price = round($total_price, 2);

        // Apply coupon discount
        $coupon_discount = 0;
        $couponId = session('coupon_applied');

        if ($couponId) {
            $coupon = Coupon::find($couponId);
            if ($coupon) {
                $coupon_discount = $coupon->discount_percentage
                    ? round(($total_price * $coupon->discount_percentage) / 100, 2)
                    : $coupon->discount_amount;
            }
        }

        // Platform fee
        $platform_fee = round(PlatformFee::latest()->first()->amount ?? 0);

        // Shipping fee
        $shipping_fee = match(true) {
            $total_price > 50 && $total_price <= 299 => 10,
            $total_price > 300 && $total_price <= 599 => 15,
            $total_price > 600 && $total_price <= 899 => 20,
            $total_price > 900 => 25,
            default => 5,
        };

        // Final total amount
        $total_amount = $total_price - $coupon_discount + $platform_fee + $shipping_fee;

        return compact('original_price', 'total_price', 'coupon_discount', 'platform_fee', 'shipping_fee', 'total_amount');
    }



}
