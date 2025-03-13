<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Services\MailService;


class MailController extends Controller
{
    protected $mailService;

    /**
     * Constructor.
     *
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Send a test email.
     */
    public function sendTestEmail()
    {
        // Send email
        $toEmail = 'developers.starpact@gmail.com';
        $this->mailService->sendTestEmail($toEmail);
        
        return "Test email sent!";
    }

}
