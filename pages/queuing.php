<?php
session_start();

$user_id = $_SESSION['user_id'] ?? '';
$is_login = $_SESSION['is_login'] ?? false;
$user_role = $_SESSION['user_role'] ?? '';
if (!$is_login) {
  header('Location: index.php');
}

if ($user_role && $user_role === 'customer') {
  $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
  header("Location: $referer");
}

include '../database/admin-menu.php';
include '../database/pos-function.php';
include '../database/product.php';
include '../database/read_cart.php';
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
  <link rel="stylesheet" href="../assets/css/adminPos.css">
  <link rel="stylesheet" href="../assets/css/queuing.css">

  <script src="../assets/js/queuing.js" defer></script>

  <?php require '../database/site-setting.php' ?>

  <title>Document</title>
</head>

<body>
  <div class="main-container">
    <div class="inline pos-nav">
      <a href="../pages/admin-pos.php" class="pos-nav-btn">
        <i class="fa-regular fa-chevron-left"></i> Return To Point of Sale
      </a>
      <a href="../pages/dashboard.php" class="pos-nav-btn">
        Go To Dashboard <i class="fa-regular fa-chevron-right"></i>
      </a>
    </div>
    <hr>
    <h1>Order Queue</h1>

    <div class="queue-container grid">
      <div class="preparing-container">
        <h2>Preparing</h2>
        <ul>
          <?php load_pos_queue() ?>
        </ul>
      </div>
      <div class="to-receive-container">
        <h2>To Claim</h2>
        <ul>
          <?php load_pos_claimable() ?>
        </ul>
      </div>
    </div>

    <div class="button-grid grid">
      <div>
        <button id="markAsServeBtn">Mark as Serving</button>
      </div>
      <div>
        <button id="markAsClaimedBtn">Mark as Claimed</button>
      </div>
    </div>
  </div>
</body>

</html>