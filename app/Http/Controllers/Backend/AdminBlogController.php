<?php

namespace App\Http\Controllers\Backend;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.pages.blogs.index', compact('blogs'));
    }

    public function add()
    {
        return view('admin.pages.blogs.create');
    }

    public function create(Request $request)
    {
        // Validate the request data
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs',
            'author' => 'required|string|max:100',
            'tags' => 'required|string|max:300',
            'blogs_description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Handle image upload
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('user/uploads/blogs'), $imageName);
            }

            $slug = Str::slug($request->input('title'));
            // Create new blog
            $blog = Blog::create([
                'blog_head' => $request->input('title'),
                'slug' => $slug,
                'author_name' => $request->input('author'),
                'tags' =>$request->input('tags'),
                'blog_description' => $request->input('blogs_description'),
                'image' => $imageName,
                'status' => 'draft',
                'view_count' => 0,
                'published_at' => null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog created successfully',
                'data' => $blog
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating blog: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating blog: ' . $e->getMessage()
            ], 500);
        }
    }

    //publish a blog for the first time
    public function publish($id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            $blog->status = 'published';
            $blog->published_at = now(); // Set the current date and time as the published time
            $blog->save();
        }
    
        return redirect()->back()->with('status', 'Blog published successfully!');
    }

    // down or publish a blog
    public function toggleStatus($id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            // Toggle the status
            $blog->status = $blog->status === 'published' ? 'draft' : 'published';

            // Update the published_at field only if it is null
            if ($blog->status === 'published' && is_null($blog->published_at)) {
                $blog->published_at = now(); 
            }

            $blog->save();
        }

        return redirect()->back()->with('status', 'Blog status updated successfully!');
    }
    

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.pages.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $id, // Allow unique slug but exclude current blog
            'author' => 'required|string|max:100',
            'blogs_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Image is optional for update
        ]);

        try {
            // Find the existing blog
            $blog = Blog::findOrFail($id);

            // Handle image upload if a new image is provided
            $imageName = $blog->image; // Keep the existing image by default
            if ($request->hasFile('image')) {
                // Delete the old image if necessary (optional)
                if ($blog->image) {
                    $oldImagePath = public_path($blog->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete the old image file
                    }
                }

                // Upload the new image
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension; // Generate a new unique image name
                $image->move(public_path('user/uploads/blogs'), $imageName);
            }

            // Sanitize the blog description
            $cleaned_description = strip_tags($validated['blogs_description'], '<p><a><b><strong><i><ul><ol><li><br><img>'); // Allow specific tags

            // Update the blog entry
            $blog->update([
                'blog_head' => $validated['title'],
                'slug' => $validated['slug'],
                'author_name' => $validated['author'],
                'blog_description' => $cleaned_description,
                'image' => $imageName, // Store only the image name
                // Status and view_count can be updated if needed
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog updated successfully',
                'data' => $blog
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating blog: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating blog: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Find the blog by ID
            $blog = Blog::findOrFail($id);

            // Delete the image if it exists
            if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
                unlink(public_path('uploads/blogs/' . $blog->image));
            }

            // Delete the blog entry
            $blog->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting blog: ' . $e->getMessage(), [
                'blog_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting blog: ' . $e->getMessage(),
            ], 500);
        }
    }



}
