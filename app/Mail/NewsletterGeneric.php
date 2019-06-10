<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterGeneric extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $newsletter;
    public function __construct(Newsletter $newsletter, $body)
    {
        $this->newsletter = $newsletter;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->newsletter->name)->markdown('emails.Newsletter-Generic');
    }
}
