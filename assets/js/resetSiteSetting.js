function resetBgColor() {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "../database/site-setting.php?action=reset-bg";

  document.body.appendChild(form);

  form.submit();
}

function resetFontColor() {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "../database/site-setting.php?action=reset-font";

  document.body.appendChild(form);

  form.submit();
}

function resetAccentColor() {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "../database/site-setting.php?action=reset-accent";

  document.body.appendChild(form);

  form.submit();
}

function resetLogo() {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "../database/site-setting.php?action=reset-logo";

  document.body.appendChild(form);

  form.submit();
}

const logo = document.querySelector("input[type=file][id=logo]");
const logoPreview = document.getElementById("logoPreview");

logo.addEventListener("change", () => {
  const file = logo.files[0]; // Get the first selected file
  if (file) {
    const reader = new FileReader();

    // Event listener for when the file is read
    reader.onload = (e) => {
      logoPreview.src = e.target.result; // Set the preview image's src to the file's data URL
    };

    reader.readAsDataURL(file); // Read the file as a data URL
  } else {
    logoPreview.src = ""; // Clear the preview if no file is selected
  }
});
