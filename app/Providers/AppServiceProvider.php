<?php

namespace App\Providers;


use App\Models\Category;
use App\Services\DiscountService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //    
        $this->app->singleton(DiscountService::class, function ($app) {
                return new DiscountService();
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(DiscountService $discountService): void
    {
        // Fetch active categories with active subcategories
        View::composer('*', function ($view) {
            $global_categories =  Category::with('subCategories')->where('status', 'active')->get();
            // Share the data with all views
            $view->with('global_categories', $global_categories);
        });
        
        View::composer('*', function ($view) use ($discountService) {
            $discountThreshold = $discountService->getDiscountThreshold();
            $view->with('discountThreshold', $discountThreshold);
        });

        View::composer('parts.header', function ($view) {
            $headerPath = storage_path('app/head.json');
            
            if (file_exists($headerPath)) {
                $content = file_get_contents($headerPath);
                $headerData = json_decode($content, true);
                
                if ($headerData === null) {
                    $headerData = []; // Handle decoding errors
                }
            } else {
                $headerData = []; // Handle missing file
            }
    
            // Share data with all views that include 'parts.header'
            $view->with('headerData', $headerData);
        });
    }
}
