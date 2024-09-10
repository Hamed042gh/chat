import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    authEndpoint: "/broadcasting/auth",
    broadcaster: "pusher",
    key: "5a5d2cb9f6c42bfd83d9",
    cluster: "us2",
    forceTLS: true,
});

const userId = window.userId;

import "./chat";
import "./online-users";
