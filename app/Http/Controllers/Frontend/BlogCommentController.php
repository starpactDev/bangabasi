<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BlogComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = auth()->user();
    
        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to post a comment.');
        }
    
        if ($user->usertype !== 'user') {
            return redirect()->back()->with('error', 'Only regular users are allowed to post comments.');
        }
    
        $request->validate([
            'comment' => 'required|string',
        ]);
    
        BlogComment::create([
            'blog_id' => $id,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);
    
        return redirect()->back()->with('success', 'Comment posted successfully!');
    }
    
    

}
