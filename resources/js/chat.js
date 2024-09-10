import Toastify from "toastify-js";

document.addEventListener("DOMContentLoaded", () => {
    if (typeof window.Echo !== "undefined" && window.userId) {
        window.Echo.join(`chat.${window.userId}`).listen(
            ".ChatEvent",
            (event) => {
                console.log("New Message", event);

                Toastify({
                    text: `New Message From: ${event.user.name}`,
                    duration: 5000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "#333",
                    },
                    stopOnFocus: true,
                }).showToast();
            }
        );
    } else {
        console.error("Echo یا userId تعریف نشده‌اند!");
    }
});
