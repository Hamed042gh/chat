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

window.Echo.channel("chat").listen(".ChatEvent", (e) => {
    const messageContainer = document.getElementById("messages");
    const newMessage = document.createElement("div");
    newMessage.className = "message p-2 bg-white rounded-lg shadow mb-2";
    newMessage.textContent = `${e.user.name}: ${e.message}`;
    messageContainer.appendChild(newMessage);
    messageContainer.scrollTop = messageContainer.scrollHeight;
});

// اتصال به کانال `chat-status`
window.Echo.join("chat-status")
    .here((users) => {
        users.forEach((user) => {
            addOnlineUser(user);
        });
    })
    .joining((user) => {
        addOnlineUser(user);
    })
    .leaving((user) => {
        removeOnlineUser(user);
    })
    .listen(".UserStatusUpdated", (e) => {
        updateOnlineUsers(e.user, e.status);
    });

function addOnlineUser(user) {
    const userList = document.getElementById("online-users");

    if (!document.getElementById(user.id + "-status")) {
        const userItem = document.createElement("li");
        userItem.id = user.id + "-status";
        userItem.className = "online-user";
        userItem.textContent = user.name;
        userList.appendChild(userItem);
    }
}

function removeOnlineUser(user) {
    const userElement = document.getElementById(user.id + "-status");
    if (userElement) {
        userElement.remove();
    }
}

function updateOnlineUsers(user, status) {
    const userElement = document.getElementById(user.id + "-status");
    if (status === "online") {
        if (!userElement) {
            addOnlineUser(user);
        }
    } else if (status === "offline") {
        if (userElement) {
            removeOnlineUser(user);
        }
    }
}
