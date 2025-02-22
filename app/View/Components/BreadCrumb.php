<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public $page;
    public $previousHref;
    public function __construct($page, $previousHref)
    {
        $this->page = $page;
        $this->previousHref = $previousHref;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bread-crumb');
    }
}
