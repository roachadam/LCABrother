<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
Use App\User;
use App\Organization;
class MemberRemoved extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $org;
    public function __construct($user, $org)
    {
        $this->user = $user;
        $this->org = $org;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.Member-Removed');
    }
}
