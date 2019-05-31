<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JoinOrgInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $org;

    public function __construct($org)
    {
        $this->org = $org;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.Join-Org-Invite');
    }
}
