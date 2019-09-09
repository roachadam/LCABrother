<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BugReport extends Mailable
{
    use Queueable, SerializesModels;

    public $description;
    public $url;
    public $user_id;
    public $org_id;
    public $action;

    public function __construct($attributes)
    {
        $this->description = $attributes['description'];
        $this->url = $attributes['url'];
        $this->user_id = $attributes['user_id'];
        $this->org_id = $attributes['org_id'];
        $this->action = $attributes['action'];

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.BugReportToDevs');
    }
}
