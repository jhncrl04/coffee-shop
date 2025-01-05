const htmlBody = document.querySelector("body");

const profileUpload = document.getElementById("profileUpload");
const uploadProfileForm = document.getElementById("uploadProfileForm");

profileUpload.addEventListener("change", () => {
  uploadProfileForm.submit();
});

const editPersonalInfoBtn = document.getElementById("editPersonalInfoBtn");
const saveChangeBtn = document.getElementById("saveChangeBtn");
const personalInputs = document.querySelectorAll(".edit-info-input");
const addAddressBtn = document.getElementById("addAddressBtn");

const personalInfoMessageContainer = document.getElementById(
  "personalInfoMessageContainer"
);
const personalInfoMessage = document.getElementById("personalInfoMessage");

editPersonalInfoBtn.addEventListener("click", () => {
  const additionalAddress = document.querySelector("#additionalAddress");

  if (
    additionalAddress.value !== null &&
    additionalAddress.value.trim() !== ""
  ) {
    addAddressBtn.classList.toggle("active");
    addAddressWrapper.classList.toggle("active");
  }

  // if edit is not active toggle active
  if (!editPersonalInfoBtn.classList.contains("active")) {
    personalInputs.forEach((input) => {
      input.readOnly = false;
      input.classList.remove("invalid");
    });

    addAddressBtn.classList.toggle("active");
    personalInfoMessageContainer.classList.toggle("active");
    saveChangeBtn.classList.toggle("active");
    editPersonalInfoBtn.classList.toggle("active");

    personalInfoMessageContainer.classList.remove("error");
    personalInfoMessage.classList.remove("error");
    personalInfoMessage.innerHTML = "Required fields are marked by *";
  } else {
    personalInputs.forEach((input) => {
      input.readOnly = true;
    });

    addAddressBtn.classList.toggle("active");
    personalInfoMessageContainer.classList.toggle("active");
    saveChangeBtn.classList.toggle("active");
    editPersonalInfoBtn.classList.toggle("active");
  }
});

const infoConfirmModal = document.getElementById("infoConfirmModal");
const editPersonalInfoForm = document.getElementById("editPersonalInfoForm");

saveChangeBtn.addEventListener("click", (e) => {
  let isValid = true;

  if (firstName.value === "" || lastName.value === "") {
    personalInfoMessageContainer.classList.add("error");
    personalInfoMessage.classList.add("error");
    personalInfoMessage.innerHTML =
      "Required fields are marked by *<br>Please fill in all the required fields";

    isValid = false;
  } else {
    personalInfoMessageContainer.classList.remove("error");
    personalInfoMessage.classList.remove("error");
    personalInfoMessage.innerHTML = "Required fields are marked by *";

    if (firstName.value.length < 2 || lastName.value.length < 2) {
      firstName.classList.add("invalid");
      lastName.classList.add("invalid");

      personalInfoMessageContainer.classList.add("error");
      personalInfoMessage.classList.add("error");
      personalInfoMessage.innerHTML += "<br>First or Last name is too short";

      isValid = false;
    } else {
      firstName.classList.remove("invalid");
      lastName.classList.remove("invalid");

      personalInfoMessage.innerHTML = "Required fields are marked by *";
    }
  }

  // Prevent form submission if invalid
  if (isValid) {
    htmlBody.style.overflow = "hidden";
    infoConfirmModal.showModal();
  } else {
    e.preventDefault();
  }
});

infoConfirmModal.addEventListener("close", () => {
  htmlBody.style.overflow = "auto";
});

const closeInfoConfirmModalBtn = document.getElementById(
  "closeInfoConfirmModalBtn"
);

closeInfoConfirmModalBtn.addEventListener("click", () => {
  infoConfirmModal.close();
  editPersonalInfoForm.reset();
});

const editEmailBtn = document.getElementById("editEmailBtn");
const emailInputs = document.querySelectorAll(".edit-email-input");
const saveEmailChangeBtn = document.getElementById("saveEmailChangeBtn");

const emailMessageContainer = document.getElementById("emailMessageContainer");
const emailMessage = document.getElementById("emailMessage");
const editConfirmPasswordWrapper = document.querySelector(
  ".edit-confirm-password"
);

editEmailBtn.addEventListener("click", () => {
  // if edit is not active toggle active
  if (!editEmailBtn.classList.contains("active")) {
    emailInputs.forEach((input) => {
      input.readOnly = false;
    });

    emailMessageContainer.classList.toggle("active");
    editConfirmPasswordWrapper.classList.toggle("active");
    saveEmailChangeBtn.classList.toggle("active");
    editEmailBtn.classList.toggle("active");

    email.classList.remove("invalid");
    emailMessageContainer.classList.remove("error");
    emailMessage.classList.remove("error");
    emailMessage.innerHTML = "Required fields are marked by *";
  } else {
    emailInputs.forEach((input) => {
      input.readOnly = true;
    });

    emailMessageContainer.classList.toggle("active");
    editConfirmPasswordWrapper.classList.toggle("active");
    saveEmailChangeBtn.classList.toggle("active");
    editEmailBtn.classList.toggle("active");
  }
});

