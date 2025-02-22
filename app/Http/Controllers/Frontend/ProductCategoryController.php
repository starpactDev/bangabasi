<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function showByCategory(Request $request, $category){
        $products = Product::where('category', $category)
            ->with('productImages', 'reviews', 'subcategoryDetails', 'categoryDetails')
            ->get();

            return view('products_by_category', compact('index'));
    }
}
