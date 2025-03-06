<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminContacController extends Controller
{
    public function index(){
        $message = Message::all();
        
        return response()->json($message);
        dd($message);
        return view('backend.contact.index', compact('message'));
    }
}
