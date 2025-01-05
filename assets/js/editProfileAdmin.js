const profileUpload = document.getElementById("profileUpload");
const uploadProfileForm = document.getElementById("uploadProfileForm");

profileUpload.addEventListener("change", () => {
  uploadProfileForm.submit();
});

const changePasswordBtn = document.getElementById("changePasswordBtn");
const passwordInputContainer = document.querySelector(
  ".password-input-container"
);
changePasswordBtn.addEventListener("click", () => {
  passwordInputContainer.classList.toggle("active");
});
