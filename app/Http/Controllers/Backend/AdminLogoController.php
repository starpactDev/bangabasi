<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;

class AdminLogoController extends Controller
{
    public function index(){
        $logos = Logo::all();
        //dd($logos);
        return view('admin.pages.logo.index', compact('logos'));
    }

    public function update(Request $request, $id)
    {
      
        // Validate the input
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048', // Validate image file
           
        ]);
       
        // Find the record by ID
        $logo = Logo::findOrFail($id);
       
        // Handle file upload if a new image is provided
        if ($request->hasFile('image')) {
            
            // Delete the old image if it exists
            if (file_exists(public_path('user/uploads/logos/' . $logo->image_path))) {
                unlink(public_path('user/uploads/logos/' . $logo->image_path));
            }

            // Store the new image
            $locationName = str_replace(' ', '_', strtolower($logo->location));
            $fileName = $locationName . '.'. $request->file('image')->getClientOriginalExtension();
           
            $request->file('image')->move(public_path('user/uploads/logos'), $fileName);
            $logo->image_path = $fileName;
        }

        // Update other fields
        
        
       
        $logo->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Logo updated successfully!');
    }

}
