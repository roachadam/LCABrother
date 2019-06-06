<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $senderName;
    public $senderEmail;
    public function __construct($attributes)
    {
        $this->subject = $attributes['subject'];
        $this->body = $attributes['body'];
        $this->senderName = $attributes['name'];
        $this->senderEmail = $attributes['email'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('LCABrother Contact: "'.$this->subject .'"')->markdown('emails.Contact-Us');
    }
}
