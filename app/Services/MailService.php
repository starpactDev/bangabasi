<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class MailService
{
    /**
     * Send a test email.
     *
     * @param string $toEmail
     * @return void
     */
    public function sendTestEmail($toEmail)
    {
        Mail::to($toEmail)->send(new TestEmail());
    }
}