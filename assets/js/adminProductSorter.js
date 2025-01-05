const categorySorterForm = document.createElement("form");
categorySorterForm.method = "POST";
categorySorterForm.action = "../database/product-list.php";

const checkedCategory = document.querySelectorAll(".categorySorter");
let selectedCategories = [];
let baseUri = "../database/product-list.php";

// Add event listeners to all checkboxes
checkedCategory.forEach((category) => {
  category.addEventListener("change", (e) => {
    if (category.checked) {
      // Add the category value to the selected list if not already present
      if (!selectedCategories.includes(category.value)) {
        selectedCategories.push(category.value);
      }
    } else {
      selectedCategories = selectedCategories.filter(
        (value) => value !== category.value
      );
    }
  });
});

// function loadProducts(categories) {
//   // Construct the query string with repeated "category" parameters
//   const queryParams = categories
//     .map((category) => `category=${encodeURIComponent(category)}`)
//     .join("&");

//   const updatedUri = `${baseUri}?${queryParams}`;

//   // Create a new XMLHttpRequest
//   const xhr = new XMLHttpRequest();
//   xhr.open("GET", updatedUri, true);

//   // Handle the response
//   xhr.onload = () => {
//     if (xhr.status === 200) {
//       console.log(xhr.responseText);

//       console.log("Products loaded successfully.");
//     } else {
//       console.error("Error loading products:", xhr.status, xhr.statusText);
//     }
//   };

//   // Handle errors
//   xhr.onerror = () => {
//     console.error("AJAX request failed.");
//   };

//   // Send the AJAX request
//   xhr.send();
//   console.log("Request sent to:", updatedUri);
// }
