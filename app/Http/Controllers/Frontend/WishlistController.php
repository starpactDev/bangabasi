<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(Request $request)
    {


        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User is not authenticated.'], 401);
        }

        try {
            // Create or update the wishlist entry
            Wishlist::updateOrCreate([
                'product_id' => $validatedData['product_id'],
                'user_id' => $user->id,
            ]);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error adding to wishlist:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Unable to add to wishlist. Please try again.']);
        }
    }

    public function addAndRedirect(Request $request)
    {
        // Validate the product_id
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            // If user is not authenticated, redirect to login page
            return redirect()->route('login')->with('error', 'You need to login to add items to your wishlist.');
        }

        try {
            // Create or update the wishlist entry
            Wishlist::updateOrCreate([
                'product_id' => $validatedData['product_id'],
                'user_id' => $user->id,
            ]);

            // Redirect to wishlist page with a success message
            return redirect()->route('wishlist')->with('success', 'Product added to wishlist!');
        } catch (Exception $e) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'Unable to add to wishlist. Please try again.');
        }
    }

    public function index()
    {
        $user = Auth::user();

        $wishlists = Wishlist::join("products", "products.id", "=", "wishlists.product_id")
            ->select('wishlists.id as wishlist_id', "products.*")
            ->where('wishlists.user_id', $user->id)
            ->orderBy('wishlists.id', 'desc')
            ->paginate(9);

            foreach ($wishlists as $wishlist) {

                // Check if all sizes for the product have a quantity of 0
                $sizesLeft = ProductSize::where('product_id', $wishlist->id)
                    ->where('quantity', '>', 0)
                    ->count();

                    if ($sizesLeft === 0) {
                        $product = Product::find($wishlist->id);
                        $product->in_stock = 0;
                        $product->save();
                    } else {
                        // If there is stock for at least one size, set in_stock to 1
                        $product = Product::find($wishlist->id);
                        if ($product->in_stock == 0) { // Only update if it's currently out of stock
                            $product->in_stock = 1;
                            $product->save();
                        }
                    }
            }

        // $products = null;
        // foreach ($wishlists as $wishlist) {
        //     $products [] = $wishlist->productDetails;
        // }

        // dd($wishlists->links());

        // dd($wishlists);

        return view('wishlist', compact("wishlists"));
    }

    public function delete(Request $request)
    {
        $wishlist = Wishlist::find($request->wishlist_id);
        $wishlist->delete();
        return redirect()->back();
    }

    public function addToCart(Request $request)
    {

        if ($request->wishlist_id) {

            $wishlist = Wishlist::find($request->wishlist_id);
            $user_id = $wishlist->user_id;
            $size = $request->size;
            $product_id = $wishlist->product_id;
        }

        if ($request->product_id) {
            $product = Product::find($request->product_id);
            $user_id = Auth::user()->id;
            $size= $request->size;
            $product_id = $product->id;
        }

        Cart::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $request->quantity,
            'sku' => $size,
            'unit_price' => $request->unit_price

        ]);
        if ($request->wishlist_id) {
        $wishlist->delete();
        }
        return redirect()->back();
    }
}
