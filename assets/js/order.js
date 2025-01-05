const orders = document.querySelectorAll(".orders");
let orderIds = [];
const invalidTransitions = {
  COMPLETED: ["REJECTED", "APPROVED"],
  REJECTED: ["COMPLETED", "APPROVED"],
};

const viewOrderBtn = document.getElementById("viewOrderBtn");
const backdrop = document.querySelector(".backdrop");

orders.forEach((order) => {
  order.addEventListener("click", (e) => {
    if (!e.target.classList.contains("payment-proof-img")) {
      order.classList.toggle("active");

      if (order.classList.contains("active")) {
        orderIds.push(order.dataset.order_id);
      } else {
        const orderId = order.dataset.order_id;

        // Remove the specific order ID from the array
        const index = orderIds.indexOf(orderId);
        if (index !== -1) {
          orderIds.splice(index, 1);
        }
      }

      if (orderIds.length === 1) {
        viewOrderBtn.disabled = false;
      } else {
        viewOrderBtn.disabled = true;
      }
    }
  });
});

const completeOrderBtn = document.getElementById("completeOrderBtn");
const approveOrderBtn = document.getElementById("approveOrderBtn");
const rejectOrderBtn = document.getElementById("rejectOrderBtn");

const updateBtns = document.querySelectorAll("input.update.button");

updateBtns.forEach((btn) => {
  btn.addEventListener("click", async () => {
    if (orderIds.length === 0) {
      alert("Select order to update");
      return;
    }

    orders.forEach((order) => {
      const orderID = order.dataset.order_id;

      if (order.classList.contains("active")) {
        if (order.dataset.order_status === btn.value.toUpperCase()) {
          alert(`Order ${orderID} has already been ${btn.value}`);
          order.classList.toggle("active");
          orderIds.pop(order.dataset.order_id);

          viewOrderBtn.disabled = true;
        }

        if (
          invalidTransitions[order.dataset.order_status]?.includes(
            btn.value.toUpperCase()
          )
        ) {
          alert(
            `Order ${orderID} has already been ${order.dataset.order_status} and cannot be ${btn.value}`
          );
          order.classList.toggle("active");
          orderIds.pop(order.dataset.order_id);

          viewOrderBtn.disabled = true;
        }
      }
    });
    if (orderIds.length > 0) {
      try {
        const response = await fetch(
          `../database/update-order-status.php?action=${btn.value}`,
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ orderIds }),
          }
        );

        const result = await response.json(); // Parse the JSON response

        if (result.success) {
          // Extract flavors from the result
          console.log(result);

          updateOrderStatus(btn.value);

          return true;
        } else {
          console.error("Error:", result.message); // Handle server error
          return false; // Return an empty array on failure
        }
      } catch (error) {
        console.error("Fetch error:", error); // Handle fetch error
        return false; // Return an empty array on failure
      }
    }
  });
});

viewOrderBtn.addEventListener("click", () => viewOrder(orderIds[0]));
const searchBtn = document.getElementById("searchOrderBtn");
const searchId = document.getElementById("searchID");

searchBtn.addEventListener("click", () => {
  let found = false; // Flag to track if a matching ID is found
  orders.forEach((order) => {
    if (order.dataset.order_id === searchId.value) {
      found = true; // Set the flag to true if a match is found
      viewOrder(searchId.value);
    }
  });

  if (!found) {
    alert("Order ID not found!");
  }
});

