<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 'published')->latest()->paginate(5);
        return view('blogs', compact('blogs'));
    }

    public function view($id = null, $slug = null)
    {
        //retrive the blog with the id or slug passed by the url parameter

        if($id){
            $mainBlog = Blog::where('id', $id)->first();
        }
        elseif($slug){
            $mainBlog = Blog::where('slug', $slug)->first();
        }
        if (!$mainBlog) {
            abort(404);
        }
        if ($mainBlog->status !== 'published') {
            abort(404); // Triggers the default 404 page
        }

        //Recomanded Blogs

        // Step 1: Get the tags of the base blog and convert CSV to an array
        $baseBlog = Blog::find($mainBlog->id);
        if (!$baseBlog) {
            return response()->json(['error' => 'Blog not found'], 404);
        }

        $baseTags = explode(',', $baseBlog->tags);

        // Step 2: Retrieve all other blogs and calculate tag matches
        $relatedBlogs = Blog::where('id', '!=', $id)
            ->get()
            ->map(function ($blog) use ($baseTags) {
                $blogTags = explode(',', $blog->tags);
                $commonTagsCount = count(array_intersect($baseTags, $blogTags));
                $blog->tag_match_count = $commonTagsCount; // Store match count for sorting
                return $blog;
            })
            // Step 3: Filter blogs with no matching tags, sort by match count, and limit to top 10
            ->filter(fn($blog) => $blog->tag_match_count > 0)
            ->sortByDesc('tag_match_count')
            ->take(10)
            ->values(); // Reindex the collection

        return view('blog', compact('mainBlog', 'relatedBlogs'));
    }

    public function getRelatedBlogs($baseBlogId)
    {
        // Step 1: Get the tags of the base blog and convert CSV to an array
        $baseBlog = Blog::find($baseBlogId);
        if (!$baseBlog) {
            return response()->json(['error' => 'Blog not found'], 404);
        }

        $baseTags = explode(',', $baseBlog->tags);

        // Step 2: Retrieve all other blogs and calculate tag matches
        $relatedBlogs = Blog::where('id', '!=', $baseBlogId)
            ->get()
            ->map(function ($blog) use ($baseTags) {
                $blogTags = explode(',', $blog->tags);
                $commonTagsCount = count(array_intersect($baseTags, $blogTags));
                $blog->tag_match_count = $commonTagsCount; // Store match count for sorting
                return $blog;
            })
            // Step 3: Filter blogs with no matching tags, sort by match count, and limit to top 10
            ->filter(fn($blog) => $blog->tag_match_count > 0)
            ->sortByDesc('tag_match_count')
            ->take(10)
            ->values(); // Reindex the collection

        return response()->json($relatedBlogs);
    }

    public function findBlogsWithSameTags($tagName)
    {
        // Trim the tag name to avoid issues with extra spaces
        $tagName = trim($tagName);
        
        // Query to find blogs that contain the same tag in the tags column
        $blogs = Blog::where('tags', 'LIKE', '%' . $tagName . '%')->paginate(5);

        return view('blogs', compact('blogs'));
        // Return the results (you can choose to return a view or JSON)
        return response()->json($blogs);
    }

    public function updateViewCount(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        
        if ($blog) {
            $blog->view_count += 1;
            $blog->save();

            return response()->json(['success' => true, 'view_count' => $blog->view_count]);
        }

        return response()->json(['success' => false], 404);
    }

    

}