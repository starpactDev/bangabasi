<?php

namespace App\Http\Controllers\Backend;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Models\NewsletterUser;
use App\Http\Controllers\Controller;

class AdminNewsLetterController extends Controller
{
    public function index()
    {
        $newsletterUsers = NewsletterUser::orderBy('created_at', 'desc')->paginate(20);

        $newsLetters = Newsletter::orderBy('created_at', 'desc')->paginate(4);

        return view('admin.pages.newsletter.index', compact('newsletterUsers', 'newsLetters'));
    }
}
