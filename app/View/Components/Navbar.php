<?php

namespace App\View\Components;

use Closure;
use App\Models\Cart;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $cartCount;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cartCount = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
