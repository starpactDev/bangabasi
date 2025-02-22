<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $image;
    public $category;
    public $title;
    public $rating;
    public $discount;
    public $description;
    public $originalPrice;
    public $discountedPrice;
    public $inStock;
    public $discountThreshold;
    public $cardClass;


    public function __construct(
        $image = '/images/products/default.png', 
        $category = 'Unknown Category', 
        $title = 'Default Product Title', 
        $rating = 0, 
        $discount = 0, 
        $originalPrice = 0, 
        $discountedPrice = 0,
        $inStock = 1,
        $discountThreshold = 100,
        $cardClass = ''
    )
    {
        $this->image = $image;
        $this->category = $category;
        $this->title = $title;
        $this->rating = $rating;
        $this->discount = $discount;
        $this->originalPrice = $originalPrice;
        $this->discountedPrice = $discountedPrice;
        $this->inStock = $inStock;
        $this->discountThreshold = $discountThreshold;
        $this->cardClass = $cardClass;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
