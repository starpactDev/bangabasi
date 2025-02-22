<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Posts extends Component
{
    /**
     * Create a new component instance.
     */
    public $id; 
    public $slug;
    public $imageUrl;
    public $title;
    public $description;
    public $date;

    public function __construct($id, $slug, $imageUrl, $title, $description, $date)
    {
        $this->id = $id; 
        $this->slug = $slug;
        $this->imageUrl = $imageUrl;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.posts');
    }
}
