// Change Addresses
/* Shipping & Billing Information */
const displayDetailAddress = document.getElementById("display-detail-address")
const displayStateTown = document.getElementById("display-state-town")
const displayPhone = document.getElementById("display-phone")
const displayDeliPrice = document.getElementById("display-delivery-price")
const deliveryInfoId = document.getElementById("deliveryInfoId")

const addressChangeBtn = document.querySelectorAll("#addressChangeBtn");
const addressIds = document.querySelectorAll("#addressId");
const detailAddresses = document.querySelectorAll("#detailAddress");
const deliPrices = document.querySelectorAll("#deliPrice")
const locations = document.querySelectorAll("#location");
const phoneNums = document.querySelectorAll("#phoneNum");

const billPrice = parseInt(document.getElementById("billPrice").innerText);
const billTotalPrice = document.getElementById("billTotalPrice")
const postDeliPrice = document.getElementById("postDeliPrice")
const postTotalPrice = document.getElementById("postTotalPrice")


addressChangeBtn.forEach((btn, i) => {
    btn.addEventListener("click", (e) => {
        // Hide all address change buttons
        addressChangeBtn.forEach((btn) => {
            btn.classList.remove("d-none");
        });

        // Update displayed information
        deliveryInfoId.value = addressIds[i].innerText;
        displayDetailAddress.innerText = detailAddresses[i].innerText;
        displayStateTown.innerText = locations[i].innerText;
        displayPhone.innerText = phoneNums[i].innerText;

        // Calculate and update prices
        const deliPrice = parseInt(deliPrices[i].innerText);
        const totalPrice = billPrice + deliPrice;
        billTotalPrice.innerText = totalPrice;
        postDeliPrice.value = deliPrice;
        postTotalPrice.value = totalPrice;
        displayDeliPrice.innerText = "Ks " + deliPrice;

        // Hide the clicked address change button
        btn.classList.add("d-none");
    });
});

