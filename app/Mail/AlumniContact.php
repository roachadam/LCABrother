<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlumniContact extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $org;
    public function __construct($org, $subject, $body)
    {
        $this->org = $org;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->org->name ." : " .$this->subject)->markdown('emails.Alumni-Contact');
    }
}
