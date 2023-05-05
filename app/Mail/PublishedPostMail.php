<?php

namespace App\Mail;

use App\Models\Post;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublishedPostMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope( 
            subject: 'Published Post from ' . env('APP_NAME')
         );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $post = $this->post;
        $published_text = $post->is_published ? 'Il post è stato pubblicato' : 'Il post è stato ritirato';
        $button_url = env('APP_FRONTEND_URL') . '/posts/' . $post->slug;

        return new Content(
            markdown: 'mails.posts.published',
            with: compact('post', 'published_text', 'button_url')
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