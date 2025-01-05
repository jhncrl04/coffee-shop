const htmlBody = document.querySelector("body");

const logInModal = document.getElementById("formContainer");
const errorMessage = document.getElementById("loginErrorMessage");

const closeLoginModalBtn = document.getElementById("closeLoginModal");

const addItemModal = document.getElementById("addItemModal");

function show_modal(modal) {
  if (logInModal) {
    cardContainer.style.right = "0%";
  }

  modal.showModal();
  htmlBody.style.overflow = "hidden";
}

function close_modal(modal) {
  modal.close();

  htmlBody.style.overflow = "auto";
  errorMessage.style.display = "none";
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
  resetPassBackToLogin.addEventListener("click", () => {
    window.location.href = "index.php";
  });

  function returnToLoginForm(modal) {
    close_modal(modal);
    show_modal(logInModal);
  }
}

const body = document.body;

body.addEventListener("keydown", (e) => {
  console.log(e);
});
