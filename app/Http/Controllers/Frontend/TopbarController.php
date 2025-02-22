<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topbar;

class TopbarController extends Controller
{
    public function index(Request $request)
    {
        $layout = $request->layout;

        $topbars = Topbar::with(['category1', 'category2', 'category3', 'category4'])
            ->where('layout_type', $layout)
            ->get();

    $html = view('partials.topbar', compact('topbars', 'layout'))->render();

    return response($html);
        
    }
}
