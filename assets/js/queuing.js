const preparingItem = document.querySelectorAll(".preparing-item");
const claimableItem = document.querySelectorAll(".claimable-item");
const claimableContainer = document.querySelector(".to-receive-container ul");
const orders = document.querySelectorAll("ul .order");

const orderIds = [];

orders.forEach((order) => {
  order.addEventListener("click", () => {
    const orderIdIndex = orderIds.indexOf(order.dataset.order_id);

    if (order.classList.contains("active")) {
      if (orderIdIndex !== -1) {
        orderIds.splice(orderIdIndex, 1); // Remove the specific order_id
      }
    } else {
      orderIds.push(order.dataset.order_id); // Add the order_id
    }

    order.classList.toggle("active");
  });
});

const markAsServeBtn = document.getElementById("markAsServeBtn");
const markAsClaimableBtn = document.getElementById("markAsClaimedBtn");

markAsServeBtn.addEventListener("click", async () => {
  try {
    if (orderIds) {
      const response = await fetch(
        "../database/update-order-status.php?action=TO%20COLLECT",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ orderIds }),
        }
      );

      const result = await response.json();

      if (result.success) {
        const selectedOrders = document.querySelectorAll(
          "li.preparing-item.active"
        );

        selectedOrders.forEach((order) => {
          order.classList.add("removing");

          const orderLi = document.createElement("li");

          orderLi.className = "order claimable-item";
          orderLi.dataset.order_id = order.dataset.order_id;
          orderLi.innerHTML = order.dataset.order_id;

          claimableContainer.prepend(orderLi);

          orderLi.addEventListener("click", () => {
            const orderIdIndex = orderIds.indexOf(orderLi.dataset.order_id);

            if (orderLi.classList.contains("active")) {
              if (orderIdIndex !== -1) {
                orderIds.splice(orderIdIndex, 1); // Remove the specific order_id
              }
            } else {
              orderIds.push(orderLi.dataset.order_id); // Add the order_id
            }

            orderLi.classList.toggle("active");
          });

          setTimeout(() => {
            order.remove();
          }, 300); // Delay of 300ms
        });
      }
    }
  } catch (error) {
    console.error(error);
  }
});

markAsClaimableBtn.addEventListener("click", async () => {
  try {
    if (orderIds) {
      const response = await fetch(
        "../database/update-order-status.php?action=COMPLETED",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ orderIds }),
        }
      );

      const result = await response.json();

      if (result.success) {
        const selectedOrders = document.querySelectorAll(
          "li.claimable-item.active"
        );

        selectedOrders.forEach((order) => {
          order.classList.add("removing");

          setTimeout(() => {
            order.remove();
          }, 300); // Delay of 300ms
        });
      }
    }
  } catch (error) {
    console.error(error);
  }
});
