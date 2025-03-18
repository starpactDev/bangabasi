<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsLetterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageContent;
    public $unsubscribeLink;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $messageContent
     * @return void
     */
    public function __construct($subject, $messageContent, $unsubscribeLink)
    {
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->unsubscribeLink = $unsubscribeLink;

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter', // create a new blade view for the newsletter content
            with: [
                'messageContent' => $this->messageContent,
                'unsubscribeLink' => $this->unsubscribeLink,
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
