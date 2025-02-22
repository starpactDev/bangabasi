<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminBrandController extends Controller
{
    public function index()
    {

        // Update the total product count for the brand

      
        $brands = Brand::all();
        return view('admin.pages.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands,brand_name',
            'brand_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/user/uploads/brand/images');
            $image->move($destinationPath, $imageName);

            Brand::create([
                'brand_name' => $request->brand_name,
                'brand_image' => $imageName,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Brand added successfully!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to upload brand image!',
        ], 400);
    }
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands,brand_name,' . $id,
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/user/uploads/brand/images');
            $image->move($destinationPath, $imageName);

            // Delete old image if exists
            if ($brand->brand_image && file_exists(public_path('/user/uploads/brand/images/' . $brand->brand_image))) {
                unlink(public_path('/user/uploads/brand/images/' . $brand->brand_image));
            }

            $brand->brand_image = $imageName;
        }

        $brand->brand_name = $request->brand_name;
        $brand->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand updated successfully!',
        ]);
    }
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand deleted successfully!',
        ]);
    }
}
