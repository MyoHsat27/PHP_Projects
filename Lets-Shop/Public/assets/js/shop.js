let searchContainer = document.querySelector(".search");
let searchInput = document.querySelector(".search-input");

searchInput.addEventListener("focusin", () => {
   searchContainer.classList.add("search-onfocus");
})

searchInput.addEventListener(("focusout"),() => {
   searchContainer.classList.remove("search-onfocus");
})