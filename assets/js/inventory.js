const inventoryTable = document.getElementById("inventoryTable");
const editItemBtn = document.getElementById("editItemBtn");
const deleteItemBtn = document.getElementById("deleteItemBtn");
const deselectAll = document.getElementById("deselectAll");

let itemIds = [];

if (inventoryTable) {
  selectRow(inventoryTable);
}

if (deselectAll) {
  deselectAll.addEventListener("click", () => deselectAllItems(inventoryTable));
}

function selectRow(table) {
  let rows = table.querySelectorAll("tr");
  let selectedRow = null; // To keep track of the currently selected row

  rows.forEach((row) => {
    row.addEventListener("click", () => {
      // Ignore the header row
      if (row === rows[0]) return;

      // Deselect the previously selected row, if any
      if (selectedRow && selectedRow !== row) {
        selectedRow.classList.remove("active");
      }

      // Toggle the current row
      if (row.classList.contains("active")) {
        row.classList.remove("active");
        selectedRow = null;
      } else {
        row.classList.add("active");
        selectedRow = row;
      }

      // Update itemIds array
      itemIds = selectedRow ? [selectedRow.dataset.value] : [];

      // Update button states
      editItemBtn.disabled = itemIds.length === 0;
      deleteItemBtn.disabled = itemIds.length === 0;
    });
  });
}

function deselectAllItems(table) {
  let rows = table.querySelectorAll("tr");

  rows.forEach((row) => {
    if (row.classList.contains("active")) {
      row.classList.remove("active");
      itemIds.pop(row.dataset.value);
    }
  });

  editItemBtn.disabled =
    itemIds.length > 1 || itemIds.length === 0 ? true : false;
  deselectAll.style.opacity = itemIds.length > 1 ? 1 : 0;
  deleteItemBtn.disabled = itemIds.length === 0 ? true : false;
}
