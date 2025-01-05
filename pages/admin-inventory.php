<?php
session_start();

include '../database/inventory-read.php';
include '../includes/pagination.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- FONT AWESOME ICONS -->
  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-thin.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-solid.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-light.css">

  <link rel="stylesheet" href="https://atugatran.github.io/FontAwesome6Pro/css/all.min.css">

  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/customers.css">
  <link rel="stylesheet" href="../assets/css/inventory.css">

  <?php require '../database/site-setting.php' ?>

  <script src="../assets/js/inventoryPagination.js" defer></script>
  <script src="../assets/js/form.js" defer></script>
  <script src="../assets/js/inventory.js" defer></script>
  <title>Document</title>
</head>

<body>
  <?php include '../includes/admin_nav.php'; ?>
  <div class="main-container">
    <div class="inline">
      <h1>INVENTORY</h1>
      <div class="inline">

        <button class="main-btn success" id="addItemBtn" onclick="show_modal(addItemModal)">Add Item</button>
        <button class="main-btn edit" id="editItemBtn" disabled onclick="show_modal(editItemModal)">Edit/Restock Item</button>
        <button class="main-btn error" id="deleteItemBtn" disabled onclick="show_modal(deleteItemModal)">Delete Item</button>
        <!-- <button class="main-btn" id="deselectAll">Deselect All</button> -->
      </div>
    </div>
    <div class="table-container">
      <div class="inline" id="inventory-nav">
        <?php get_item_types() ?>
      </div>
      <table id="inventoryTable">
        <tr>
          <td class="header">
            <p>ID</p>
          </td>
          <td class="header">
            <p>Image</p>
          </td>
          <td class="header">
            <p>Name</p>
          </td>
          <td class="header">
            <p>Type</p>
          </td>
          <td class="header">
            <p>Stock Qty</p>
          </td>
          <td class="header">
            <p>Additional Price</p>
          </td>
        </tr>
        <?php get_inventory_data() ?>
      </table>
      <div class="pagination">
        <?php inventory_pagination() ?>
      </div>
    </div>
  </div>

  <?php include '../includes/inventory-modal.php' ?>
</body>

</html>