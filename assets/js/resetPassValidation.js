const resetPasswordForm = document.getElementById("resetPassword");
const newPassword = document.getElementById("newPassword");
const confirmNewPassword = document.getElementById("confirmNewPassword");

let isValid;

resetPasswordForm.addEventListener("submit", (e) => {
  if (
    newPassword.value.length < 6 ||
    newPassword.value !== confirmNewPassword.value
  ) {
    newPassword.classList.add("invalid");
    confirmNewPassword.classList.add("invalid");
    isValid = false;
  } else {
    newPassword.classList.remove("invalid");
    confirmNewPassword.classList.remove("invalid");
    newPassword.classList.add("valid");
    confirmNewPassword.classList.add("valid");
    isValid = true;
  }

  if (!isValid) {
    e.preventDefault();
  }
});
