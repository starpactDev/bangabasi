<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserQueryResponse extends Mailable
{
    use Queueable, SerializesModels;
    
    public $username;
    public $subject;
    public $userQuery;
    public $replyMessage;
    


    /**
     * Create a new message instance.
     */
    public function __construct($username, $subject, $userQuery, $replyMessage)
    {   
        $this->username = $username;
        $this->subject = $subject;
        $this->userQuery = $userQuery;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_query_response',
            with: [
                'username' => $this->username,
                'userQuery' => $this->userQuery,
                'replyMessage' => $this->replyMessage,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
