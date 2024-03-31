<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentReplyAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $game;

    public $logoPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($game, $logoPath)
    {
        $this->game = $game;
        $this->logoPath = $logoPath;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Someone Replied to Your Comment!',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.comment-reply-added',
            text: 'emails.comment-reply-added-plain-text'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
