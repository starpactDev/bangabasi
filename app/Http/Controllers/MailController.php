<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class MailController extends Controller
{
        public function sendTestEmail()
        {
            // Send email
            Mail::to('developers.starpact@gmail.com')->send(new TestEmail());
    
            return "Test email sent!";
        }

}
