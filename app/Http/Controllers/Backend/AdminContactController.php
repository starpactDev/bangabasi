<?php

namespace App\Http\Controllers\Backend;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Mail\UserQueryResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Providers\AppServiceProvider;

class AdminContactController extends Controller
{
    public function index(){
        //$message = Message::paginate(6); // 6 messages per page
        $message = Message::orderBy('responsed', 'asc')->orderBy('created_at', 'desc')->paginate(6);

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
        

        // Send the email response
        Mail::to($message->email)->send(
            new UserQueryResponse(
                $message->name, // Username
                'Response to Your Query', // Subject
                $message->message, // User Query message
                $request->input('replyMessage') // Reply message
            )
        );

        $message->responsed = true;
        $message->save();

        // Update the unread message count in the cache after responding
        AppServiceProvider::updateUnreadMessageCache();

        return redirect()->route('admin.contact')->with('success', 'Response sent to ' . $message->name . ' (' . $message->email . ') .');
    }
}