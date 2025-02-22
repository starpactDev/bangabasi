<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sidebar;

class AdminSidebarController extends Controller
{
    public function index(){
        return view('admin.pages.sidebar.index');
    }
    public function updateText(Request $request)
    {
        $sidebar = Sidebar::first(); // Fetch the only row

        $editor = $request->input('editor');
        $content = $request->input('content');

        switch ($editor) {
            case 1:
                $sidebar->dialog_1 = $content;
                break;
            case 2:
                $sidebar->dialog_2 = $content;
                break;
            case 3:
                $sidebar->dialog_3 = $content;
                break;
        }

        $sidebar->save();

        return response()->json(['success' => true]);
    }
    public function updateFiles(Request $request)
    {
        $sidebar = Sidebar::first(); // Fetch the only row

        // Define the destination path
        $destinationPath = public_path('/user/uploads/sidebar');

        // Handle the main image upload
        if ($request->hasFile('main_image')) {
            $image = $request->file('main_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); // Unique image name
            $image->move($destinationPath, $imageName); // Move the image to the defined directory
            $sidebar->main_image = '/user/uploads/sidebar/' . $imageName; // Store the relative path in the database
        }

        // Function to handle SVG conversion and storage
        function handleSvgUpload($request, $key, &$sidebar)
        {
            if ($request->hasFile($key)) {
                $svgFile = $request->file($key);
                $svgContent = file_get_contents($svgFile->getRealPath()); // Read the SVG file content
                
                // Modify the SVG content by adding class and fill properties
                $modifiedSvgContent = str_replace(
                    '<svg', 
                    '<svg class="w-6 block" fill="#e95d2a" ', // Add class and fill property
                    $svgContent
                );
    
                // Store the modified SVG content in the database
                $sidebar->$key = $modifiedSvgContent; 
            }
        }

        // Handle SVG uploads
        handleSvgUpload($request, 'svg_1', $sidebar);
        handleSvgUpload($request, 'svg_2', $sidebar);
        handleSvgUpload($request, 'svg_3', $sidebar);

        // Save the updated record
        $sidebar->save();

        return response()->json(['success' => true]);
    }


}
