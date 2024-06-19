// Changing Town Option by State Selection
const townOptions = document.querySelectorAll(".town-option");
const townSelectPlaceHolder = document.querySelector(".town-select-placeholder");
const regionSelect = document.querySelector("#region");
const townSelect = document.querySelector("#township");

for (let i = 0; i < townOptions.length; i++) {
    console.log(townOptions[i].dataset.optionId  + " " + regionSelect.value)
    if (regionSelect.value === townOptions[i].dataset.optionId ) {
        townOptions[i].classList.remove("d-none");
    } else {
        townOptions[i].classList.add("d-none");
    }
}

regionSelect.addEventListener("change", () => {
    let noUpdate = true;
    for (let i = 0; i < townOptions.length; i++) {
        if (regionSelect.value === townOptions[i].dataset.optionId) {
            if (noUpdate) {
                townSelect.value = townOptions[i].value;
                noUpdate = false;
            }
            townOptions[i].classList.remove("d-none");
        } else {
            townOptions[i].classList.add("d-none");
        }
    }
})