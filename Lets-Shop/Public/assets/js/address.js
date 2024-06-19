// Changing Address Book and Add Address Interface
const addBtn = document.querySelector("#add-address");
const closeBtn = document.querySelector(".close-add-address");
const contentHead = document.querySelector(".content-head");
const addressTable = document.querySelector(".address-table");
const addAddress = document.querySelector(".add-address");

addBtn.addEventListener("click", () => {
    contentHead.innerHTML = "Add New Address";
    addressTable.classList.add("d-none");
    addAddress.classList.remove("d-none");
})
closeBtn.addEventListener("click", () => {
    contentHead.innerHTML = "Address Book"
    addressTable.classList.remove("d-none");
    addAddress.classList.add("d-none");
})

// Changing Town Option by State Selection
const townOptions = document.querySelectorAll(".town-option");
const townSelectPlaceHolder = document.querySelector(".town-select-placeholder");
const regionSelect = document.querySelector("#region");
const townSelect = document.querySelector("#township");

for (let i = 0; i < townOptions.length; i++) {
    townOptions[i].classList.add("d-none");
}
regionSelect.addEventListener("change", () => {
    townSelect.value = ""
    townSelectPlaceHolder.innerText = "Please choose your town";

    for (let i = 0; i < townOptions.length; i++) {
        if (regionSelect.value === townOptions[i].dataset.regionId) {
            townOptions[i].classList.remove("d-none");
        } else {
            townOptions[i].classList.add("d-none");
        }
    }
})
