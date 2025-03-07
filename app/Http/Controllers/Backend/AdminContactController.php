<?php

namespace App\Http\Controllers\Backend;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\AppServiceProvider;

class AdminContactController extends Controller
{
    public function index(){
        //$message = Message::paginate(6); // 6 messages per page
        $message = Message::orderBy('responsed', 'asc')->orderBy('created_at', 'desc')->get();
        return view('admin.pages.contact.index', compact('message'));
    }

    // Show a specific message (optional)
    public function show($id)
    {
        // Find message by ID
        $message = Message::findOrFail($id);
        
        return view('backend.contact.show', compact('message'));
    }

    // Mark the message as responded and optionally store the reply
    public function respond(Request $request, $id)
    {
        $request->validate([
            'replyMessage' => 'required|string'
        ]);

        $message = Message::findOrFail($id);
        $message->responsed = true;

        // Optionally save the reply message
        // If you want to store the admin's reply, you can add a 'reply' field to the message
        // $message->reply = $request->input('replyMessage');
        
        $message->save();

        // Update the unread message count in the cache after responding
        AppServiceProvider::updateUnreadMessageCache();

        return redirect()->route('admin.contact')->with('success', 'Message marked as responded');
    }
}
