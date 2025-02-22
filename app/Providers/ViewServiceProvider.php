<?php

namespace App\Providers;

use App\Models\Logo;
use App\Models\Marquee;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['parts.header', 'authentication', 'parts.components.footer', 'components.brand-new-footer', 'admin.layouts.sidebar', 'admin.pages.login', 'seller.layouts.sidebar'], function ($view) {
            // Fetch logos based on location from the database
            $logos = Logo::select('id', 'image_path', 'location')  // Fetch only relevant columns
            ->get()
            ->keyBy('id');
            
            // Pass logos to the layout view
            $view->with('logos', $logos);
        });

        View::composer('components.marquee', function ($view) {
            // Fetch marquee texts from the database
            $marquees = Marquee::select('text') // Fetch only the text column
                ->get();
            
            // Pass marquee texts to the index view
            $view->with('marquees', $marquees);
        });

        View::composer('parts.components.footer', function ($view) {
            $activeCategories = Category::where('status', 'active')->take(6)->get();
            
            $view->with('activeCategories', $activeCategories);
        });

      
    }
}
