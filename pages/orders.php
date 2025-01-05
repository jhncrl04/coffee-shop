<?php
session_start();

require '../database/read-order.php'
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
  <link rel="stylesheet" href="../assets/css/orders.css">

  <script src="../assets/js/order.js" defer></script>

  <?php require '../database/site-setting.php' ?>

  <title>Document</title>
</head>

<body>
  <?php include '../includes/admin_nav.php'; ?>
  <div class="main-container">
    <div class="inline">
      <h1>Orders</h1>
    </div>
    <div class="search-wrapper inline">
      <input type="text" placeholder="Search an ID" id="searchID">
      <button type="button" id="searchOrderBtn">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </div>
    <table class="main-table">
      <thead>
        <tr class="header">
          <td>
            <p>Order<br>ID</p>
          </td>
          <td>
            <p>Customer Details</p>
          </td>
          <td>
            <p>Order Details</p>
          </td>
          <td>
            <p>Price</p>
          </td>
          <td>
            <p>Payment Method</p>
          </td>
          <td>
            <p>Receipt</p>
          </td>
          <td>
            <p>Order Status</p>
          </td>
          <td>
            <p>Order Date</p>
          </td>
        </tr>
      </thead>
      <tbody>
        <?php load_orders(); ?>
      </tbody>
    </table>

    <div class="inline gap">
      <input value="View" type="button" class="view button" id="viewOrderBtn" disabled>
      <input value="Completed" type="button" class="success update button" id="completeOrderBtn">
      <input value="Approved" type="button" class="approve update button" id="approveOrderBtn">
      <input value="Rejected" type="button" class="error update button" id="rejectOrderBtn">
    </div>
  </div>

  <?php
  include '../includes/order-details-modal.php';
  include '../includes/payment-modal.php'
  ?>
</body>