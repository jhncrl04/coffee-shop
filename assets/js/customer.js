const tableRow = document.querySelectorAll(".customer-details");
const blockUserBtn = document.getElementById("blockUserBtn");
const userIds = [];

async function ajaxButton(userId) {
  try {
    const response = await fetch("../database/is-blocked.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ userId }),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();
    console.log("Server Response:", result);

    if (result.blocked) {
      blockUserBtn.innerHTML = "Unblock";
    } else {
      blockUserBtn.innerHTML = "Block";
    }
  } catch (error) {
    console.error("Error in fetch request:", error);
    alert("An error occurred. Please try again.");
  }
}

tableRow.forEach((row) => {
  row.addEventListener("click", () => {
    row.classList.toggle("active");
    const userId = row.dataset.value;

    if (!userId) {
      console.error("User ID not found in row data-value attribute.");
      return;
    }

    if (row.classList.contains("active")) {
      if (!userIds.includes(userId)) {
        userIds.push(userId);
      }
    } else {
      const index = userIds.indexOf(userId);
      if (index > -1) {
        userIds.splice(index, 1);
      }
    }

    console.log("Selected User IDs:", userIds);

    if (userIds.length === 1) {
      blockUserBtn.disabled = false;
      ajaxButton(userIds[0]); // Call ajaxButton with the selected userId
    } else {
      blockUserBtn.disabled = true;
    }
  });
});

const deleteUserBtn = document.getElementById("deleteUserBtn");

deleteUserBtn.addEventListener("click", () => {
  let deleteForm = document.createElement("form");
  deleteForm.method = "POST";
  deleteForm.action = "../database/customer-details.php?action=delete-user";

  let hiddenInput = document.createElement("input");
  hiddenInput.type = "hidden";
  hiddenInput.name = "user_ids";
  hiddenInput.value = JSON.stringify(userIds);

  deleteForm.appendChild(hiddenInput);
  document.body.appendChild(deleteForm);

  if (userIds.length !== 0) {
    deleteForm.submit();
  } else {
    alert("No user selected");
  }

  userIds = [];
});

blockUserBtn.addEventListener("click", () => {
  tableRow.forEach((row) => {
    if (row.classList.contains("active")) {
      userIds.push(row.dataset.value);
    }
  });

  let blockForm = document.createElement("form");
  blockForm.method = "POST";
  blockForm.action = "../database/customer-details.php?action=block-user";

  let hiddenInput = document.createElement("input");
  hiddenInput.type = "hidden";
  hiddenInput.name = "user_ids";
  hiddenInput.value = JSON.stringify(userIds);

  blockForm.appendChild(hiddenInput);
  document.body.appendChild(blockForm);

  blockForm.submit();

  userIds = [];
});
