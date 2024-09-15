document.addEventListener("DOMContentLoaded", () => {
    if (typeof window.Echo !== "undefined" && window.userId) {
        window.Echo.join(`chat.${window.userId}`).listen(
            ".ChatEvent",
            (event) => {
                console.log("New Message", event);
            }
        );
    } else {
        console.error("not define");
    }
});
