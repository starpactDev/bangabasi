<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Blog;
class Blogsection extends Component
{
    /**
     * Create a new component instance.
     */
    public $blogs;
    public function __construct()
    {
        $this->blogs = Blog::where('status', 'published')->get();
    }

    /**
    * Get the view / contents that represent the component.
    */
    
    public function render(): View|Closure|string
    {
        $blogs = $this->blogs;
        return view('components.blogsection', compact('blogs'));
    }
}