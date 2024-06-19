// Change Quantity
const quantityText = document.querySelectorAll("#product-quantity");
const decreaseBtn = document.querySelectorAll("#decrease");
const increaseBtn = document.querySelectorAll("#increase");
let orderQuantity = [];
let stockQuantity = [];

function updateQuantity(i) {
    decreaseBtn[i].disabled = (orderQuantity[i] === 1);
    increaseBtn[i].disabled = (orderQuantity[i] === stockQuantity[i]);
    quantityText[i].innerText = orderQuantity[i];
}

for (let i = 0; i < quantityText.length; i++) {
    orderQuantity[i] = Number(quantityText[i].textContent);
    stockQuantity[i] = Number(quantityText[i].ariaValueMax);

    decreaseBtn[i].addEventListener("click", () => {
        if (orderQuantity[i] > 1) {
            orderQuantity[i] -= 1;
        }
        updateQuantity(i);
    });

    increaseBtn[i].addEventListener("click", () => {
        if (orderQuantity[i] < stockQuantity[i]) {
            orderQuantity[i] += 1;
            console.log(orderQuantity[i]);
        }
        updateQuantity(i);
    });
}