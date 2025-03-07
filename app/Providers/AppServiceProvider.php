<?php

namespace App\Providers;


use App\Models\Message;
use App\Models\Category;
use App\Services\DiscountService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
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

        // Initialize the unread message count cache
        $this->initializeUnreadMessageCache();
    }

    // Method to initialize unread message count in cache
    private function initializeUnreadMessageCache()
    {
        // Only initialize if the cache is not already set
        if (!Cache::has('unread_messages_count')) {
            // Count unread messages where 'responsed' is false (unread)
            $unreadCount = Message::where('responsed', false)->count();
            Cache::put('unread_messages_count', $unreadCount); // Cache for 1 hour
        }
    }

    public static function updateUnreadMessageCache()
    {
        // Get the updated unread message count where 'responsed' is false (unread)
        $unreadCount = Message::where('responsed', false)->count();
        Cache::put('unread_messages_count', $unreadCount); // Cache for 1 hour
    }
}
