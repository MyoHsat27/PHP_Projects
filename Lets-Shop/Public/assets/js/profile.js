const profileContainer = document.querySelector(".profile-main-container");
const title = document.querySelector(".content-head")
const editContainer = document.querySelector(".profile-edit-container");
const editBtn = document.querySelector(".profile-edit-btn");
const closeBtn = document.querySelector(".close-add-address");

editBtn.addEventListener("click", () => {
    title.innerText = "Edit Profile"
    editContainer.classList.remove("d-none")
    profileContainer.classList.add("d-none");
})

closeBtn.addEventListener("click", () => {
    title.innerText = "My profile"
    editContainer.classList.add("d-none")
    profileContainer.classList.remove("d-none");
})