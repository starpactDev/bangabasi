<?php

namespace App\Http\Controllers\Backend;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminCollectionController extends Controller
{

    public function index()
    {

        // Update the total product count for the brand


        $collections = Collection::all();
        return view('admin.pages.collection.index', compact('collections'));
    }

    public function destroy($id)
    {
        $brand = Collection::findOrFail($id);
        $brand->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Collection deleted successfully!',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collection_name' => 'required|unique:collections,collection_name',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('collection_name')) {


            Collection::create([
                'collection_name' => $request->collection_name,

            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Collection added successfully!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to upload Collection!',
        ], 400);
    }


    public function update(Request $request, $id)
    {
        $brand = Collection::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'collection_name' => 'required|unique:collections,collection_name,' . $id,

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }



        $brand->collection_name = $request->collection_name;
        $brand->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Collection updated successfully!',
        ]);
    }
}