function viewOrder(orderId) {
  backdrop.classList.add("open");

  const selectedOrder = document.querySelector(
    `tr.orders[data-order_id = "${orderId}"]`
  );
  const customerName = selectedOrder.querySelector("p.customer-name").innerHTML;
  const customerAddress =
    selectedOrder.querySelector("p.customer-address").innerHTML;
  const customerContact =
    selectedOrder.querySelector("p.customer-contact").innerHTML;

  const paymentMethod =
    selectedOrder.querySelector("p.payment-method").innerHTML;
  const orderStatus = selectedOrder.querySelector("p.order-status").innerHTML;
  const orderAdded = selectedOrder.querySelector("p.date-added").innerHTML;
  const totalPrice = selectedOrder.querySelector("p.total-price").innerHTML;

  const orderInfos = selectedOrder.querySelectorAll(
    ".order-details .order-info"
  );

  if (selectedOrder.dataset.order_id === orderId) {
    orderInfoModal.querySelector("p.order-id").innerHTML = orderId;
    orderInfoModal.querySelector("p.customer-name").innerHTML = customerName;
    orderInfoModal.querySelector("p.customer-address").innerHTML =
      customerAddress;
    orderInfoModal.querySelector("p.customer-contact").innerHTML =
      customerContact;

    orderInfos.forEach((order) => {
      const productName = order.querySelector("p.product-name").innerHTML;
      const quantity = `(${order.querySelector("p.quantity").innerHTML})`;
      const flavor = order.querySelector("p.flavor").innerHTML;
      const size = order.querySelector("p.size").innerHTML;
      const pumpCount = order.querySelector("#pumpCount").value;

      // Creating divs with "inline" class
      const productInline = document.createElement("div");
      productInline.className = "inline";

      const productInnerInline = document.createElement("div");
      productInnerInline.className = "inline";

      const sizeInline = document.createElement("div");
      sizeInline.className = "inline";

      const flavorInline = document.createElement("div");
      flavorInline.className = "inline";

      const pumpInline = document.createElement("div");
      pumpInline.className = "inline";

      // Creating a div with "wrapper" class
      const flavorWrapper = document.createElement("div");
      flavorWrapper.className = "wrapper";

      // Creating p elements with "label" class
      const productLabel = document.createElement("p");
      productLabel.className = "label";

      const sizeLabel = document.createElement("p");
      sizeLabel.className = "label";

      const flavorLabel = document.createElement("p");
      flavorLabel.className = "label";

      const pumpsLabel = document.createElement("p");
      pumpsLabel.className = "label";

      productLabel.innerHTML = "Product Name:";
      sizeLabel.innerHTML = "Size:";
      flavorLabel.innerHTML = "Flavor:";
      pumpsLabel.innerHTML = "Flavor Pumps:";

      const modalProductName = document.createElement("p");
      modalProductName.className = "product-name";

      const modalQuantity = document.createElement("p");
      modalQuantity.className = "quantity";

      const modalSize = document.createElement("p");
      modalSize.className = "order-size";

      const modalFlavor = document.createElement("p");
      modalFlavor.className = "flavor";

      const modalPumps = document.createElement("p");
      modalPumps.className = "pump-count";

      const hr = document.createElement("hr");

      modalProductName.innerHTML = productName;
      modalQuantity.innerHTML = quantity;
      modalSize.innerHTML = size;
      modalFlavor.innerHTML = flavor;
      modalPumps.innerHTML = pumpCount;

      const orderInfoWrapper = document.createElement("div");
      orderInfoWrapper.className = "order-info-wrapper flex vertical";

      productInnerInline.appendChild(modalProductName);
      productInnerInline.appendChild(modalQuantity);
      productInline.appendChild(productLabel);
      productInline.appendChild(productInnerInline);

      sizeInline.appendChild(sizeLabel);
      sizeInline.appendChild(modalSize);

      flavorInline.appendChild(flavorLabel);
      flavorInline.appendChild(modalFlavor);

      pumpInline.appendChild(pumpsLabel);
      pumpInline.appendChild(modalPumps);

      flavorWrapper.appendChild(flavorInline);
      flavorWrapper.appendChild(pumpInline);

      const orderWrapper = orderInfoModal.querySelector(".order-wrapper");
      orderInfoWrapper.appendChild(productInline);
      orderInfoWrapper.appendChild(sizeInline);
      orderInfoWrapper.appendChild(flavorWrapper);
      orderInfoWrapper.appendChild(hr);

      orderWrapper.appendChild(orderInfoWrapper);
    });

    orderInfoModal.querySelector("p.payment-method").innerHTML = paymentMethod;
    orderInfoModal.querySelector("p.order-status").innerHTML = orderStatus;
    orderInfoModal.querySelector("p.order-added").innerHTML = orderAdded;
    orderInfoModal.querySelector("p.total-price").innerHTML = totalPrice;

    orderInfoModal.show();
  }
}

orderInfoModal.addEventListener("close", () => {
  backdrop.classList.remove("open");
  const orderWrapper = orderInfoModal.querySelector(".order-wrapper");
  orderWrapper.innerHTML = "";
});

function updateOrderStatus(status) {
  const selectOrders = document.querySelectorAll(".orders.active");
  selectOrders.forEach((order) => {
    const orderId = order.dataset.order_id;

    if (orderIds.includes(orderId)) {
      // Remove the specific order ID from the array
      const index = orderIds.indexOf(orderId);
      if (index !== -1) {
        orderIds.splice(index, 1);
      }

      const orderStatus = order.querySelector(".order-status");

      order.dataset.order_status = status.toUpperCase();
      orderStatus.innerHTML = status.toUpperCase();

      order.classList.toggle("active");
    }
  });
}

const paymentProof = document.querySelectorAll("td img");

paymentProof.forEach((payment) => {
  payment.addEventListener("click", () => {
    const orderID = payment.closest("tr").dataset.order_id;

    paymentModal.querySelector("img").src = payment.src;
    paymentModal.querySelector("h1").innerHTML = `Order ID: ${orderID}`;
    backdrop.classList.toggle("open");
    paymentModal.show();
  });
});

paymentModal.addEventListener("close", () => {
  backdrop.classList.remove("open");
});
