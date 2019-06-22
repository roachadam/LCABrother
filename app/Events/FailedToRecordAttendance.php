<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Auth\User;

class FailedToRecordAttendance
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
