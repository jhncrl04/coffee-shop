const cards = document.querySelectorAll(".menu-wrapper .card .product");
const cart = document.querySelector(".cart .orders");

if (cards) {
  cards.forEach((card) => {
    card.addEventListener("click", async () => {
      const productName = card.querySelector(".product-name").innerHTML;

      show_cart_modal(addToCartModal, productName);
    });
  });
}

const customerName = document.querySelector("form #customer-name");
const cashReceived = document.getElementById("cash-received");
const posTotalPrice = document.getElementById("total-price");

let totalPriceNum;

if (posTotalPrice) {
  totalPriceNum = posTotalPrice.value;
  totalPriceNum = parseFloat(totalPriceNum);
}

const change = document.getElementById("change");

if (cashReceived) {
  cashReceived.addEventListener("change", () => {
    const cashReceivedValue = parseFloat(cashReceived.value);

    if (!isNaN(cashReceivedValue) && totalPriceNum <= cashReceivedValue) {
      const changeNum = cashReceivedValue - totalPriceNum;

      change.value = `${changeNum.toFixed(2)}`;
    } else {
      alert("Invalid Amount");

      cashReceived.value = "";
      change.value = "";
    }
  });
}

const orderItems = document.querySelectorAll(".orders .order-item");
const proceedPaymentBtn = document.getElementById("proceedPaymentBtn");
if (proceedPaymentBtn) {
  if (orderItems.length === 0) {
    proceedPaymentBtn.addEventListener("click", (e) => {
      e.preventDefault();

      alert("Add order to checkout");
    });
  }
}

const posForm = document.getElementById("posForm");
const receiptModal = document.getElementById("receiptModal");
if (receiptModal) {
  const posCheckoutBtn = receiptModal.querySelector("#confirmBtn");

  posForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const receiptName = receiptModal.querySelector(".customer-name");
    receiptName.innerHTML = customerName.value;

    const receiptDate = receiptModal.querySelector(".order-date");
    const today = new Date();
    const formattedDate = `${String(today.getMonth() + 1).padStart(
      2,
      "0"
    )}/${String(today.getDate()).padStart(2, "0")}/${today.getFullYear()}`;
    receiptDate.innerHTML = formattedDate;

    const receiptChange = receiptModal.querySelector(".change");
    receiptChange.innerHTML = `Change: ${change.value}`;

    receiptModal.show();

    posCheckoutBtn.addEventListener("click", () => {
      posForm.submit();
    });
  });
}

function closeModal(modal) {
  modal.close();
}
