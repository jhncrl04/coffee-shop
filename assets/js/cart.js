const items = document.querySelectorAll(".cd-cart-items li");
const totalPrice = document.querySelector("#cartTotalPrice");
const priceArray = [];

items.forEach((item) => {
  item.addEventListener("click", async (e) => {
    if (e.target.classList.contains("cd-item-remove")) {
      //remove on cart
      const itemRemoved = await removeItemFromCart([item.dataset.cart_id]);

      if (itemRemoved) {
        item.classList.add("removing");
        setTimeout(() => item.remove(), 300);
      } else {
        alert(
          "Cart item was not removed.\nWe are experiencing some internal errors.\nPlease try again later."
        );
      }
    } else {
      const itemPrice = item.dataset.price;
      item.classList.toggle("active");

      if (item.classList.contains("active")) {
        priceArray.push(itemPrice);
      } else {
        priceArray.pop(itemPrice);
      }

      updateCartTotalPrice();
    }
  });
});

function openCart() {
  document.getElementById("cd-cart").style.width = "450px";
  document.getElementById("backdrop").classList.toggle("open");

  document.querySelector("#cd-cart").style.right = "1rem";

  document.body.style.overflow = "hidden";
}

function closeCart() {
  document.getElementById("cd-cart").style.width = "0";
  document.getElementById("backdrop").classList.toggle("open");

  document.querySelector("#cd-cart").style.right = 0;

  document.body.style.overflow = "auto";

  items.forEach((item) => {
    const itemPrice = item.dataset.price;

    if (item.classList.contains("active")) {
      item.classList.toggle("active");
      priceArray.pop(itemPrice);
    }

    updateCartTotalPrice();
  });
}

function updateCartTotalPrice() {
  let priceFloat = 0.0;
  priceArray.forEach((price) => {
    priceFloat += parseFloat(price);
  });

  totalPrice.innerHTML = `P ${priceFloat.toFixed(2)}`;
}

async function removeItemFromCart(id) {
  try {
    const response = await fetch(
      "../database/cart.php?action=remove-cart-item",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
      }
    );

    const result = await response.json(); // Parse JSON response once
    console.log("Server Response:", result); // Log the parsed response

    if (result.success) {
      return true;
    }
    console.error("Error:", result);
    return false;
  } catch (e) {
    console.error("Fetch Error:", e);
    return false;
  }
}

const checkoutBtn = document.getElementById("checkoutbtn");

if (checkoutBtn) {
  checkoutBtn.addEventListener("click", () => {
    const selectedItems = document.querySelectorAll(".cd-cart-items li.active");
    const ids = [];

    selectedItems.forEach((item) => {
      ids.push(item.dataset.cart_id);
    });

    if (ids.length > 0) {
      checkoutItem(ids);
    } else {
      alert("Select item to checkout");
    }
  });

  function checkoutItem(ids) {
    const form = document.createElement("form");
    form.action = "../pages/checkout.php";
    form.method = "POST";

    const input = document.createElement("input");
    input.type = "text";
    input.value = ids;
    input.name = "cartIds";

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
  }
}

const removeMultipleItemBtn = document.getElementById("removeMultipleItemBtn");

if (removeMultipleItemBtn) {
  removeMultipleItemBtn.addEventListener("click", async () => {
    const selectedItems = document.querySelectorAll(".cd-cart-items li.active");

    const ids = Array.from(selectedItems).map((item) => item.dataset.cart_id);

    const itemsRemoved = await removeItemFromCart(ids);

    if (itemsRemoved) {
      // Add "removing" class to all selected items at once
      selectedItems.forEach((item) => {
        item.classList.add("removing");

        priceArray.pop(item.dataset.price);
      });

      updateCartTotalPrice();

      // Remove all items after the transition
      setTimeout(() => {
        selectedItems.forEach((item) => item.remove());
      }, 300);
    } else {
      alert("Some items could not be removed.\nPlease try again later.");
    }
  });
}

const removeOrderBtn = document.querySelectorAll(".remove-order-btn");

if (removeOrderBtn) {
  removeOrderBtn.forEach((btn) => {
    btn.addEventListener("click", async () => {
      const item = btn.parentElement;

      const itemRemoved = await removeItemFromCart([item.dataset.cart_id]);

      if (itemRemoved) {
        updatePosPrice();

        item.classList.add("removing");
        setTimeout(() => item.remove(), 300);
      } else {
        alert(
          "Cart item was not removed.\nWe are experiencing some internal errors.\nPlease try again later."
        );
      }
    });
  });

  async function updatePosPrice() {
    const userId = 6;

    try {
      const response = await fetch("../database/pos-function.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          user_id: userId,
        }),
      });

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const totalPrice = await response.text();

      // Update the total price on the page
      document.querySelector(".total-price").innerHTML = totalPrice;
    } catch (error) {
      console.error("Error fetching total price:", error);
      alert("Unable to fetch total price. Please try again later.");
    }
  }
}
