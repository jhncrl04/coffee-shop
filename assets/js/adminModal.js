const htmlBody = document.querySelector("body");

const addSliderModal = document.getElementById("addSliderModal");
const deleteSliderModal = document.getElementById("deleteSliderModal");
const editSliderModal = document.getElementById("editSliderModal");
let selectedSliderItem;

function show_modal(modal) {
  // Check if the modal is edit or delete and ensure a slider item is selected
  if (
    (modal === editSliderModal || modal === deleteSliderModal) &&
    !selectedSliderItem
  ) {
    alert("Please select a slider item first.");
    return; // Exit the function if no slider item is selected
  } else if (
    (modal === editSliderModal || modal === deleteSliderModal) &&
    !selectedSliderItem.dataset.id
  ) {
    alert("Can't edit or delete this slider");
    return;
  } else if (modal === editSliderModal || modal === deleteSliderModal) {
    modal.querySelector("input[type=hidden]").value =
      selectedSliderItem.dataset.id;
  }
  // Show the modal
  modal.showModal();

  // Handle edit modal-specific logic
  if (modal === editSliderModal) {
    const selectedPhrase =
      selectedSliderItem.querySelector(".phrase").innerHTML;
    const selectedProductName =
      selectedSliderItem.querySelector(".product-name").innerHTML;
    const selectedImageSrc = selectedSliderItem.querySelector("img").src;

    // Populate the modal with selected item's details
    modal.querySelector(".phrase").innerHTML = selectedPhrase;
    modal.querySelector(".product-name").innerHTML = selectedProductName;
    modal.querySelector("img").src = selectedImageSrc;

    // Set form inputs for editing
    modal.querySelector("#editPhraseInput").value = selectedPhrase;
    modal.querySelector("#editProductNameInput").value = selectedProductName;
  }

  if (modal === addSliderModal || modal === editSliderModal) {
    const productName = modal.querySelector("#productName");
    const productNameInput = modal.querySelector(".slider-product-name");

    productNameInput.addEventListener("change", () => {
      productName.innerHTML = productNameInput.value;
    });

    const phrase = modal.querySelector("#phrase");
    const phraseInput = modal.querySelector(".slider-phrase");

    phraseInput.addEventListener("keyup", (e) => {
      phrase.innerHTML = phraseInput.value;
    });

    const sliderImg = modal.querySelector("#sliderImg");
    const sliderImgInput = modal.querySelector(".slider-img");

    sliderImgInput.addEventListener("change", (event) => {
      const file = event.target.files[0]; // Get the selected file
      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          sliderImg.src = reader.result; // Set the image src to the file data
        };
        reader.readAsDataURL(file); // Read the file data as a Data URL
      }
    });
  }

  // Prevent body from scrolling while modal is open
  htmlBody.style.overflow = "hidden";
}

function close_modal(modal) {
  modal.close();
  htmlBody.style.overflow = "auto";
}

const modals = document.querySelectorAll("dialog");

modals.forEach((modal) => {
  modal.addEventListener("close", () => {
    htmlBody.style.overflow = "auto";
  });
});

const sliderItems = document.querySelectorAll(".slider-setting .slider-item");

sliderItems.forEach((slider) => {
  slider.addEventListener("click", () => {
    const isActive = slider.classList.contains("active");

    // Remove 'active' class from all items
    sliderItems.forEach((item) => item.classList.remove("active"));

    // If the clicked slider wasn't active, activate it
    if (!isActive) {
      slider.classList.add("active");
      selectedSliderItem = slider;
    }
  });
});

const forms = document.querySelectorAll("form");
const confirmPasswordModal = document.getElementById("confirmPasswordModal");
let formCopy;

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    if (!formCopy) {
      formCopy = form.cloneNode(true);
      formCopy.id = "formCopy";

      if (form.id === "addSliderForm" || form.id === "editSliderForm") {
        let productNameCopy = form.querySelector(".slider-product-name").value;
        let phraseCopy = form.querySelector(".slider-phrase").value;

        formCopy.querySelector(".slider-product-name").value = productNameCopy;
        formCopy.querySelector(".slider-phrase").value = phraseCopy;
      }
    }

    if (form.id !== "adminChangePass") {
      confirmPasswordModal.appendChild(formCopy);
      show_modal(confirmPasswordModal);
    }
  });
});

const confirmChangeBtn = document.getElementById("confirmChangeBtn");
const changeConfirmPassword = document.getElementById("changeConfirmPassword");

confirmChangeBtn.addEventListener("click", async () => {
  const password = changeConfirmPassword.value;

  try {
    const response = await fetch("../database/validate-password.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ password }),
    });

    const result = await response.json();
    console.log("Server Response:", result);

    if (result.success) {
      alert("Password confirmed!\nChanges Saved!");
      const inputWrapper = confirmChangeBtn.parentNode;
      const mainNode = inputWrapper.parentNode;

      mainNode.querySelector("form").submit();
    } else {
      alert("Incorrect password. Please try again.");
    }
  } catch (error) {
    console.error("Error in fetch request:", error);
    alert("An error occurred. Please try again.");
  }
});

const passwordForm = document.querySelector("form.password-input-container");

passwordForm.addEventListener("submit", async (e) => {
  const newPass = passwordForm.querySelector("#new-password").value;
  const confirmNewPass = passwordForm.querySelector(
    "#confirm-new-password"
  ).value;

  if (newPass !== confirmNewPass) {
    alert("New password don't match");

    e.preventDefault();
  } else {
    confirmPasswordModal.appendChild(formCopy);
    show_modal(confirmPasswordModal);
  }
});
