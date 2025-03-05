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

    public function deleteUser($id)
    {
        // Find the user by ID
        $user = User::find($id);
        
        if ($user) {
            // Delete the user
            $user->delete();
            // Optionally you can add a session flash message
            session()->flash('success', 'User, '.$user->firstname.' '.$user->lastname.' deleted successfully.');
        } else {
            // User not found
            session()->flash('error', 'User not found.');
        }
        
        // Redirect back to the user list page
        return redirect()->route('admin_userlist');
    }

}
