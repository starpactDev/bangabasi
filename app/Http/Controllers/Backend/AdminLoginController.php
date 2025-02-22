<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function admin_login_check(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->usertype == 'admin') {
            return redirect()->intended(route('admin_dashboard'))
                        ->with('success','You have successfully signed in');
            }
        }

        return redirect()->route('admin_login')->with('error','Login details are not valid');
    }
    public function admin_logout()
    {
        Auth::logout();
        return redirect()->route('admin_login')->with('success','You have been successfully logged out!');
    }
}
