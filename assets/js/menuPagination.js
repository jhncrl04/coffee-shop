const pagesPerCategory = document.querySelectorAll(
  "span:has(input[type=radio][name=page])"
);

pagesPerCategory.forEach((page) => {
  page.addEventListener("click", () => {
    let baseUri = document.baseURI;

    const pageValue = page.querySelector("input[type=radio][name=page]");

    // Remove any existing "page=" parameter and duplicates of "#menu"
    baseUri = baseUri
      .replace(/([?&])s=[^&]*/g, "")
      .replace(/(&|\?)page=\d+/g, "") // Remove existing "page=" parameter
      .replace(/#menu/g, ""); // Remove duplicate "#menu"

    // Add "page" and "#menu" to the cleaned base URI
    if (baseUri.includes("category")) {
      window.location.href = `${baseUri}&page=${pageValue.value}#menu`;
    } else {
      window.location.href = `${baseUri}?page=${pageValue.value}#menu`;
    }
  });
});

const categoryPages = document.querySelectorAll(
  "input[type=radio][name=category-page]"
);

categoryPages.forEach((page) => {
  page.addEventListener("click", () => {
    let baseUri = document.baseURI;

    // Remove existing "category=" and "page=" parameters, and any duplicate "#menu"
    baseUri = baseUri
      .replace(/([?&])s=[^&]*/g, "")
      .replace(/([?&])category=[^&]*/g, "") // Remove "category=" parameter
      .replace(/([?&])page=\d+/g, "") // Remove "page=" parameter
      .replace(/#menu/g, "") // Remove duplicate "#menu"
      .replace(/[?&]$/, ""); // Clean trailing '?' or '&'

    // Determine the separator for the new query parameter
    const separator = baseUri.includes("?") ? "&" : "?";

    if (page.value === "custom-drink") {
      window.location.href = "./customize.php";

      return;
    }

    // Add the new "category" and "#menu" to the cleaned base URI
    window.location.href = `${baseUri}${separator}category=${page.value}#menu`;
  });
});

const pageNextBtn = document.getElementById("pageNext");
const pagePrevBtn = document.getElementById("pagePrev");

if (pageNextBtn && pagePrevBtn) {
  pageNextBtn.addEventListener("click", () => {
    let selectedPage = document.querySelector(
      "input[type=radio][name=page]:checked"
    ).value;
    let totalPage = document.querySelectorAll("input[type=radio][name=page]");

    selectedPage = parseInt(selectedPage);

    let baseUri = document.baseURI;

    // Remove any existing "page=" parameter and duplicates of "#menu"
    baseUri = baseUri
      .replace(/(&|\?)page=\d+/g, "") // Remove existing "page=" parameter
      .replace(/#menu/g, ""); // Remove duplicate "#menu"

    // Add "page" and "#menu" to the cleaned base URI
    if (selectedPage < totalPage.length) {
      if (baseUri.includes("category")) {
        window.location.href = `${baseUri}&page=${selectedPage + 1}#menu`;
      } else {
        window.location.href = `${baseUri}?page=${selectedPage + 1}#menu`;
      }
    }
  });

  pagePrevBtn.addEventListener("click", () => {
    let selectedPage = document.querySelector(
      "input[type=radio][name=page]:checked"
    ).value;

    selectedPage = parseInt(selectedPage);

    let baseUri = document.baseURI;

    // Remove any existing "page=" parameter and duplicates of "#menu"
    baseUri = baseUri
      .replace(/(&|\?)page=\d+/g, "") // Remove existing "page=" parameter
      .replace(/#menu/g, ""); // Remove duplicate "#menu"

    // Add "page" and "#menu" to the cleaned base URI
    if (selectedPage - 1 > 0) {
      if (baseUri.includes("category")) {
        window.location.href = `${baseUri}&page=${selectedPage - 1}#menu`;
      } else {
        window.location.href = `${baseUri}?page=${selectedPage - 1}#menu`;
      }
    }
  });
}
