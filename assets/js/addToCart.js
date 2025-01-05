const productCards = document.querySelectorAll(".card.product");

productCards.forEach((card) => {
  card.addEventListener("click", (e) => {
    const productName = card.querySelector(".product-name").innerHTML;

    show_cart_modal(addToCartModal, productName);
  });
});

async function getCheckedFlavors(productName) {
  try {
    const response = await fetch("../database/get-available-flavors.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ productName }),
    });

    const result = await response.json(); // Parse the JSON response
    console.log(result);

    if (result.success) {
      // Extract flavors from the result
      return result.flavors.map((flavor) => flavor.flavor);
    } else {
      console.error("Error:", result.message); // Handle server error
      return []; // Return an empty array on failure
    }
  } catch (error) {
    console.error("Fetch error:", error); // Handle fetch error
    return []; // Return an empty array on failure
  }
}

async function show_cart_modal(modal, productName) {
  try {
    // Make an AJAX request to your PHP script
    const response = await fetch(
      "../database/product.php?action=get-product-info",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productName }), // Send product name as JSON
      }
    );

    const result = await response.json(); // Parse the JSON response

    if (result.success) {
      // Populate modal with product info from the server
      const data = result.productInfo;
      console.log(data); // Debugging: see the product info

      // Example of updating modal with fetched product info
      modal.querySelector(".product-preview").src =
        `../uploads/` + data["productInfo"]["product_preview"];
      modal.querySelector(".product-name").innerHTML =
        data["productInfo"]["product_name"];
      modal.querySelector(".product-category").innerHTML =
        data["productInfo"]["product_category"];
      modal.querySelector(".product-price").innerHTML =
        `Starts at P ` + data["productInfo"]["product_price"];

      modal.querySelector("form #totalPrice").value =
        `P ` + data["productInfo"]["product_price"];

      modal.querySelector("#productId").value =
        data["productInfo"]["product_id"];
      modal.querySelector("#productName").value =
        data["productInfo"]["product_name"];
      modal.querySelector("#basePrice").value =
        data["productInfo"]["product_price"];

      const sizeWrapper = modal.querySelector("form .size-wrapper");
      const sizes = modal.querySelectorAll("form .size-wrapper .input-wrapper");
      if (sizes.length !== data["cupSizes"].length) {
        for (let i = data["cupSizes"].length - 1; i >= 0; i--) {
          const cupId = data["cupSizes"][i]["item_id"];
          const cupSize = data["cupSizes"][i]["name"];
          const cupImg = data["cupSizes"][i]["item_img"];
          const cupPrice = data["cupSizes"][i]["unit_price"];

          const size = document.createElement("input");
          const img = document.createElement("img");
          const label = document.createElement("label");

          size.type = "radio";
          size.value = cupSize;
          size.name = "cupSize";
          size.id = cupSize;

          img.src = `../uploads/${cupImg}`;
          img.classList.add("size-preview");

          label.htmlFor = cupSize;
          label.innerHTML = cupSize;

          const inputWrapper = document.createElement("div");
          inputWrapper.classList.add("input-wrapper");

          inputWrapper.dataset.price = cupPrice;
          inputWrapper.appendChild(size);
          inputWrapper.appendChild(img);
          inputWrapper.appendChild(label);

          sizeWrapper.appendChild(inputWrapper);

          if (i === 1) {
            inputWrapper.classList.add("active");
            size.checked = true;
          }
        }
      }

      const updatedSizes = modal.querySelectorAll(
        "form .size-wrapper .input-wrapper"
      );
      let cupPrice = 0;

      updatedSizes.forEach((size) => {
        size.addEventListener("click", () => {
          cupPrice = parseFloat(size.dataset.price);

          updatedSizes.forEach((s) => s.classList.remove("active"));

          const radio = size.querySelector("input[type=radio][name=cupSize]");
          radio.checked = true;

          if (radio.checked === true) {
            radio.parentElement.classList.add("active");
          }

          updateTotalPrice(
            data["productInfo"]["product_price"],
            selectFlavor.value,
            noOfPumps.value,
            totalPrice,
            addOns,
            cupPrice,
            qnty
          );
        });
      });

      const selectFlavor = modal.querySelector("select");
      const flavors = modal.querySelectorAll("select option");

      if (flavors.length !== data["flavors"].length) {
        for (let i = 0; data["flavors"].length > i; i++) {
          const flavor = data["flavors"][i]["flavor"];
          const option = document.createElement("option");

          option.value = flavor;
          option.innerHTML = flavor;

          selectFlavor.appendChild(option);
        }
      }

      const addOns = [];

      const addonsCheckboxes = modal.querySelectorAll(
        ".checkbox-wrapper .inline input[type=checkbox]"
      );

      addonsCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("click", () => {
          if (checkbox.checked) {
            addOns.push(checkbox.dataset.price);
          } else {
            addOns.pop(checkbox.dataset.price);
          }

          updateTotalPrice(
            data["productInfo"]["product_price"],
            selectFlavor.value,
            noOfPumps.value,
            totalPrice,
            addOns,
            cupPrice,
            qnty
          );
        });
      });

      const orderQnty = modal.querySelector("form #product-qnty");
      const increaseQnty = modal.querySelector("form #increaseQnty");
      const decreaseQnty = modal.querySelector("form #decreaseQnty");
      let qnty = orderQnty.value;

      orderQnty.addEventListener("change", () => {
        updateTotalPrice(
          data["productInfo"]["product_price"],
          selectFlavor.value,
          noOfPumps.value,
          totalPrice,
          addOns,
          cupPrice,
          orderQnty.value
        );
      });

      increaseQnty.addEventListener("click", () => {
        if (qnty < 10) {
          qnty++;
          orderQnty.value = qnty;
        }
        increaseQnty.disabled = qnty === 10 ? true : false;
        decreaseQnty.disabled = qnty === 1 ? true : false;

        updateTotalPrice(
          data["productInfo"]["product_price"],
          selectFlavor.value,
          noOfPumps.value,
          totalPrice,
          addOns,
          cupPrice,
          qnty
        );
      });
      decreaseQnty.addEventListener("click", () => {
        if (qnty > 1) {
          qnty--;
          orderQnty.value = qnty;
        }

        console.log(qnty);

        decreaseQnty.disabled = qnty === 1 ? true : false;
        increaseQnty.disabled = qnty < 10 ? false : true;

        updateTotalPrice(
          data["productInfo"]["product_price"],
          selectFlavor.value,
          noOfPumps.value,
          totalPrice,
          addOns,
          cupPrice,
          qnty
        );
      });

      const noOfPumps = modal.querySelector("#pump");
      const totalPrice = modal.querySelector("#totalPrice");

      selectFlavor.addEventListener(
        "change",
        async () =>
          await updateTotalPrice(
            data["productInfo"]["product_price"],
            selectFlavor.value,
            noOfPumps.value,
            totalPrice,
            addOns,
            cupPrice,
            qnty
          )
      );
      noOfPumps.addEventListener(
        "change",
        async () =>
          await updateTotalPrice(
            data["productInfo"]["product_price"],
            selectFlavor.value,
            noOfPumps.value,
            totalPrice,
            addOns,
            cupPrice,
            qnty
          )
      );
    } else {
      console.error("Error fetching product info:", result.message);
    }
  } catch (error) {
    console.error("Fetch error:", error);
  }

  modal.addEventListener("reset", () => {
    const sizesWrapper = modal.querySelectorAll(
      "form .size-wrapper .input-wrapper"
    );

    sizesWrapper.forEach((wrapper) => {
      wrapper.remove();
    });
  });

  // Finally, show the modal
  modal.show();
}

async function updateTotalPrice(
  productPrice,
  flavor,
  totalPumps,
  totalPrice,
  addOns,
  cupPrice,
  qnty
) {
  try {
    let price = 0;
    let addonsPrice = 0;
    let newPrice = 0;

    // Make an AJAX request to your PHP script
    const response = await fetch(
      "../database/product.php?action=get-flavor-price",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ flavor }), // Send product name as JSON
      }
    );
    const result = await response.json(); // Parse the JSON response

    if (result.success) {
      // Populate modal with product info from the server
      price = result.flavorPrice;
      // console.log(price); // Debugging: see the product info
    } else {
      console.error("Error fetching product info:", result.message);
    }

    if (addOns) {
      addOns.forEach((addons) => {
        addonsPrice += parseFloat(addons);
      });
    }

    newPrice =
      parseFloat(productPrice) +
      parseFloat(cupPrice) +
      parseFloat(price) * (totalPumps - 1) +
      addonsPrice;

    newPrice = newPrice * qnty;

    totalPrice.value = `P ${newPrice.toFixed(2)}`;
  } catch (error) {
    console.error("Fetch error:", error);
  }
}
