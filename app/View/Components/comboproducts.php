<?php

namespace App\View\Components;

use Closure;
use App\Models\Product;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class comboproducts extends Component
{
    public $comboproducts;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->comboproducts = Product::where('is_active', 1)
            ->where('category', 5) // Filter products of Handcrafts
            ->orderBy('updated_at', 'desc') // Order by updated_at to get the latest first
            ->take(3) // Limit to 3 products
            ->with([
                'productImages',
                'reviews', 
                'categoryDetails', 
            ])
            ->get();
        
        // Calculate average ratings for each product
        foreach ($this->comboproducts as $product) {
            $product->rating = $product->reviews->avg('rating') ?: 0; // Fallback to 0 if no reviews
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comboproducts', ['comboproducts' => $this->comboproducts]);
    }
}
