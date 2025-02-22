<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Topbar;
use App\Models\ViewSaleAboveDiscount;
use App\Models\Category;

class AdminTopbarController extends Controller
{

    public function index()
    {
        $topbars = Topbar::all();

        foreach($topbars as $topbar){
            if($topbar->layout_type == 'layout1'){
                $categories = [ $topbar->category_1_id, $topbar->category_2_id, $topbar->category_3_id, $topbar->category_4_id];
            }
        }

        
        $categories = array_map(function($categoryId) {
            return Category::find($categoryId);
        }, $categories);

        $saleDiscount = ViewSaleAboveDiscount::find(1);

        //dd($saleDiscount);

        //  dd($categories);
        return view('admin.pages.topbar.index', compact('topbars', 'categories', 'saleDiscount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layout_type' => 'required|in:layout1,layout2',
            'banner_image' => 'nullable|string',
            'overlay_text_heading' => 'nullable|string',
            'overlay_text_body' => 'nullable|string',
            'category_1_id' => 'nullable|exists:categories,id',
            'category_2_id' => 'nullable|exists:categories,id',
            'category_3_id' => 'nullable|exists:categories,id',
            'category_4_id' => 'nullable|exists:categories,id',
            'section_1_image' => 'nullable|string',
            'section_2_image' => 'nullable|string',
        ]);

        $topbar = Topbar::create($request->all());

        return response()->json(['data' => $topbar], 201);
    }

    public function update(Request $request, Topbar $topbar)
    {
        //dd($request->all());

        $request->validate([
            'field_id' => 'required|exists:topbars,id',
            'field_column' => 'required|string|in:layout_type,banner_image,overlay_text_heading,overlay_text_body,category_1_id,category_2_id,category_3_id,category_4_id,section_1_image,section_2_image',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048', 
            'text' => 'nullable|string|max:255',
            'category' => 'nullable|string'
        ]);

        // Find the topbar record
        $topbar = Topbar::findOrFail($request->field_id);

        if ($request->hasFile('image')){
            // Handle file upload logic here (e.g., move the file, get the file path)
            $newImageName = time() . '_' .  uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

            $filePath = $request->file('image')->move('user/uploads/banner', $newImageName);
            $topbar->{$request->field_column} = basename($filePath); // Update the specified column with the new filename
        } else if($request->category){
            
            $topbar->{$request->field_column} = $request->category;
        } else{
            // Update the specified column with the provided value (text or other types)
            $topbar->{$request->field_column} = $request->text;
        }

        $topbar->save();

        return response()->json(['message' => 'Update successful!', 'data' => $topbar], 200);
    }

    public function destroy(Topbar $topbar)
    {
        $topbar->delete();
    
        return response()->json(['message' => 'Topbar deleted successfully'], 200);
    }


    public function updateDiscount(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|exists:view_sale_above_discounts,id',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        // Find the sale discount by ID
        $saleDiscount = ViewSaleAboveDiscount::findOrFail($request->id);

        // Update the discount value
        $saleDiscount->discount = $request->discount;
        $saleDiscount->save();

        // Optionally, redirect with a success message
        return redirect()->back()->with('successDiscount', 'Discount updated successfully.');
    }

}
