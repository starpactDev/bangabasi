<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHeaderController extends Controller
{
    public function index(){
        $path = storage_path('app/head.json'); // Use the correct path

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $header = json_decode($content, true);
        
            if ($header === null) {
                $header = []; // Handle decoding errors
            }
        } else {
            $header = []; // Handle missing file
        }
        return view('admin.pages.header.index', compact('header'));
    }


    public function update(Request $request)
    {

        
        // Validate only parentKey and image
        $validatedData = $request->validate([
            'parentKey' => 'required|string',
            'image' => 'nullable|file|image|max:2048', // Validate the image if present
        ]); 

        // Get the parent key from the request
        $parentKey = $validatedData['parentKey'];
        $grandParentKey = explode('.', $parentKey)[0];
        $mainParentKey = explode('.', $parentKey)[1];
        //dd($parentKey);
        
        // Initialize an empty array for storing the updated data
        $updatedData = [];

        // Loop through all the incoming request data to dynamically handle each field
        foreach ($request->all() as $key => $value) {
            if ($key === 'parentKey' || $key === 'image') {
                continue; // Skip parentKey and image, they are handled separately
            }

            // Check if the key starts with the parentKey (i.e., it's a valid field for this section)
            //dd($key, $parentKey, $grandParentKey, $mainParentKey);
            //dd(strpos($key, $grandParentKey) === 0);
            if (strpos($key, $grandParentKey) === 0) {
                
                // Split the key by delimiters such as '.' or '_'
                $parts = preg_split('/[\._]/', $key);
                // Find the part that you want as the childKey (last element in the array)
                $childKey = end($parts); // Gets the last element
                //dd($childKey);
                $updatedData[$childKey] = $value;
            }
        }
        

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');
            
            // Ensure the image name does not contain spaces (replace with underscores)
            $imageName = preg_replace('/\s+/', '_', $image->getClientOriginalName());
            
            $destinationPath = public_path('user/uploads/header');
    
            // Move the image to the specified directory
            $image->move($destinationPath, $imageName);
            
            // Store only the image name in the JSON data
            $updatedData['image'] = $imageName;
        }

            // Fetch the current JSON data
        $jsonFilePath = storage_path('app/head.json');
        
        if (!file_exists($jsonFilePath)) {
            return response()->json(['error' => 'JSON file not found'], 404);
        }
        
        $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        
        if (!$jsonData) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }

        //dd($parentKey);
        //dd($mainParentKey, $grandParentKey);
        //dd($updatedData);

        //dd($jsonData['secondRow'][$parentKey]);

        //dd($updatedData);
        // Update the relevant section in the JSON data
        if (isset($jsonData['secondRow'][$grandParentKey][$mainParentKey])) {
            //dd("yes");
            // Merge the updated data into the existing section
            $jsonData['secondRow'][$grandParentKey][$mainParentKey] = array_merge($jsonData['secondRow'][$grandParentKey][$mainParentKey], $updatedData);

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
