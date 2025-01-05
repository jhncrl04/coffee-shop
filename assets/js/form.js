const signUpRedirectBtn = document.getElementById("goToSignUp");
const logInRedirectBtn = document.getElementById("backToLogin");
const cardContainer = document.getElementById("cardContainer");

if (signUpRedirectBtn) {
  signUpRedirectBtn.addEventListener("click", () => {
    cardContainer.style.right = "100%";
  });
}
if (logInRedirectBtn) {
  logInRedirectBtn.addEventListener("click", () => {
    cardContainer.style.right = "0%";
  });
}

const htmlBody = document.querySelector("body");

const logInModal = document.getElementById("formContainer");
const failedLoginErrorMessage = document.getElementById(
  "failedLoginErrorMessage"
);
const blockedAccountErrorMessage = document.getElementById(
  "blockedAccountErrorMessage"
);

const errorMessages = document.querySelectorAll("error-message");

const closeLoginModalBtn = document.getElementById("closeLoginModal");
let modalOpen = false;

function show_modal(modal) {
  if (cardContainer) {
    cardContainer.style.right = "0%";
  }
  if (modal.id === "editItemModal" || modal.id === "deleteItemModal") {
    const selectedRow = document.querySelector(".item-details.active");
    const form = modal.querySelector("form");

    populate_form(form, selectedRow);
  }
  modal.showModal();

  modalOpen = true;

  htmlBody.style.overflow = "hidden";
}

function close_modal(modal) {
  modalOpen = false;

  htmlBody.style.overflow = "auto";

  modal.close();
}

if (logInModal) {
  logInModal.addEventListener("close", () => {
    if (errorMessages) {
      failedLoginErrorMessage.style.display = "none";
      blockedAccountErrorMessage.style.display = "none";
    }

    htmlBody.style.overflow = "auto";
  });
}

const loginBtn = document.getElementById("login-btn");

if (loginBtn) {
  loginBtn.addEventListener("click", () => {
    show_modal(logInModal);
  });

  closeLoginModalBtn.addEventListener("click", () => {
    close_modal(logInModal);
  });
}

window.addEventListener("load", () => {
  if (
    document.baseURI.toLowerCase().includes("login-status") ||
    document.baseURI.toLowerCase().includes("account-status") ||
    document.referrer.toLowerCase().includes("forgot-password.php")
  ) {
    show_modal(logInModal);
  }
});

const forgotPassBtn = document.getElementById("forgotPassBtn");
const forgotPassModal = document.getElementById("forgotPassContainer");

const returnToLogin = document.getElementById("logInRedirectBtn");
const resetPassBackToLogin = document.getElementById("resetPassBackToLogin");

if (forgotPassBtn) {
  forgotPassBtn.addEventListener("click", () => {
    close_modal(logInModal);
    show_modal(forgotPassModal);
  });
}

if (returnToLogin) {
  returnToLogin.addEventListener("click", () => {
    returnToLoginForm(forgotPassModal);
  });
}
if (resetPassBackToLogin) {
  resetPassBackToLogin.addEventListener("click", () => {
    window.location.href = "index.php";
  });
}

function returnToLoginForm(modal) {
  close_modal(modal);
  show_modal(logInModal);
}

function populate_form(form, data) {
  const dataValues = data.querySelectorAll("td > p");
  const dataArr = [];

  dataValues.forEach((dataValue) => {
    dataArr.push(dataValue.innerHTML);
  });

  const indicesToCheck = [3, 4];

  indicesToCheck.forEach((index) => {
    if (dataArr[index] && /[a-zA-Z\s]/.test(dataArr[index])) {
      dataArr[index] = dataArr[index].replace(/[a-zA-Z\s]/g, "");
    }
  });

  const itemId = form.querySelector("#itemId");
  const itemName = form.querySelector("#itemName");
  const itemType = form.querySelector("#itemType");
  const quantity = form.querySelector("#quantity");
  const price = form.querySelector("#price");

  itemId.value = dataArr[0];
  itemName.value = dataArr[1];
  itemType.value = dataArr[2];
  if (price && quantity) {
    quantity.value = dataArr[3];
    price.value = dataArr[4];
  }
}