const editEmailForm = document.getElementById("editEmailForm");
const editConfirmPassword = document.querySelector(
  ".edit-confirm-password #password"
);

const email = document.getElementById("email");
const oldEmail = document.getElementById("oldEmail");
const emailPattern =
  /^[a-zA-Z0-9._%+-]{3,64}@[a-zA-Z0-9.-]{3,255}\.[a-zA-Z]{2,}$/;

editEmailForm.addEventListener("submit", (e) => {
  let isValid = true;

  // Reset error state
  email.classList.remove("invalid");
  emailMessageContainer.classList.remove("error");
  emailMessage.classList.remove("error");
  emailMessage.innerHTML = "Required fields are marked by *";

  // Validate email
  if (!emailPattern.test(email.value)) {
    email.classList.add("invalid");

    emailMessageContainer.classList.add("error");
    emailMessage.classList.add("error");
    emailMessage.innerHTML += "<br>Enter a valid email";

    isValid = false;
  } else if (email.value === oldEmail.value) {
    emailMessageContainer.classList.add("error");
    emailMessage.classList.add("error");
    emailMessage.innerHTML += "<br>This email is your current email";

    isValid = false;
  } else {
    emailMessageContainer.classList.remove("error");
    emailMessage.classList.remove("error");
    emailMessage.innerHTML = "Required fields are marked by *";
  }

  if (editConfirmPassword.value === "") {
    editConfirmPassword.classList.add("invalid");

    emailMessageContainer.classList.add("error");
    emailMessage.classList.add("error");
    emailMessage.innerHTML += "<br>Password required to save changes";

    isValid = false;
  }

  // Prevent form submission if invalid
  if (!isValid) {
    e.preventDefault();
  }
});

const editPasswordBtn = document.getElementById("editPasswordBtn");
const savePasswordChangeBtn = document.getElementById("savePasswordChangeBtn");
const passwordInputs = document.querySelectorAll(".edit-password-input");

const passwordMessageContainer = document.getElementById(
  "passwordMessageContainer"
);
const passwordMessage = document.getElementById("passwordMessage");
const editWrapper = document.querySelectorAll(".edit-wrapper");

editPasswordBtn.addEventListener("click", () => {
  // if edit is not active toggle active
  if (!editPasswordBtn.classList.contains("active")) {
    passwordInputs.forEach((input) => {
      input.readOnly = false;
      input.classList.remove("invalid");
    });

    editWrapper.forEach((wrapper) => {
      wrapper.classList.toggle("active");
    });

    passwordMessageContainer.classList.toggle("active");
    savePasswordChangeBtn.classList.toggle("active");
    editPasswordBtn.classList.toggle("active");

    passwordMessageContainer.classList.remove("error");
    passwordMessage.classList.remove("error");
    passwordMessage.innerHTML = "Required fields are marked by *";
  } else {
    passwordInputs.forEach((input) => {
      input.readOnly = true;
    });

    editWrapper.forEach((wrapper) => {
      wrapper.classList.toggle("active");
    });

    passwordMessageContainer.classList.toggle("active");
    savePasswordChangeBtn.classList.toggle("active");
    editPasswordBtn.classList.toggle("active");
  }
});

const changePasswordForm = document.getElementById("editPasswordForm");
const oldPassword = document.getElementById("old_password");
const newPassword = document.getElementById("new_password");
const confirmNewPassword = document.getElementById("confirm_new_password");

changePasswordForm.addEventListener("submit", (e) => {
  let isValid = true;

  // Reset error state
  passwordInputs.forEach((input) => {
    input.classList.remove("invalid");
  });

  passwordMessageContainer.classList.remove("error");
  passwordMessage.classList.remove("error");
  passwordMessage.innerHTML = "Required fields are marked by *";

  const errorMessages = [];

  // Validation for required fields
  if (!oldPassword.value || !newPassword.value || !confirmNewPassword.value) {
    isValid = false;

    passwordInputs.forEach((input) => {
      if (!input.value) input.classList.add("invalid");
    });

    errorMessages.push("Please fill in all the required fields");
  }

  // Validation for password length
  if (
    (oldPassword.value.length > 0 && oldPassword.value.length < 6) ||
    (newPassword.value.length > 0 && newPassword.value.length < 6) ||
    (confirmNewPassword.value.length > 0 && confirmNewPassword.value.length < 6)
  ) {
    isValid = false;
    errorMessages.push("Passwords must be at least 6 characters long");
  }

  // Validation for password match
  if (newPassword.value !== confirmNewPassword.value) {
    isValid = false;
    errorMessages.push("New passwords do not match");
  }

  // Display error messages
  if (errorMessages.length > 0) {
    passwordMessageContainer.classList.add("error");
    passwordMessage.classList.add("error");
    passwordMessage.innerHTML += `<br>${errorMessages.join("<br>")}`;
  }

  // Prevent form submission if invalid
  if (!isValid) {
    e.preventDefault();
  }
});

const addAddressWrapper = document.getElementById("addAddressWrapper");

addAddressBtn.addEventListener("click", () => {
  addAddressWrapper.classList.toggle("active");
});
