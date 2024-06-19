let accountIcon = document.querySelector(".account-icon");
let accountInfo = document.querySelector(".account-info");
accountIcon.addEventListener("click", () => {
    if (!accountInfo.classList.contains("show")) {
        accountInfo.classList.add("show")
    } else {
        accountInfo.classList.remove("show")
    }
})