<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        // Fetch all users
        $users = User::where('usertype', 'user')->get();
        return view('admin.pages.userlist', compact('users'));
    }
}
