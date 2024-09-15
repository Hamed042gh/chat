<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;


    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    //channel
    public function broadcastOn()
    {
        return new Channel('chat');
    }
    //event
    public function broadcastAs()
    {
        return 'ChatEvent';
    }
    public function broadcastWith()
    {
        return [
            'user' => $this->user,
            'message' => $this->message

        ];
    }
}
