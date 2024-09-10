document.addEventListener("DOMContentLoaded", () => {
    if (typeof window.Echo !== "undefined" && window.userId) {
        window.Echo.join(`chat.${window.userId}`)
            .here((users) => {
                console.log("OnlineUsers", users);
                updateOnlineUsers(users);
            })
            .joining((user) => {
                console.log("UserJoined", user.name);
            })
            .leaving((user) => {
                console.log("UserLeft:", user.name);
            })
            .listen(".UserStatusUpdated", (event) => {
                console.log("User Status Updated", event);

                updateOnlineUsers(event.onlineUsers);
            });
    } else {
        console.error("Echo is not defined or userId is missing!");
    }
});

function updateOnlineUsers(users) {
    const onlineUsersElement = document.getElementById("online-users");
    onlineUsersElement.innerHTML = "";

    const userNames = Object.values(users);

    userNames.forEach((userName) => {
        const listItem = document.createElement("li");
        listItem.className = "text-gray-700";
        listItem.textContent = userName;
        onlineUsersElement.appendChild(listItem);
    });
}
