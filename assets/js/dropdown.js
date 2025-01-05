const dropdownBtn = document.getElementById("dropdownBtn");
const dropdown = document.getElementById("accountDropdown");

dropdownBtn.addEventListener("mouseenter", (event) => {
  event.stopPropagation(); // Prevent the event from bubbling up to the window
  document.getElementById("myDropdown").classList.add("show");
});

dropdown.addEventListener("mouseleave", (event) => {
  // If clicked outside the button
  const dropdowns = document.getElementsByClassName("dropdown-content");
  for (let i = 0; i < dropdowns.length; i++) {
    const openDropdown = dropdowns[i];
    if (openDropdown.classList.contains("show")) {
      openDropdown.classList.remove("show");
    }
  }
});
