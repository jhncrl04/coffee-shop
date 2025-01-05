<?php
session_start();

include '../database/admin-menu.php';
include '../database/product.php';
include '../database/read-order.php';
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

  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/orders.css">
  <link rel="stylesheet" href="../assets/css/adminDashboard.css">

  <?php require '../database/site-setting.php' ?>

  <title>Document</title>
</head>

<body>
  <?php include '../includes/admin_nav.php'; ?>
  <div class="main-container">
    <h1>Dashboard</h1>
    <div class="sale grid">
      <div class="product grid">
        <div class="product-highlight-container">
          <h2>Best Sellers</h2>
          <div class="inline slider-container">
            <?php load_best_sellers('dashboard') ?>
          </div>
        </div>
        <div class="product-highlight-container">
          <h2>Least Sellers</h2>
          <div class="inline slider-container">
            <?php load_least_sellers() ?>
          </div>
        </div>
      </div>
    </div>

    <div class="sale-history-container">
      <h2>Sales History</h2>
      <table class="main-table">
        <thead>
          <tr class="header">
            <td>Customer ID</td>
            <td>Customer Name</td>
            <td>Order Detail</td>
            <td>Price</td>
            <td>Order Method</td>
            <td>Payment</td>
            <td>Order Date</td>
          </tr>
        </thead>
        <tbody>
          <?php load_sale_history() ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>