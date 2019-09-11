<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class BugReport extends Mailable
{
    use Queueable, SerializesModels;

    public $description;
    public $url;
    public $userName;
    public $org_id;
    public $action;

    public function __construct($attributes)
    {
        $this->description = $attributes['description'];
        $this->url = $attributes['url'];
        $this->userName = User::find($attributes['org_id'])->name;
        $this->action = $attributes['action'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Bug Report')
            ->markdown('emails.BugReportToDevs');
    }
}
