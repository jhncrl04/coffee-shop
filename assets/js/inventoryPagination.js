const pages = document.querySelectorAll(".pagination span");

pages.forEach((page) => {
  page.addEventListener("click", () => {
    let baseUri = new URL(document.baseURI); // Use URL API for better URL handling

    const pageValue = page.querySelector("input[type=radio][name=page]");

    // Remove any existing "page" parameter
    baseUri.searchParams.delete("page");

    // Check if the URL has a "type" parameter
    const hasType = baseUri.searchParams.has("type");

    // Add "page" to the URL
    baseUri.searchParams.set("page", pageValue.value);

    // Update the URL in the browser
    window.location.href = baseUri.toString();
  });
});
