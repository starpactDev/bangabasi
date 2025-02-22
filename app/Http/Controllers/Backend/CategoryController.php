<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\CategoryHeaderImage;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->product_count = Product::where('category', $category->id)->count();
        }
        return view('admin.pages.category.index', compact('categories'));
    }

    public function header_images()
    {
        $categories = Category::all();

        return view('admin.pages.category.header_images', compact('categories'));
    }

    public function product_show($id)
    {

        $product = Product::with('productImages')->find($id);

        if (!$product) {
            // Return a 404 response if the product is not found
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Format product images URLs
        $productImages = $product->productImages->map(function ($image) {
            return [
                'image_url' => asset('user/uploads/products/images/' . $image->image)
            ];
        });

        // Return the product data as JSON
        return response()->json([
            'product' => [
                'name' => $product->name,
                'category' => $product->category,
                'sub_category' => $product->sub_category,
                'productImages' => $productImages
            ]
        ]);
    }
    public function destroy($id)
    {
        $data = Category::find($id);

        if (!$data) {

            return redirect()->back()->with('error', 'Category not found.');
        }

        try {
            // Delete the  image
            $oldImage = $data->images;
            if ($oldImage && file_exists(public_path('user/uploads/category/image/' . $oldImage))) {
                unlink(public_path('user/uploads/category/image/' . $oldImage));
            }
            $data->delete();
            return redirect()->back()->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the product.');
        }
    }

    public function show($id)
    {
        $category = Category::with('subcategories')->findOrFail($id);

        return response()->json(['category' => $category, 'subcategories' => $category->subcategories]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->status = 'active';

        // Handle image upload and validation
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            list($width, $height) = getimagesize($image);
            if ($width != 50 || $height != 50) {
                return response()->json(['message' => 'Image dimensions must be 50x50 pixels'], 422);
            }

            // Delete old image if it exists
            $oldImage = $category->images;
            if ($oldImage && file_exists(public_path('user/uploads/category/image/' . $oldImage))) {
                unlink(public_path('user/uploads/category/image/' . $oldImage));
            }

            // Upload new image
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/user/uploads/category/image');
            $image->move($destinationPath, $imageName);

            $category->images = $imageName;
        }

        $category->save();

        // Handle subcategories
        $deletedSubCategoryNames = [];
        if ($request->sub_category) {
            // Fetch existing subcategories
            $existingSubCategories = SubCategory::where('category_id', $id)->get()->keyBy('name')->toArray();
        
            // Filter out null or empty subcategories from the request
            $filteredSubCategories = array_filter($request->sub_category, function ($subCategory) {
                return !is_null($subCategory) && $subCategory !== '';
            });
        
            foreach ($filteredSubCategories as $submittedName) {
                // Check if the submitted name exists in the database
                $subCategory = SubCategory::where('category_id', $id)->where('name', $submittedName)->first();
        
                if (!$subCategory) {
                    // If the name doesn't exist, create a new subcategory
                    SubCategory::create([
                        'name' => $submittedName,
                        'category_id' => $category->id,
                    ]);
                } elseif ($subCategory->name !== $submittedName) {
                    // If the name exists but is different, update the existing record
                    $subCategory->update(['name' => $submittedName]);
                }
        
                // Remove the processed name from the $existingSubCategories array
                unset($existingSubCategories[$submittedName]);
            }
        
            // Delete subcategories that were not included in the request
            if (!empty($existingSubCategories)) {
                $subCategoryIdsToDelete = array_column($existingSubCategories, 'id');
        
                // Count products in subcategories to be deleted
                $productCount = Product::whereIn('sub_category', $subCategoryIdsToDelete)->count();
                Product::whereIn('sub_category', $subCategoryIdsToDelete)->update(['is_active' => false]);
        
                // Delete the subcategories
                SubCategory::whereIn('id', $subCategoryIdsToDelete)->delete();
        
                // Get the names of deleted subcategories
                $deletedSubCategoryNames = array_keys($existingSubCategories);
            }
        }

        // Prepare the success message with product count and deleted subcategories
        $successMessage = [
            'success' => true,
            'productCount' => $productCount ?? 0, // Number of products in deleted subcategories
            'deletedSubCategories' => $deletedSubCategoryNames // Names of deleted subcategories
        ];

        return response()->json($successMessage);
    }



    public function getCategories()
    {
        return Category::all();
    }
    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
    public function getProducts($subcategoryId)
    { 
        // Find the subcategory by its ID
        $sub_category = SubCategory::find($subcategoryId);

        // Fetch products where the sub_category matches the subcategory name
        $products = Product::where('sub_category', $sub_category->id)
            ->get();


        // Add image URL to each product
        $products->each(function ($product) {
            if ($product->productImages->isNotEmpty()) {
                $product->image_url = asset('user/uploads/products/images/' . $product->productImages->first()->image);
            } else {
                $product->image_url = asset('default/path/to/placeholder.jpg'); // Optional: default image
            }
        });

        // Return the products with the image URLs
        return response()->json($products);
    }
    public function getCategoryImages($id)
    {
        // Fetch all images related to the category_id
        $categoryImages = CategoryHeaderImage::where('category_id', $id)->get();

        // Prepare the response to include the full asset path for the images
        $categoryImages->transform(function ($image) {
            $image->image_url = asset('user/uploads/category/header_image/' . $image->title); // Assuming title contains image name
            $image->sub_category_name = $image->subCategory ? $image->subCategory->name : 'No Sub-Category'; // Retrieve sub-category name
            return $image;
        });

        // Return the data as JSON
        return response()->json($categoryImages);
    }
    public function getImageDetails($id)
    {
        // Fetch the image record by its ID
        $image = CategoryHeaderImage::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // Return the image details along with the category_id
        return response()->json([
            'id' => $image->id,
            'category_id' => $image->category_id,
            'title' => $image->title,
        ]);
    }
    public function getSubCategoriesByCategory($categoryId)
    {
        // Fetch sub-categories related to the category ID
        $subCategories = SubCategory::where('category_id', $categoryId)->get();

        // Return the sub-categories as JSON
        return response()->json($subCategories);
    }
    public function updateImage(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:category_header_images,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Fetch the image record to update
        $image = CategoryHeaderImage::find($request->input('image_id'));

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // Update sub-category ID
        $image->sub_category = $request->input('sub_category_id');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
            $destinationPath = public_path('user/uploads/category/header_image');
            $imageFile->move($destinationPath, $fileName);

            // Update image title with the new file name
            $image->title = $fileName;
        }

        // Save the updated image record
        $image->save();

        // Prepare the response with the updated image data
        return response()->json([
            'message' => 'Data updated successfully',
            'image' => [
                'id' => $image->id,
                'image_url' => asset('user/uploads/category/header_image/' . $image->title),
                'sub_category_name' => $image->subCategory ? $image->subCategory->name : 'N/A', // Assuming you have a relation
            ]
        ]);
    }


}
