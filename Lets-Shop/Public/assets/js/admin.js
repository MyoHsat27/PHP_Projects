// Session Script
let sessionContainer = document.querySelector(".session-container");
if (sessionContainer) {
    setTimeout(() => {
        sessionContainer.style.transform = `translateY(-${sessionContainer.clientHeight}px)`
    },5000);
}