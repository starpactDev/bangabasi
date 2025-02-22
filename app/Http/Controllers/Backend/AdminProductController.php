<?php

namespace App\Http\Controllers\Backend;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Collection;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Models\BrandProduct;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Helpers\ReviewHelper;
use App\Models\ProductColour;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller {
    public function generateItemCode(Request $request) {
        // Fetch the category and subcategory names based on the IDs
        $category = Category::find($request->category_id);
        $subcategory = SubCategory::find($request->subcategory_id);

        if (!$category || !$subcategory) {
            return response()->json(['error' => 'Invalid category or subcategory'], 400);
        }

        // Get the first letter of the category and subcategory name
        $categoryLetter = strtoupper(substr($category->name, 0, 1)); // First letter of category name
        $subcategoryLetter = strtoupper(substr($subcategory->name, 0, 1)); // First letter of subcategory name

        // Generate a random 4-digit number
        $randomNumber = mt_rand(1000, 9999);

        // Construct the item code
        $itemCode = "BB" . $categoryLetter . $subcategoryLetter . $randomNumber;

        // Ensure the item code is unique
        while (Product::where('item_code', $itemCode)->exists()) {
            $randomNumber = mt_rand(1000, 99999); // Increase number length if necessary
            $itemCode = "BB" . $categoryLetter . $subcategoryLetter . $randomNumber;
        }

        return response()->json(['item_code' => $itemCode]);
    }

    public function updateStatus(Request $request, $id) {

            // Find the product
        $product = Product::findOrFail($id);

        // Check if the sub_category exists in the SubCategory model
        $subCategoryExists = SubCategory::where('id', $product->sub_category)->exists();

        if (!$subCategoryExists) {
            // If the sub_category doesn't exist, return a failure response
            return response()->json(['success' => false, 'message' => 'Subcategory not found for this product.'], 404);
        }

        // Update the product status
        $product->is_active = $request->input('status');
        $product->save();

        return response()->json(['success' => true]);
    }

    public function size_index() {
        // Return all sizes
        $sizes = Size::with('categoryDetails')->get();
        return response()->json($sizes);
    }

    public function add() {
        $categories = Category::all();
        $sizes = Size::all();
        $groupedSizes = $sizes->groupBy(function($size) {
            return $size->categoryDetails ? $size->categoryDetails->name : 'Unknown Category';
        });
       
        $brands = Brand::all();
        $collections = Collection::all();
        return view('admin.pages.product.addproduct', compact('categories', 'sizes', 'brands', 'collections','groupedSizes'));
    }

    public function size_store(Request $request) {
       
        $request->validate([
            'name' => 'required|max:255',
            'key' => 'required'
        ]);

        $size = Size::create([
            'name' => $request->name,
            'key' => $request->key
        ]);

        $sizes = Size::all();


        return response()->json([
            'size' => $size,
            'sizes' => $sizes
        ]);
    }

    public function size_destroy($id) {
        $size = Size::findOrFail($id);
        $size->delete();


        $sizes = Size::all();

        return response()->json([
            'success' => 'Size deleted successfully',
            'sizes' => $sizes,
            'size' => $size
        ]);
    }
    public function view() {

        $products = Product::with(['productImages', 'productSizes', 'productColours'])->orderBy('created_at', 'desc')->get();
        foreach ($products as $product) {
            // Check if the sub_category exists in the SubCategory table
            if (!SubCategory::where('id', $product->sub_category)->exists()) {
                // If sub_category is not found, update 'is_active' to false
                $product->is_active = false;
                $product->save();
            }
        }
    
        return view('admin.pages.product.viewproduct', compact('products'));
    }

    public function viewInactive() {
        $products = Product::with(['productImages', 'productSizes', 'productColours'])->where('is_active', 0)->orderBy('created_at', 'desc')->get();
        foreach ($products as $product) {
            // Check if the sub_category exists in the SubCategory table
            if (!SubCategory::where('id', $product->sub_category)->exists()) {
                // If sub_category is not found, update 'is_active' to false
                $product->is_active = false;
                $product->save();
            }
        }

        return view('admin.pages.product.inactive', compact('products'));
    }

    public function show($id) {
        $product = Product::findOrFail($id);
        $averageRating = ReviewHelper::getAverageRating($id);
        $reviewCount = ReviewHelper::getReviewCount($id);
        $reviews = Review::where('product_id', $id)
            ->where('status', 'active')
            ->get();
        return view('admin.pages.product.details', compact('product', 'averageRating', 'reviewCount', 'reviews')); // Create this view for product info
    }

    public function edit($id) {
        $categories = Category::all();
        $sizes = Size::all();
        $groupedSizes = $sizes->groupBy(function($size) {
            return $size->categoryDetails ? $size->categoryDetails->name : 'Unknown Category';
        });
        
        $product = Product::findOrFail($id);

        $categories = Category::all();
        $brands = Brand::all();
        $collections = Collection::all();
        $selected_category = Category::where('id', $product->category)->first();

        $subcategories = SubCategory::where('category_id', $selected_category->id)->get();
        $sizes = Size::all();
        return view('admin.pages.product.edit', compact('categories', 'product', 'subcategories', 'sizes', 'brands', 'collections', 'groupedSizes')); // Create this view for product info
    }

    public function edit_image($id) {

        $product = Product::findOrFail($id);
        return view('admin.pages.product.edit_image', compact('product'));
    }

    public function update_image(Request $request) {
        // Validate input
        $request->validate([
            'image_id' => 'required|exists:product_images,id',

            'youtube_url' => 'nullable|url',
        ]);
        

        // Ensure that either a file or a YouTube URL is provided, but not both
        if (!$request->hasFile('new_image') && !$request->youtube_url) {
            return response()->json([
                'success' => false,
                'message' => 'Please upload an image/video file or enter a YouTube URL.',
            ], 422);
        } elseif ($request->hasFile('new_image') && $request->youtube_url) {
            return response()->json([
                'success' => false,
                'message' => 'Please upload either an image/video file or enter a YouTube URL, not both.',
            ], 422);
        }

        $image = ProductImage::findOrFail($request->image_id);

        // Handle file upload
        if ($request->hasFile('new_image')) {
            // Delete the old image from the public folder
            $oldImagePath = public_path('user/uploads/products/images/' . $image->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // Store the new image
            $newImageName = time() . '_' .  uniqid() . '.' . $request->file('new_image')->getClientOriginalExtension();

            $request->file('new_image')->move(public_path('user/uploads/products/images'), $newImageName);

            // Update the image record in the database
            $image->image = $newImageName;

            $image->save();

            // Handle YouTube URL
        } elseif ($request->youtube_url) {
            // Delete the old image if it was not a YouTube URL
            $oldImagePath = public_path('user/uploads/products/images/' . $image->image);
            if (!$image->is_youtube_url && File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // Update the record with the YouTube URL
            $image->image = $request->youtube_url;

            $image->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Image/Video updated successfully!',
        ]);
    }

    public function store_image(Request $request) {
        
        $request->validate([
            'image' => 'required', // Validate the image
            'product_id' => 'required|exists:products,id', // Ensure the product exists

            'youtube_url' => 'nullable|url',
        ]);
        if ($request->hasFile('image')) {
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('/user/uploads/products/images');
            $image->move($destinationPath, $imageName);

            ProductImage::create([
                'product_id' => $request->product_id,
                'image' => $imageName,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Image uploaded successfully!',
            ]);
        } elseif ($request->youtube_url) {
            
            $imageName = $request->youtube_url;
            ProductImage::create([
                'product_id' => $request->product_id,
                'image' => $imageName,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Image uploaded successfully!',
            ]);
        } else {
            
            return response()->json([
                'status' => 'error',
                'message' => 'Image upload failed!',
            ]);
        }
    }

    public function destroy_image($id)  {
        $data = ProductImage::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Image not found.');
        }

        try {
            // Delete the  image
            $oldImage = $data->image;
            if ($oldImage && file_exists(public_path('user/uploads/products/images/' . $oldImage))) {
                unlink(public_path('user/uploads/products/images/' . $oldImage));
            }
            $data->delete();
            return redirect()->back()->with('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the image.');
        }
    }

    public function submit(Request $request) {

        $user = Auth::user();
        // Validate form data
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categories' => 'required|string|max:255',
            'subcategories' => 'required|string|max:255',
            'original_price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string',
            'full_details' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $category = Category::where('id', $request->categories)->first();

        // Store product details
        $product = Product::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'tags' => $request->tags,
            'category' => $category->id,
            'sub_category' => $request->subcategories,
            'collections' => $request->collection,
            'item_code' => $request->item_code,
            'original_price' => $request->original_price,
            'offer_price' => $request->offer_price,
            'discount_percentage' => $request->discount_percentage,
            'short_description' => $request->short_description,
            'full_details' => $request->full_details,
            'is_active' => true, // Default value
        ]);
        if ($request->has('brand')) {
            BrandProduct::create([
                'product_id' => $product->id,
                'brand_id' => $request->brand,
            ]);

            // Update the total product count for the brand
            $brand = Brand::find($request->brand);

            $brand->total_listing_products = $brand->products()->count();
            $brand->save();
        }

        // Store images or YouTube URL

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedFile) {
                $extension = $uploadedFile->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $destinationPath = public_path('/user/uploads/products/images');

                // Check if the file is an image or a video
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    // Store image
                    $uploadedFile->move($destinationPath, $imageName);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageName,
                    ]);
                }

                if (in_array(strtolower($extension), ['mp4', 'mkv', 'avi'])) {
                    // Store video
                    $uploadedFile->move($destinationPath, $imageName);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageName,  // Assuming you have a 'video' field
                    ]);
                }
            }
        }

        // Step 2: Store YouTube URLs
        if ($request->has('images')) {
            foreach ($request->input('images') as $image) {
                // Check if the input is a valid YouTube URL
                if (is_string($image) && $this->isValidYouTubeURL($image)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $image, // Store the YouTube URL in the 'video' field
                    ]);
                }
            }
        }
        // Store sizes
        // Get the sizes and their quantities
        $sizes = $request->input('sizes', []); // Array of selected sizes
        $sizeQuantities = $request->input('size_quantity', []); // Array of quantities keyed by size

        // Loop through each selected size
        foreach ($sizes as $size) {
            // Check if the size is in the size_quantity array and has a value
            if (isset($sizeQuantities[$size])) {
                // Create a new ProductSize entry
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'quantity' => $sizeQuantities[$size],
                ]);
            }
        }

        // Store colors
        if ($request->has('colors')) {
            foreach ($request->colors as $color) {
                ProductColour::create([
                    'product_id' => $product->id,
                    'colour_name' => $color,
                ]);
            }
        }

        return response()->json(['message' => 'Product created successfully']);
    }

    private function isValidYouTubeURL($url) {
        $youtubeRegex = '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/';
        return preg_match($youtubeRegex, $url);
    }

    public function update(Request $request) {

        // Validate form data
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categories' => 'required|string|max:255',
            'subcategories' => 'required|string|max:255',
            'original_price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string',
            'full_details' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the existing product
        $product = Product::findOrFail($request->product_id);

        // Update product details
        $category = Category::where('id', $request->categories)->first();
        $product->update([
            'name' => $request->name,
            'tags' => $request->tags,
            'category' => $category->id,
            'sub_category' => $request->subcategories,
            'collections' => $request->collection,
            'item_code' => $request->item_code,
            'original_price' => $request->original_price,
            'offer_price' => $request->offer_price,
            'discount_percentage' => $request->discount_percentage,
            'short_description' => $request->short_description,
            'full_details' => $request->full_details,
        ]);

        // Handle image uploads
        // if ($request->hasFile('images')) {
        //     // Delete old images
        //     ProductImage::where('product_id', $product->id)->delete();
        //     foreach ($request->file('images') as $image) {
        //         $imageName = time() . '_' . $image->getClientOriginalName();
        //         $destinationPath = public_path('/user/uploads/products/images');
        //         $image->move($destinationPath, $imageName);

        //         ProductImage::create([
        //             'product_id' => $product->id,
        //             'image' => $imageName,
        //         ]);
        //     }
        // }
        if ($request->has('brand')) {
            $existBrand = Brandproduct::where('product_id', $product->id)->first();
            if ($existBrand) {
                $existBrand->delete();
            }
            BrandProduct::create([
                'product_id' => $product->id,
                'brand_id' => $request->brand,
            ]);

            // Update the total product count for the brand
            $brand = Brand::find($request->brand);

            $brand->total_listing_products = $brand->products()->count();
            $brand->save();
        }

        // Update sizes
        
        $sizes = $request->input('sizes', []); // Array of selected sizes

        if(!empty($sizes)){
            ProductSize::where('product_id', $product->id)->delete();
        }
        $sizeQuantities = $request->input('size_quantity', []); // Array of quantities keyed by size

        foreach ($sizes as $size) {
            if (isset($sizeQuantities[$size])) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'quantity' => $sizeQuantities[$size],
                ]);
            }
        }
        $sizesLeft = ProductSize::where('product_id', $product->id)
            ->where('quantity', '>', 0)
            ->count();
        if ($sizesLeft === 0) {
            $product = Product::find($product->id);
            $product->in_stock = 0;
            $product->save();
        } else {
            // If there is stock for at least one size, set in_stock to 1
            $product = Product::find($product->id);
            if ($product->in_stock == 0) { // Only update if it's currently out of stock
                $product->in_stock = 1;
                $product->save();
            }
        }
        // Update colors
        ProductColour::where('product_id', $product->id)->delete();
        if ($request->has('colors')) {
            foreach ($request->colors as $color) {
                ProductColour::create([
                    'product_id' => $product->id,
                    'colour_name' => $color,
                ]);
            }
        }

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function delete($id, Request $request) {

        try {
            // Find the product
            if ($request->input('deleteConfirmation') == 'confirmed') {
                $product = Product::findOrFail($id);

                // Delete associated images from the folder
                $productImages = ProductImage::where('product_id', $product->id)->get();
                foreach ($productImages as $productImage) {
                    $imagePath = public_path('/user/uploads/products/images/' . $productImage->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image from the folder
                    }
                    $productImage->delete(); // Delete the image record from the database
                }

                // Delete associated sizes
                ProductSize::where('product_id', $product->id)->delete();

                // Delete associated colors
                ProductColour::where('product_id', $product->id)->delete();

                // Finally, delete the product itself
                $product->delete();

                return redirect()->route('admin_viewproduct')
                    ->with('success', 'Product and related data deleted successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin_viewproduct')
                ->with('error', 'Failed to delete the product.');
        }
    }

    public function viewMore() {
        $purchasedProducts = OrderItem::with('product')
            ->select('product_id', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('product_id')
            ->orderBy('purchase_count', 'DESC')
            ->get(); // Fetch all or paginated results

        return view('admin.pages.product.purchased_view_more', compact('purchasedProducts'));
    }
    public function lowStock() {
        $products = Product::whereHas('productSizes', function ($query) {
            $query->where('quantity', '<', 5);
        })->get();
        return view('admin.pages.product.low_stock', compact('products'));
    }

    public function myProducts() {
        $user = Auth::user();
        // Retrieve products where user_id = 1, along with related data, ordered by created_at descending
        $products = Product::where('user_id', $user->id)
                            ->with(['productImages', 'productSizes', 'productColours'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Loop through each product to check if the sub_category exists in the SubCategory table
        foreach ($products as $product) {
            // Check if the sub_category exists in the SubCategory table
            if (!SubCategory::where('id', $product->sub_category)->exists()) {
                // If sub_category is not found, update 'is_active' to false
                $product->is_active = false;
                $product->save();
            }
        }

        // Return the view with the filtered products
        return view('admin.pages.product.viewproduct', compact('products'));
    }
}
