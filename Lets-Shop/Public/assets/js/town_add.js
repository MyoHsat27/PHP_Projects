const addTownBtn = document.getElementById("add-town-btn");
const addNewTownBtn = document.getElementById("add-new-town-btn");
const townContainer = document.getElementById("town-container");
const townForms = document.querySelectorAll(".town-form");
let townInputListId = townForms.length + 1;
let townId = townForms.length + 1;

if (addTownBtn) {
    addTownBtn.addEventListener("click", (e) => {
        e.preventDefault();

        const newTownForm = document.createElement("div");
        newTownForm.classList.add("state-form-container", "d-flex");
        newTownForm.id = `town-form-${townInputListId}`;
        newTownForm.innerHTML = `
            <div class="state-form-no">${townInputListId}</div>
            <label class="state-input">
                <input type="text" class="form-control me-3" name="townName[]" placeholder="Town Name">
            </label>
            <label class="state-input">
                <input type="number" pattern="[0-9]" class="form-control me-3" name="townPrice[]" placeholder="Price">
            </label>
            <button type="button" class="state-delete-btn mt-0"><i class="bi bi-trash3"></i></button>
        `;

        const deleteBtn = newTownForm.querySelector(".state-delete-btn");
        deleteBtn.addEventListener("click", () => {
            newTownForm.remove();
            renumberTownForms();
        });

        townContainer.appendChild(newTownForm);
        townInputListId++;
    });
} else {

}

if (addNewTownBtn) {
    addNewTownBtn.addEventListener("click", (e) => {
        e.preventDefault();

        const newTownForm = document.createElement("div");
        newTownForm.classList.add("state-form-container", "d-flex");
        newTownForm.id = `town-form-${townInputListId}`;
        newTownForm.innerHTML = `
<input type="text" name="townNewId[]" hidden value="${townId}">
            <div class="state-form-no">${townInputListId}</div>
            <label class="state-input">
                <input type="text" class="form-control me-3" name="townNewName[]" placeholder="Town Name">
            </label>
            <label class="state-input">
                <input type="number" pattern="[0-9]" class="form-control me-3" name="townNewPrice[]" placeholder="Price">
            </label>
            <button type="button" class="state-delete-btn mt-0"><i class="bi bi-trash3"></i></button>
        `;

        const deleteBtn = newTownForm.querySelector(".state-delete-btn");
        deleteBtn.addEventListener("click", () => {
            newTownForm.remove();
            renumberTownForms();
        });

        townContainer.appendChild(newTownForm);
        townInputListId++;
        townId++;
    });
}

function renumberTownForms() {
    const townForms = document.querySelectorAll(".state-form-container");
    townInputListId = 1; // Reset townInputListId to 1
    townForms.forEach((form, index) => {
        const formNo = form.querySelector(".state-form-no");
        formNo.textContent = `${index + 1}`;
        form.id = `town-form-${index + 1}`;
        townInputListId = index + 2; // Update townInputListId to highest form number
    });
}

deleteBtn()

function deleteBtn () {
    let deleteButtons = document.getElementsByClassName("state-delete-btn");
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener("click", () => {
            console.log(deleteButtons[i].parentNode);
            deleteButtons[i].parentNode.remove();
            renumberTownForms();
        });
    }
}