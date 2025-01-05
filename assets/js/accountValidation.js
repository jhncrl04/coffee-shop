const firstName = document.getElementById("firstName");
const lastName = document.getElementById("lastName");
const email = document.getElementById("email");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const contact = document.getElementById("contact");
const address = document.getElementById("address");
const signupForm = document.getElementById("signUpCard");

const emailPattern =
  /^[a-zA-Z0-9._%+-]{3,64}@[a-zA-Z0-9.-]{3,255}\.[a-zA-Z]{2,}$/;

signupForm.addEventListener("submit", (e) => {
  let isValid = true;

  if (firstName.value.length < 2) {
    firstName.classList.add("invalid");
    isValid = false;
  } else {
    firstName.classList.remove("invalid");
    firstName.classList.add("valid");
  }

  if (lastName.value.length < 3) {
    lastName.classList.add("invalid");
    isValid = false;
  } else {
    lastName.classList.remove("invalid");
    lastName.classList.add("valid");
  }

  if (!emailPattern.test(email.value)) {
    email.classList.add("invalid");
    isValid = false;
  } else {
    email.classList.remove("invalid");
    email.classList.add("valid");
  }

  if (password.value !== confirmPassword.value || password.value.length < 6) {
    password.classList.add("invalid");
    confirmPassword.classList.add("invalid");
    isValid = false;
  } else {
    password.classList.remove("invalid");
    confirmPassword.classList.remove("invalid");
    password.classList.add("valid");
    confirmPassword.classList.add("valid");
  }

  if (!isValid) {
    e.preventDefault();
  }
});

const loginForm = document.getElementById("logInCard");
const loginEmail = document.getElementById("loginEmail");
const loginPassword = document.getElementById("loginPassword");

loginForm.addEventListener("submit", (e) => {
  let isValid = true;
  if (loginPassword.value.length < 3 || !emailPattern.test(loginEmail.value)) {
    loginEmail.className = "invalid";
    loginPassword.className = "invalid";

    isValid = false;
  } else {
    loginEmail.classList.remove = "invalid";
    loginPassword.classList.remove = "invalid";

    isValid = true;
  }

  if (!isValid) {
    e.preventDefault();
  }
});
