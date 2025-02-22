<?php

namespace App\Http\Controllers\Backend;

use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::with('review_images')->get();
        return view('admin.pages.review.index', compact('reviews'));
    }



    public function updateStatus(Request $request, $id)
{
    $review = Review::findOrFail($id);
    $review->status = $request->input('status');
    $review->save();

    return response()->json(['success' => true]);
}
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'rating' => 'required|integer|between:1,5',
            'review_message' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $review = new Review();
        $review->product_id = $request->product_id;
        $review->user_id = null; // Since user_id will be null
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->status = 'inactive'; // Status will be 'inactive'
        $review->review_message = $request->review_message;
        $review->save();

        // Handle uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique filename
                $fileName = uniqid() . '_' . $image->getClientOriginalName();

                // Move the file to the uploads directory
                $image->move(public_path('user/uploads/review_images'), $fileName);

                // Save the image path to the database
                $reviewImage = new ReviewImage();
                $reviewImage->review_id = $review->id;
                $reviewImage->image_path = $fileName;
                $reviewImage->save();
            }
        }

        return response()->json(['message' => 'Review submitted successfully.']);
    }
    public function destroy($id)
    {
        $data = Review::find($id);

        if (!$data) {

            return redirect()->back()->with('error', 'Review not found.');
        }

        try {

            $data->delete();
            return redirect()->back()->with('success', 'Review deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the review.');
        }
    }
}
