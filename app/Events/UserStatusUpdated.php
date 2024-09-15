<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $status;

    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat-status' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'UserStatusUpdated';
    }

    public function broadcastWith()
    {

        return [
            'user' => $this->user,
            'status' => $this->status
        ];
    }
}
