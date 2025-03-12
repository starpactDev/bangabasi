<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterUser;
use Illuminate\Http\Request;

class AdminNewsLetterController extends Controller
{
    public function index()
    {
        $newsletterUsers = NewsletterUser::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.pages.newsletter.index', compact('newsletterUsers'));
    }
}
