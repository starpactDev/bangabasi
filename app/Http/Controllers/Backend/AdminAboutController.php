<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAboutController extends Controller
{
    public function index(){
        $path = storage_path('app/about.json'); // Use the correct path

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $about = json_decode($content, true);
        
            if ($about === null) {
                $about = []; // Handle decoding errors
            }
        } else {
            $about = []; // Handle missing file
        }

        return view('admin.pages.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        //dd($request->all());
        // Validate the incoming data
        $validatedData = $request->validate([
            'parentKey' => 'required|string', // Required parent key
            'image' => 'nullable|file|image|max:2048', // Optional image validation
        ]);

        $parentKey = $validatedData['parentKey']; // Main section key (e.g., "breadcrumb", "founder")
        $updatedData = []; // Array to hold updated key-value pairs

        // Process all request data except 'parentKey' and 'image'
        foreach ($request->all() as $key => $value) {
            if ($key === 'parentKey' || $key === 'image' || $key === '_token') {
                continue;
            }
            $updatedData[$key] = $value;

            // Check if the key belongs to the parentKey section
            if (strpos($key, $parentKey) === 0) {
                $childKey = substr($key, strlen($parentKey) + 1); // Extract child key
                $updatedData[$childKey] = $value; // Add child key-value pair
            }
        }
        //dd($updatedData);

        // Handle optional image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Replace spaces in image file name with underscores
            $imageName = preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $destinationPath = public_path('user/uploads/about');

            // Move image to destination folder
            $image->move($destinationPath, $imageName);

            $updatedData['image'] = $imageName; // Add image name to the update array
        }

        // Load existing JSON data
        $jsonFilePath = storage_path('app/about.json');
        if (!file_exists($jsonFilePath)) {
            return response()->json(['error' => 'JSON file not found'], 404);
        }

        $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        if (!$jsonData) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }

        // Check and update the relevant section
        if (isset($jsonData[$parentKey])) {
            // Merge the updated data with the existing section
            $jsonData[$parentKey] = array_merge($jsonData[$parentKey], $updatedData);

            // Save the updated JSON back to the file
            file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));

            return response()->json([
                'success' => true,
                'message' => 'About section updated successfully',
                'data' => $updatedData
            ]);
        } else {
            return response()->json(['error' => 'Parent key not found'], 404);
        }
    }
    public function updateStories(Request $request)
    {
        $validatedData = $request->validate([
            'parentKey' => 'required|string|in:stories',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|image|max:2048', // Validate each image
        ]);
    
        $parentKey = $validatedData['parentKey'];
        $jsonFilePath = storage_path('app/about.json');
    
        if (!file_exists($jsonFilePath)) {
            return response()->json(['error' => 'JSON file not found'], 404);
        }
    
        $jsonData = json_decode(file_get_contents($jsonFilePath), true);
    
        if (!isset($jsonData[$parentKey])) {
            return response()->json(['error' => 'Stories section not found'], 404);
        }
    
        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                // Save the uploaded image
                $imageName = preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $destinationPath = public_path('user/uploads/about');
                $image->move($destinationPath, $imageName);
    
                // Update JSON data with the new image
                $jsonData[$parentKey][$key] = $imageName;
            }
        }
    
        // Save the updated JSON back to the file
        file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));
    
        return response()->json([
            'success' => true,
            'message' => 'About section updated successfully'
        ]);
    }
    
}