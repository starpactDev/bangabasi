<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Sidebar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SidebarController extends Controller
{
    public function index()
    {
        // Retrieve the sidebar data
        $sidebarData = Sidebar::first(); // Assuming there's only one sidebar entry
    
        // Prepare the data for JSON response
        $responseData = [
            'main_image' => $sidebarData->main_image,
            'dialogs' => [
                [
                    'svg' => $sidebarData->svg_1, // Adjust these fields based on your actual column names
                    'text' => $sidebarData->dialog_1,
                ],
                [
                    'svg' => $sidebarData->svg_2,
                    'text' => $sidebarData->dialog_2,
                ],
                [
                    'svg' => $sidebarData->svg_3,
                    'text' => $sidebarData->dialog_3,
                ],
            ],
        ];
    
        // Return the JSON response
        return response()->json($responseData);
    }
    
}
