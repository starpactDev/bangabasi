<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminHomepageController extends Controller
{
    public function index(){
            $path = storage_path('app/data.json'); // Use the correct path

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $homepage = json_decode($content, true);
        
            if ($homepage === null) {
                $homepage = []; // Handle decoding errors
            }
        } else {
            $homepage = []; // Handle missing file
        }
        
        return view('admin.pages.homepage.main', compact('homepage'));
    }
    public function getSectionData(string $section)
    {
        try {
            // Load the JSON file content
            $filePath = storage_path('app/data.json');
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'Data file not found.'], 404);
            }

            $homepageData = json_decode(file_get_contents($filePath), true);
            if (!array_key_exists($section, $homepageData)) {
                return response()->json(['error' => 'Section not found.'], 404);
            }

            // Return the requested section's data
            return response()->json($homepageData[$section]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching section data.'], 500);
        }
    }
    public function updateSection(Request $request)
    {
        
        // Validate only parentKey and image
        $validatedData = $request->validate([
            'parentKey' => 'required|string',
            'image' => 'nullable|file|image|max:2048', // Validate the image if present
        ]);

        // Get the parent key from the request
        $parentKey = $validatedData['parentKey'];
        
        // Initialize an empty array for storing the updated data
        $updatedData = [];

        // Loop through all the incoming request data to dynamically handle each field
        foreach ($request->all() as $key => $value) {
            if ($key === 'parentKey' || $key === 'image') {
                continue; // Skip parentKey and image, they are handled separately
            }

            // Check if the key starts with the parentKey (i.e., it's a valid field for this section)
            if (strpos($key, $parentKey) === 0) {
                // Extract the actual field name (e.g., 'head', 'description', etc.)
                $childKey = substr($key, strlen($parentKey) + 1); // Strip the parentKey part from the field name
                $updatedData[$childKey] = $value; // Add this to the update array
            }
        }
        

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');
            
            // Ensure the image name does not contain spaces (replace with underscores)
            $imageName = preg_replace('/\s+/', '_', $image->getClientOriginalName());
            
            $destinationPath = public_path('user/uploads/homepage');
    
            // Move the image to the specified directory
            $image->move($destinationPath, $imageName);
            
            // Store only the image name in the JSON data
            $updatedData['image'] = $imageName;
        }

            // Fetch the current JSON data
        $jsonFilePath = storage_path('app/data.json');
        
        if (!file_exists($jsonFilePath)) {
            return response()->json(['error' => 'JSON file not found'], 404);
        }
        
        $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        
        if (!$jsonData) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }

        // Update the relevant section in the JSON data
        if (isset($jsonData[$parentKey])) {
            // Merge the updated data into the existing section
            $jsonData[$parentKey] = array_merge($jsonData[$parentKey], $updatedData);

            // Save the updated JSON back to the file
            file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Section updated successfully',
                'data' => $updatedData
            ]);
        } else {
            return response()->json(['error' => 'Parent key not found'], 404);
        }
    }

}
