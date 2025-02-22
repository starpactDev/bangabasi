<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterProductController extends Controller
{
    public function index(Request $request)
    {       
        $data = $request->all();

// Decode the sub_category_ids JSON string
$subCategories = json_decode($data['sub_category_ids'], true);

// Extract the IDs
$ids = array_column($subCategories, 'id');

// Debug the extracted IDs

        $category = $request->get('category', null);
        $sub_category = $request->get('sub_category', null);
        $min = $request->get('min', null);
        $max = $request->get('max', null);
        $sub_category = $request->get('sub_category', null);
        $sort_by = $request->get('sorting', '');
        $limit = $request->get('limit', '');

        // Base query
        $query = Product::where('is_active', 1);

        // Apply category filter
        if ($category) {
            $query->where('category', $category);
        }
        if ($ids) {
            $query->whereIn('sub_category', $ids);
        }
        // Apply sub-category filter
        if ($sub_category) {
            $query->where('sub_category', $sub_category);
        }
        if (($sub_category || $ids) && $min && $max) {
            $query->whereBetween('offer_price', [$min, $max]);
        }
        
        if (($sub_category || $ids) && $min && !$max) {
            $query->where('offer_price', '>=', $min);
        }
        
        if (($sub_category || $ids) && !$min && $max) {
            $query->where('offer_price', '<=', $max);
        }

        // Apply stock filters
        if ($request->has('inStock') && $request->inStock) {
            $query->where('in_stock', 1); // Only include products in stock
        }

        if ($request->has('outStock') && $request->outStock) {
            $query->orWhere('in_stock', 0); // Include products out of stock
        }

        // Apply sorting logic
        if ($sort_by !== 'default' && $sort_by !== '') {
            switch ($sort_by) {
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

        // Apply pagination if limit is specified
        if ($limit) {
            $products = $query->with(['productImages', 'reviews', 'subCategoryDetails', 'categoryDetails'])->paginate($limit);
        } else {
            $products = $query->with(['productImages', 'reviews', 'subCategoryDetails', 'categoryDetails'])->get();
        }

        // Fetch filter subcategories
        $filterSubCategories = SubCategory::whereIn('id', Product::distinct()->pluck('sub_category'))->get();

        return view('products', compact('products', 'filterSubCategories'));
    }



}