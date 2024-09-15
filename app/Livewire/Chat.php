<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\ChatEvent;
use App\Events\UserStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class Chat extends Component
{
    public $newMessage;
    public $messages = [];
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->messages = $this->fetchMessagesFromRedis();

        if ($this->user) {
            $this->updateOnlineStatus('online');
        }
    }

    public function destroy()
    {
        if ($this->user) {
            $this->updateOnlineStatus('offline');
        }
    }

    public function handleMessageSubmission()
    {
        $validateNewMessage = $this->validateNewMessage();

        $this->pushMessageToRedis($validateNewMessage);
        broadcast(new ChatEvent($this->user, $this->newMessage))->toOthers();

        $this->newMessage = '';
    }

    public function render()
    {
        $this->messages = $this->fetchMessagesFromRedis();
        return view('livewire.chat', ['messages' => $this->messages]);
    }

    public function validateNewMessage()
    {
        return $this->validate([
            'newMessage' => 'required|max:100|string'
        ]);
    }

    public function pushMessageToRedis($validateMessage)
    {
        $chatKey = 'public_chat';

        Redis::multi()
            ->lpush($chatKey, json_encode([
                'body' => $validateMessage['newMessage'],
                'user' => $this->user->name
            ]))
            ->ltrim($chatKey, 0, 5)
            ->exec();
    }

    private function fetchMessagesFromRedis()
    {
        $chatKey = 'public_chat'; // کلید عمومی برای چت عمومی
        $messages = Redis::lrange($chatKey, 0, -1); // بازیابی تمام پیام‌ها
        return array_map(function ($message) {
            return json_decode($message);
        }, $messages);
    }
    
    private function updateOnlineStatus($status)
    {
        broadcast(new UserStatusUpdated($this->user, $status))->toOthers();
    }
}
