<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

use App\Services\DiscountService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Helpers\ReviewHelper;
use App\Http\Controllers\Controller;
use App\Models\ProductSectionProduct;


class HomeController extends Controller
{
    protected $discountService;
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService; // Inject DiscountService
    }

    public function index(){
        $missingSubCategoryProductIds = Product::whereDoesntHave('subCategoryDetails')->pluck('id');
        ProductSectionProduct::whereIn('product_id', $missingSubCategoryProductIds)->delete();
        
        $popularPicks = ProductSectionProduct::with('section_product')
            ->where('product_section_id', 1)
           
            ->get();
            $popularPicksTwo = ProductSectionProduct::with('section_product')
            ->where('product_section_id', 4)
           
            ->get();
            
        $most_wishes = ProductSectionProduct::with('section_product')
            ->where('product_section_id', 2)

            ->get();
        $handpicked = ProductSectionProduct::with('section_product')
            ->where('product_section_id', 3)

            ->get();

       
        $newest_products = Product::where('is_active', 1)
            ->where('category', 4)  // Filter products of Handcrafts
            ->orderBy('updated_at', 'desc')  // Order by updated_at to get the latest first
            ->take(16)->get();


        // Fetch all active products
        $all_products = Product::where('is_active', 1)
            ->orderBy('updated_at', 'desc') // Optional: order by updated_at
            ->get();

        // Fetch first tags for each product
        $firstTags = [];
        $seenTags = []; // Array to keep track of already seen tags

        foreach ($all_products as $product) {
            $tagsString = $product->tags; // Assuming 'tags' is the column that holds the comma-separated tags
            $tagsArray = array_map('trim', explode(',', $tagsString)); // Split tags by comma and trim spaces

            if (!empty($tagsArray)) {
                $firstTag = $tagsArray[0]; // Get the first tag

                // Only assign if the first tag is unique
                if (!in_array($firstTag, $seenTags)) {
                    $firstTags[$product->id] = $firstTag; // Store the first tag by product ID
                    $seenTags[] = $firstTag; // Mark this tag as seen
                } else {
                    // If the tag has been seen, find the next unique tag
                    foreach ($tagsArray as $tag) {
                        $tag = trim($tag); // Ensure no extra spaces
                        if (!in_array($tag, $seenTags)) {
                            $firstTags[$product->id] = $tag; // Assign the next unique tag
                            $seenTags[] = $tag; // Mark this tag as seen
                            break; // Stop searching for more unique tags
                        }
                    }
                }
            } else {
                $firstTags[$product->id] = null; // No tags found
            }
        }

        // Fetch all active products
        $activeProducts = Product::where('is_active', 1)->get();

        // Group products by category
        $productsByCategory = [];
        foreach ($activeProducts as $product) {
            $productsByCategory[$product->category][] = $product; // Assuming 'category_id' is the foreign key
        }

        // Get unique category IDs
        $uniqueCategoryIds = array_keys($productsByCategory);

        // Randomly select 3 unique categories
        $randomCategories = array_rand($uniqueCategoryIds, min(4, count($uniqueCategoryIds)));

        $selectedProducts = [];
        foreach ($randomCategories as $categoryId) {
            // Get one random product from the selected category
            $categoryProducts = $productsByCategory[$uniqueCategoryIds[$categoryId]];
            $selectedProducts[] = $categoryProducts[array_rand($categoryProducts)]; // Get a random product
        }


        // Kaleidoscopic section category fetch
        $activeCategories = Category::where('status', 'active')->take(6)->get();


        // Newest at Bangabasi
        $activeSubCategories = SubCategory::take(36)->get();

        $discountThreshold = $this->discountService->getDiscountThreshold();

        $homePath = storage_path('app/data.json'); // Use the correct path

        if (file_exists($homePath)) {
            $content = file_get_contents($homePath);
            $homeData = json_decode($content, true);
        
            if ($homeData === null) {
                $homeData = []; // Handle decoding errors
            }
        } else {
            $homeData = []; // Handle missing file
        }
        $headerPath = storage_path('app/head.json'); // Use the correct path

        if (file_exists($headerPath)) {
            $content = file_get_contents($headerPath);
            $headerData = json_decode($content, true);
        
            if ($headerData === null) {
                $headerData = []; // Handle decoding errors
            }
        } else {
            $headerData = []; // Handle missing file
        }
        
        // Fetch 10 random products from each category
        $food_products = Product::where('category', 2)->where('is_active', 1)->inRandomOrder()->take(10)->get();
        $clothing_products = Product::where('category', 1)->where('is_active', 1)->inRandomOrder()->take(10)->get();
        $dashakarma_products = Product::where('category', 3)->where('is_active', 1)->inRandomOrder()->take(10)->get();
        $machinery_products = Product::where('category', 6)->where('is_active', 1)->inRandomOrder()->take(10)->get();
       
        //Fetch all Categories
        $categories = Category::all();

        // Pass firstTags to the view
        return view('index', [
            'popularPicks' => $popularPicks,
            'popularPicksTwo' => $popularPicksTwo,
            'newest_products' => $newest_products,
            'handpicked' => $handpicked,
            'all_products' => $all_products,
            'most_wishes' => $most_wishes,
            'productsByCategory' => $productsByCategory,
            'firstTags' => $firstTags,  
            'selectedProducts' => $selectedProducts,
            'activeCategories' => $activeCategories,
            'activeSubCategories' => $activeSubCategories,
            'discountThreshold' => $discountThreshold,
            'homeData' => $homeData,
            'headerData' => $headerData,
            'categories' => $categories,
            // Pass the random products to the view
            'food_products' => $food_products, 
            'clothing_products' => $clothing_products, 
            'dashakarma_products' => $dashakarma_products, 
            'machinery_products' => $machinery_products
        ]);
    }
}
