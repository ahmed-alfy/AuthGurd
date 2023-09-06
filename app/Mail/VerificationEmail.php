<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;


    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user= $user;



    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $guard = request()->route()->parameter('guard');
        return new Content(
            view: 'mail',
            with:[
                'name' => $this->user->name,
                // 'link' => env('APP_URL')."?email=".$this->user->email,
                'link' => env('APP_URL')."/api/auth/".$guard."/verify"."/".$this->user->email,
                // 'link' => Route('verify',[$this->user->email]),
            ]
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
