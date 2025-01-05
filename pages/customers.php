<?php
session_start();

require '../database/category-list.php';
$first_name = $_SESSION['fname'] ?? "";
$last_name = $_SESSION['lname'] ?? "";
$email = $_SESSION['email'] ?? "";
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
  <link rel="stylesheet" href="../assets/css/customers.css">
  <?php require '../database/site-setting.php' ?>

  <script src="../assets/js/customer.js" defer></script>

  <title>Document</title>
</head>

<body>
  <?php include '../includes/admin_nav.php'; ?>
  <div class="main-container">
    <h1>Customers Account</h1>
    <table>
      <tr>
        <td class="header">
          <p>User ID</p>
        </td>
        <td class="header">
          <p>Name</p>
        </td>
        <td class="header">
          <p>Email</p>
        </td>
        <td class="header">
          <p>Contact</p>
        </td>
        <td class="header">
          <p>Address</p>
        </td>
        <td class="header">
          <p>Verified</p>
        </td>
        <td class="header">
          <p>Blocked</p>
        </td>
      </tr>
      <?php require '../database/customer-details.php' ?>
    </table>
    <div class="inline">
      <button class="customerTableBtn success" id="blockUserBtn" disabled>Block</button>
      <button class="customerTableBtn error" id="deleteUserBtn">Delete</button>
    </div>
  </div>

</body>

</html>