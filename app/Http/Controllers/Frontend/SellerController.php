<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::where('is_active', 1)->with('products')->get();
        return view('shops', compact('sellers'));
    }

    public function show($sellerId)
    {
        $seller = Seller::with('user')->where('id', $sellerId)->firstOrFail();

        // Fetch seller's products
        $products = Product::where('user_id', $seller->user_id)
            ->with(['categoryDetails', 'productImages', 'reviews'])
            ->get();

        // Calculate total products
        $totalProducts = $products->count();

        // Calculate average rating
        $averageRating = Product::where('products.user_id', $seller->user_id)
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('reviews.status', 'active')
            ->avg('reviews.rating');

        // Count total reviews
        $totalReviews = Product::where('products.user_id', $seller->user_id)
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('reviews.status', 'active')
            ->count();

        return view('shop', compact('seller', 'products', 'totalProducts', 'averageRating', 'totalReviews'));
    }

}
