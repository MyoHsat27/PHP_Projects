// Change Quantity
const quantityText = document.querySelector("#product-quantity");
const quantitySend = document.querySelector(".quantity-send");
const decreaseBtn = document.querySelector("#decrease");
const increaseBtn = document.querySelector("#increase");
let orderQuantity = Number(quantityText.textContent);
let stockQuantity = Number(quantityText.ariaValueMax);

function updateQuantity() {
    decreaseBtn.disabled = (orderQuantity === 1);
    increaseBtn.disabled = (orderQuantity === stockQuantity);
    quantityText.innerText = orderQuantity;
    quantitySend.value = orderQuantity;

}

decreaseBtn.addEventListener("click", () => {
    if (orderQuantity > 1) {
        orderQuantity -= 1;
    }
    updateQuantity();
});

increaseBtn.addEventListener("click", () => {
    if (orderQuantity < stockQuantity) {
        orderQuantity += 1;
    }
    updateQuantity();
});

function changeValueOnSelect (select, options) {
    for (let i = 0; i < options.length; i++) {
        if (select.value === options[i].dataset.optionId ) {
            options[i].classList.remove("d-none");
        } else {
            options[i].classList.add("d-none");
        }
    }
}

// Changing Town Option by Region Selection
const townOptions = document.querySelectorAll(".town-option");
const regionSelect = document.querySelector("#region");
const townSelect = document.querySelector("#township");

changeValueOnSelect(regionSelect, townOptions)

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
    changeValueOnSelect(townSelect, deliveryPrices)
})

// Changing Delivery Price by Town Selection
const deliveryPrices = document.querySelectorAll(".delivery-price");
changeValueOnSelect(townSelect, deliveryPrices)

townSelect.addEventListener("change", () => {
    changeValueOnSelect(townSelect, deliveryPrices)
})

// Display Buying Information Dialog
const buyNowBtn = document.querySelector("#buy-now-btn");