<?php


use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat', function ($user) {
    return true;
});

Broadcast::channel('chat-status', function ($user) {

    return $user;
});
