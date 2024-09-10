<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\ChatEvent;
use App\Events\UserStatusUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;


class Chat extends Component
{

    public $newMessage;
    public $messages = [];
    public $user;
    public $onlineUsers = [];


    public function mount()
    {
        $this->user = Auth::user();


        $this->messages = $this->fetchMessagesFromRedis();

        $this->updateOnlineStatus('online');
    }


    public function handleMessageSubmission()
    {
        $validateNewMessage = $this->validateNewMessage();

        $this->pushMessageToRedis($validateNewMessage);
        broadcast(new ChatEvent($this->user, $this->newMessage));

        $this->newMessage = '';
    }


    public function render()
    {
        $this->messages = $this->fetchMessagesFromRedis();
        return view('livewire.chat', ['messages' => $this->messages, 'onlineUsers' => $this->onlineUsers]);
    }


    public function validateNewMessage()
    {
        return $this->validate([
            'newMessage' => 'required|max:100|string'
        ]);
    }


    public function pushMessageToRedis($validateMessage)
    {
        Redis::multi()
            ->lpush('chat', json_encode([
                'body' => $validateMessage['newMessage'],
                'user' => $this->user->name
            ]))
            ->ltrim('chat', 0, 10)
            ->exec();
    }


    private function fetchMessagesFromRedis()
    {
        $messages = Redis::lrange('chat', 0, -1);
        return array_map(function ($message) {
            return json_decode($message);
            Log::info($messages);
        }, $messages);
    }

    public function __destruct()
    {
        if ($this->user) {
            broadcast(new UserStatusUpdated($this->user, 'offline'));
        }
    }

    private function updateOnlineStatus($status)
    {
        $key = 'online_users';
        $users = Redis::hgetall($key);

        if ($status === 'online') {
            Redis::hset($key, $this->user->id, $this->user->name);
        } else {
            Redis::hdel($key, $this->user->id);
        }

        broadcast(new UserStatusUpdated($this->user, $status));
    }
}
