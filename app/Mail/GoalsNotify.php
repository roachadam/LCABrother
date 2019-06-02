<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Goals;
use phpDocumentor\Reflection\Types\String_;

class GoalsNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $goalName;
    public $target;
    public $actual;

    public function __construct(User $user,$goalName, $actual, $target)
    {
        $this->user = $user;
        $this->goalName = $goalName;
        $this->target = $target;
        $this->actual = $actual;
    }


    public function build()
    {
        return $this->markdown('emails.Goals-Notification');
    }
}
