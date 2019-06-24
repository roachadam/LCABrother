<?php

namespace App\Mail;

use App\Academics;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcademicsSpecificStanding extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $academics;
    public function __construct($attributes, $academics)
    {
        $this->subject = $attributes['subject'];
        $this->body = $attributes['body'];
        $this->academics = $academics;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.academics.AcademicsSpecificStanding')
            ->subject($this->subject);
    }
}
