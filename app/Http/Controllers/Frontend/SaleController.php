<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ViewSaleAboveDiscount;

class SaleController extends Controller
{
    public function index(Request $request)
{
    // Get the sale discount configuration
    $saleDiscount = ViewSaleAboveDiscount::first();

    // Base query for sale products
    $query = Product::where('discount_percentage', '>=', $saleDiscount->discount)
                    ->where('is_active', 1);

    // Apply stock filter based on the `stock` parameter
    if ($request->has('stock')) {
        
        if ($request->stock == '1') {
            $query->where('in_stock', 1); // Only include in-stock products
        } elseif ($request->stock == '0') {
            $query->where('in_stock', 0); // Only include out-of-stock products
            
        }
    }

    // Apply sub-category filter if provided
    if ($request->has('sub_category') && $request->sub_category) {
        $query->where('sub_category', $request->sub_category);
    }

    // Apply price range filters if provided
    if ($request->has('min') && $request->min !== null) {
        $query->where('offer_price', '>=', $request->min);
    }

    if ($request->has('max') && $request->max !== null) {
        $query->where('offer_price', '<=', $request->max);
    }

    // Apply sorting logic
    if ($request->has('sorting') && $request->sorting !== 'default' && $request->sorting !== '') {
        switch ($request->sorting) {
            case 'rating':
                $query->with(['reviews' => function ($query) {
                    $query->selectRaw('product_id, AVG(rating) as avg_rating')->groupBy('product_id');
                }])->orderByDesc('avg_rating');
                break;

            case 'latest':
                $query->orderByDesc('created_at');
                break;

            case 'high-to-low':
                $query->orderByDesc('offer_price');
                break;

            case 'low-to-high':
                $query->orderBy('offer_price');
                break;
        }
    }

    // Apply pagination if a limit is specified
    if ($request->has('limit') && $request->limit) {
        $saleProducts = $query->with(['productImages', 'reviews', 'subCategoryDetails', 'categoryDetails'])->paginate($request->limit);
    } else {
        $saleProducts = $query->with(['productImages', 'reviews', 'subCategoryDetails', 'categoryDetails'])->get();
    }

    // Fetch active subcategories with products on sale
    $filterSubCategories = SubCategory::whereIn('id', function ($query) use ($saleDiscount) {
        $query->select('sub_category')
            ->from('products')
            ->distinct()
            ->where('discount_percentage', '>=', $saleDiscount->discount)
            ->where('is_active', 1);
    })->get();

    // Return the view with filtered products and subcategories
    return view('sale', compact('saleProducts', 'filterSubCategories'));
}


}