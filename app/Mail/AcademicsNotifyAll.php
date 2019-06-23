<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Academics;

class academicsNotifyAll extends Mailable
{
    use Queueable, SerializesModels;

    public $academics;

    public function __construct($academics)
    {
        $this->academics = $academics;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.academics.NotifyAll');
    }
}
