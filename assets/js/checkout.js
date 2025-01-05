const paymentProof = document.querySelector(
  "input[type=file][id=payment-proof]"
);
const proofPreview = document.getElementById("payment-proof-img");

paymentProof.addEventListener("change", () => {
  const file = paymentProof.files[0]; // Get the first selected file
  if (file) {
    const reader = new FileReader();

    // Event listener for when the file is read
    reader.onload = (e) => {
      proofPreview.src = e.target.result; // Set the preview image's src to the file's data URL
    };

    reader.readAsDataURL(file); // Read the file as a data URL
  } else {
    proofPreview.src = ""; // Clear the preview if no file is selected
  }
});
