<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Review;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\ProductSize;
use App\Models\ReviewImage;

use App\Models\SubCategory;

use Illuminate\Http\Request;
use App\Helpers\ReviewHelper;
use App\Services\DiscountService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ViewSaleAboveDiscount;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
   
    public function fetchStates()
    {
        try {
            $apiUrl = config('services.shiprocket.base_url') . '/courier/serviceability/';
            $token = config('services.shiprocket.token');

            Log::info('Attempting Shiprocket API call', [
                'url' => $apiUrl,
                'token_length' => strlen($token)
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($apiUrl);

            Log::info('Shiprocket API response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'error' => 'Failed to fetch states from Shiprocket API',
                'status' => $response->status(),
                'details' => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Shiprocket API error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Error fetching states',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    protected $discountService;

    public function review_store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:1000',
            'p_id' => 'exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'images' => 'array|max:5', // Limit number of images (5 in this case)
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Get authenticated user id if exists, otherwise null
        $user_id = optional(Auth::user())->id;

        // Store review
        $review = Review::create([
            'user_id' => $user_id,
            'product_id' => $validated['p_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rating' => $validated['rating'],
            'review_message' => $validated['review'],
            'status' => 'inactive',
        ]);

        // Handle images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique name for the image
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Store the image in the 'public/review_images' directory
                $image->move(public_path('user/uploads/review_images'), $imageName);
                // Save the image path in the 'review_images' table
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image_path' => $imageName,
                ]);
            }
        }

        return response()->json(['message' => 'Review submitted successfully!'], 200);
    }


    public function detail_index($id)
    {

        $product = Product::findOrFail($id);
        $related_products= Product::where('sub_category', $product->sub_category)->where('id', '!=', $product->id)->get();
        $rating = ReviewHelper::getAverageRating($id);

        $reviewCount = ReviewHelper::getReviewCount($id);
        // Check if all sizes for the product have a quantity of 0
        $sizesLeft = ProductSize::where('product_id', $id)
            ->where('quantity', '>', 0)
            ->count();

        if ($sizesLeft === 0) {
            // Update the in_stock field to 0 in the Product model
            $product = Product::find($id);
            $product->in_stock = 0;
            $product->save();
        }else {
            // If there is stock for at least one size, set in_stock to 1
            $product = Product::find($id);
            if ($product->in_stock == 0) { // Only update if it's currently out of stock
                $product->in_stock = 1;
                $product->save();
            }
        }

        $reviews = Review::select('rating', DB::raw('count(*) as count'))
            ->where('product_id', $id)
            ->where('status', 'active') // Only count active reviews
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
           
            ->get();
        $review_info = Review::with("review_images", "user")->where('product_id', $id)->where('status', 'active')->get();
        // Prepare an array to hold counts for each rating (1 to 5)
        $ratingsCount = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];
        /* foreach($review_info as $review){
            dd();
        } */

        

        // Fill the array with actual counts from the database
        foreach ($reviews as $review) {
            $ratingsCount[$review->rating] = $review->count;
        }
        // Calculate the percentage for each star rating
        $ratingsPercentage = [];
        foreach ($ratingsCount as $star => $count) {
            $ratingsPercentage[$star] = $reviewCount > 0 ? ($count / $reviewCount) * 100 : 0;
        }
        $wishlist = Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first();


        //Collect the Seller information 

        $seller = Seller::where('user_id', $product->user_id)->with('pickupAddress')->first();

        if ($seller) {
            $sellerProducts = Product::where('user_id', $seller->user_id)->count();
            $seller->setAttribute('product_count', $sellerProducts);

            // Calculate average rating
            $averageRating = Product::where('products.user_id', $seller->user_id)
                ->join('reviews', 'products.id', '=', 'reviews.product_id')
                ->where('reviews.status', 'active') // Only consider active reviews
                ->avg('reviews.rating');

            // Add average rating
            $seller->setAttribute('average_rating', $averageRating ?? 0); // Default to 0 if null

            // Count total reviews
            $totalReviews = Product::where('products.user_id', $seller->user_id)
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('reviews.status', 'active') // Only consider active reviews
            ->count();
            $seller->setAttribute('total_reviews', $totalReviews);
        }

        return view('product', compact('product', 'rating', 'reviewCount', 'ratingsCount', 'ratingsPercentage', 'review_info', 'wishlist','related_products', 'seller'));
    }
    
    public function index(Request $request)
    {
        $category = $request->get('category', null);
        $sub_category = $request->get('sub_category', null);
        $stock = $request->get('stock', null); // Get stock filter if present
      
        $sort_by = $request->get('sorting', '');
        $limit = $request->get('limit', '');

        // Build the base query
        $query = Product::query()->where('is_active', 1);

        if ($category) {
            $query->where('category', $category);
        }

        if ($sub_category) {
            $query->where('sub_category', $sub_category);
        }

        if (!is_null($stock)) {
          
            $query->where('in_stock', $stock);
        }

        // Eager load relationships
        $query->with([
            'productImages',
            'reviews',
            'subCategoryDetails',
            'categoryDetails',
        ]);

        $products = $query->get();

        // Apply sorting if specified
        if ($sort_by && $sort_by !== 'default') {
            switch ($sort_by) {
                case 'rating':
                    foreach ($products as $product) {
                        $product->rating = $product->reviews->avg('rating');
                    }
                    $products = $products->sortByDesc('rating');
                    break;

                case 'latest':
                    $products = $products->sortByDesc('created_at');
                    break;

                case 'high-to-low':
                    $products = $products->sortByDesc('offer_price');
                    break;

                case 'low-to-high':
                    $products = $products->sortBy('offer_price');
                    break;
            }
        }

        // Apply pagination if limit is specified
        if ($limit) {
            $products = $this->paginate($products, $limit);
        }

        // Get filterable subcategories
        $filterSubCategories = SubCategory::whereIn('id', function ($query) {
            $query->select('sub_category')
                ->from('products')
                ->distinct()
                ->where('is_active', 1); // Only consider active products
        })->get();

        return view('products', compact('products', 'filterSubCategories'));
    }



    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function search(Request $request)
    {
        $query = $request->get('query');
        $products = SubCategory::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json(['products' => $products]);
    }

    public function getProductsByCategory($category)
    {
        // Fetch products based on the specified category with all necessary details
        $products = Product::where('category', $category)
            ->with('productImages', 'reviews', 'subCategoryDetails', 'categoryDetails')
            ->get();

        return $products;
    }
}