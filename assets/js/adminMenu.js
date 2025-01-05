const addCategoryModal = document.getElementById("addNewCategoryModal");
const editCategoryModal = document.getElementById("editCategoryModal");
const deleteCategoryModal = document.getElementById("deleteCategoryModal");
const productModal = document.getElementById("productModal");
const productCards = document.querySelectorAll(".product-card");
const productMultiDeleteBtn = document.getElementById("productMultiDeleteBtn");
const categoryMultiDeleteBtn = document.getElementById(
  "categoryMultiDeleteBtn"
);
const categoryCheckbox = document.querySelectorAll(".category-selector");

productCards.forEach((card) => {
  card.addEventListener("click", (e) => {
    // Handle clicks on the product card
    if (!e.target.classList.contains("product-card-selector")) {
      const card = e.currentTarget;
      const productId = card.dataset.value;
      const productName = card.querySelector(".product-name").innerHTML;
      const productDesc = card.querySelector(".product-description").innerHTML;
      const productPrice = card.querySelector(".product-price").innerHTML;
      const productCategory = card.querySelector(".product-category").innerHTML;

      const productInfo = {
        id: productId,
        productName: productName,
        productDesc: productDesc,
        productPrice: productPrice,
        productCategory: productCategory,
      };

      openModal(productModal, productInfo);
    } else {
      // Handle checkbox interactions
      const checkbox = e.target;
      if (checkbox.checked) {
        e.currentTarget.style.border = "0.2rem solid var(--success)";
      } else {
        e.currentTarget.style.border = "0.2rem solid var(--border)";
      }

      // Toggle the delete button based on any checked items
      const checkedCard = document.querySelectorAll(
        ".product-card-selector:checked"
      );
      if (checkedCard.length > 0) {
        productMultiDeleteBtn.classList.add("active");
      } else {
        productMultiDeleteBtn.classList.remove("active");
      }
    }
  });
});

categoryCheckbox.forEach((checkbox) => {
  checkbox.addEventListener("click", (e) => {
    const checkedCategory = document.querySelectorAll(
      ".category-selector:checked"
    );
    if (checkedCategory.length > 0) {
      categoryMultiDeleteBtn.classList.add("active");
    } else {
      categoryMultiDeleteBtn.classList.remove("active");
    }
  });
});

// multiple category deletion
categoryMultiDeleteBtn.addEventListener("click", () => {
  const checkedCategory = document.querySelectorAll(
    ".category-selector:checked"
  ); // Re-fetch dynamically
  let values = [];

  if (checkedCategory.length === 0) {
    alert("No category selected!");
    return;
  }

  // Perform deletion logic
  checkedCategory.forEach((checkbox) => {
    let category = checkbox.closest(".category");
    values.push(category.dataset.value);
  });

  let deleteForm = document.createElement("form");
  deleteForm.method = "POST";
  deleteForm.action = "../database/admin-menu.php?action=category-multi-delete";

  let hiddenInput = document.createElement("input");
  hiddenInput.type = "hidden";
  hiddenInput.name = "category_ids";
  hiddenInput.value = JSON.stringify(values);

  deleteForm.appendChild(hiddenInput);
  document.body.appendChild(deleteForm);

  deleteForm.submit();

  values = [];

  categoryMultiDeleteBtn.classList.remove("active");
});

// multiDeleteProduct
productMultiDeleteBtn.addEventListener("click", () => {
  const checkedCard = document.querySelectorAll(
    ".product-card-selector:checked"
  ); // Re-fetch dynamically
  let values = [];

  if (checkedCard.length === 0) {
    alert("No products selected!");
    return;
  }

  checkedCard.forEach((checkbox) => {
    let card = checkbox.closest(".product-card");
    values.push(card.dataset.value);
  });

  let deleteForm = document.createElement("form");
  deleteForm.method = "POST";
  deleteForm.action = "../database/admin-menu.php?action=product-multi-delete";

  let hiddenInput = document.createElement("input");
  hiddenInput.type = "hidden";
  hiddenInput.name = "product_ids";
  hiddenInput.value = JSON.stringify(values);

  deleteForm.appendChild(hiddenInput);
  document.body.appendChild(deleteForm);

  deleteForm.submit();

  productMultiDeleteBtn.classList.remove("active");
});

addCategory.addEventListener("click", () => {
  openModal(addCategoryModal);
});

function closeModal(modal) {
  modal.close();
}

function openModal(modal) {
  modal.showModal();
}

async function openModal(modal, value) {
  const form = modal.querySelector("form");
  if (form) {
    if (form.action.includes("edit-product")) {
      // Extract the current action
      let currentAction = form.action;

      // Remove any existing 'product-id' parameter
      currentAction = currentAction.replace(/(&|\?)product-id=[^&]*/, "");

      // Add the updated 'product-id' parameter
      form.action = currentAction + `&product-id=${value.id}`;

      form.querySelector("#productName").value = value.productName;
      form.querySelector("#productDescription").value = value.productDesc;
      form.querySelector("#productPrice").value = value.productPrice;
      form.querySelector("#category").value = value.productCategory;

      const checkboxes = form.querySelectorAll(
        ".flavor-wrapper input[type=checkbox]"
      );
      const availableFlavors = await getCheckedFlavors(value.productName);

      checkboxes.forEach((checkbox) => {
        if (availableFlavors.includes(checkbox.value)) {
          checkbox.checked = true; // Mark the checkbox as checked
        } else {
          checkbox.checked = false; // Ensure it's unchecked if not available
        }
      });
    }
  }

  const categoryNames = document.querySelectorAll(".category-name");

  categoryNames.forEach((categoryName) => {
    categoryName.value = value;
  });

  modal.showModal();
}

// slider
const sliderBtns = document.querySelectorAll(
  "input[type=radio][name=sliderBtn]"
);
const categorySlider = document.getElementById("categorySlider");
let categorySliderWidth = categorySlider.clientWidth;
let checkedController = 0;

sliderBtns.forEach((button) => {
  button.addEventListener("click", () => {
    categorySlider.style.transition = "all .7s ease-out";
    categorySlider.style.transform = `translateX(-${
      button.value * categorySliderWidth
    }px)`;

    checkedController = button.value;
  });
});

const sliderNextBtn = document.getElementById("sliderNextBtn");
const sliderPrevBtn = document.getElementById("sliderPrevBtn");
if (sliderNextBtn && sliderPrevBtn) {
  sliderNextBtn.addEventListener("click", () => {
    if (checkedController < sliderBtns.length - 1) {
      checkedController++;
      sliderBtns[checkedController].checked = true;

      categorySlider.style.transition = "all .7s ease-out";
      categorySlider.style.transform = `translateX(-${
        checkedController * categorySliderWidth
      }px)`;
    }
  });
  sliderPrevBtn.addEventListener("click", () => {
    if (checkedController > 0) {
      checkedController--;
      sliderBtns[checkedController].checked = true;

      categorySlider.style.transition = "all .7s ease-out";
      categorySlider.style.transform = `translateX(-${
        checkedController * categorySliderWidth
      }px)`;
    }
  });
}

const productModals = document.querySelectorAll(".modal");

productModals.forEach((modal) => {
  modal.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      modal.querySelector("form").reset();
    }
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
