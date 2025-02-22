<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $path = storage_path('app/about.json'); // Use the correct path

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $about = json_decode($content, false);
        
            if ($about === null) {
                $about = []; // Handle decoding errors
            }
        } else {
            $about = []; // Handle missing file
        }

        return view('aboutus', compact('about'));
    }
}
