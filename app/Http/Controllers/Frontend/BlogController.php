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
        // Fetch the blog by ID or slug, eager load comments
        $mainBlog = Blog::with(['comments.user']) // Load comments and each comment's user
            ->when($id, fn($query) => $query->where('id', $id))
            ->when(!$id && $slug, fn($query) => $query->where('slug', $slug))
            ->first();

        // Abort if not found or unpublished
        if (!$mainBlog || $mainBlog->status !== 'published') {
            abort(404);
        }

        // Extract tags and find related blogs
        $baseTags = collect(explode(',', $mainBlog->tags))->map(fn($tag) => trim($tag))->filter();

        $relatedBlogs = Blog::where('id', '!=', $mainBlog->id)
                                ->where('status', 'published')
                                ->get()
                                ->map(function ($blog) use ($baseTags) {
                                    $blogTags = collect(explode(',', $blog->tags))->map(fn($tag) => trim($tag));
                                    $blog->tag_match_count = $baseTags->intersect($blogTags)->count();
                                    return $blog;
                                })
                                ->filter(fn($blog) => $blog->tag_match_count > 0)
                                ->sortByDesc('tag_match_count')
                                ->take(10)
                                ->values();

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