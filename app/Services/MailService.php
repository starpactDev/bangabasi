<?php

namespace App\Services;

use App\Mail\TestEmail;
use App\Mail\NewsLetterEmail;
use App\Mail\UserQueryResponse;
use Illuminate\Support\Facades\Mail;

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

    /**
     * Send a newsletter email to the provided email addresses.
     *
     * @param array $toEmails
     * @param string $subject
     * @param string $messageContent
     * @return void
     */
    public function sendNewsletterEmail(array $toEmails, $subject, $messageContent, $unsubscribeLink)
    {
        foreach ($toEmails as $email) {
            Mail::to($email)->send(new NewsLetterEmail($subject, $messageContent, $unsubscribeLink));
        }
    }


    /**
     * Send a response to a user query.
     *
     * @param string $toEmail
     * @param string $subject
     * @param string $replyMessage
     * @return void
     */
    public function sendQueryResponse($toEmail, $username, $subject, $userQuery, $replyMessage)
    {
        Mail::to($toEmail)->send(new UserQueryResponse($username, $subject, $userQuery,  $replyMessage));
    }

        /**
     * Send a generic email.
     *
     * @param string $toEmail
     * @param string $subject
     * @param string $view
     * @param array $data
     * @return void
     */

}