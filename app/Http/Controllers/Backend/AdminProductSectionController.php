<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductSection;
use App\Http\Controllers\Controller;
use App\Models\ProductSectionProduct;

class AdminProductSectionController extends Controller
{
    public function index()
    {
        $section = ProductSection::orderBy('sort_order', 'asc')->get();
        return view('admin.pages.product_section.index', compact('section'));
    }
    public function manageProducts(Request $request, $section)
    {
        $missingSubCategoryProductIds = Product::whereDoesntHave('subCategoryDetails')->pluck('id');
        ProductSectionProduct::whereIn('product_id', $missingSubCategoryProductIds)->delete();
      
        // Retrieve the ProductSection
        $productSection = ProductSection::where('slug', $section)->first();

        // Get the selected product IDs from the ProductSectionProduct model
        $selectedProductIds = $productSection ? ProductSectionProduct::where('product_section_id', $productSection->id)
            ->pluck('product_id')->toArray() : [];
           
        $categories = Category::all();
        // Fetch products based on selected category
        $categoryId = $request->input('category');

        // Build query
        $query = Product::query();
        if ($categoryId) {
            
            $query->where('category', $categoryId);
        }
        $products = $query->where('is_active', 1)->get();
        return view('admin.pages.product_section.manageproducts', compact('section', 'products', 'categories', 'selectedProductIds'));
    }

    public function saveProducts(Request $request)
    {
        // Retrieve the comma-separated product IDs and convert to array
        $productIdsString = $request->input('selected_products', '');
        $productIds = array_filter(explode(',', $productIdsString));

        // Retrieve the section name
        $sectionName = $request->input('section');

        // Find the product section by section name
        $productSection = ProductSection::where('slug', $sectionName)->first();

        if ($productSection) {
            // Delete existing records for this section
            ProductSectionProduct::where('product_section_id', $productSection->id)->delete();

            // Check if there are any product IDs to save
            if (!empty($productIds)) {
                // Store new records
                foreach ($productIds as $productId) {
                    // Make sure $productId is a valid integer and not empty
                    if (!empty($productId) && is_numeric($productId)) {
                        ProductSectionProduct::create([
                            'product_id' => (int) $productId,
                            'product_section_id' => $productSection->id,
                        ]);
                    }
                }
            }

            // Redirect back with success message
            return redirect()->route('manage.products', ['section' => $sectionName])
                ->with('success', 'Products updated successfully.');
        }

        // Redirect back with error if section not found
        return redirect()->route('manage.products', ['section' => $sectionName])
            ->with('error', 'Product section not found.');
    }



}
