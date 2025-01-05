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
  <link rel="stylesheet" href="../assets/css/menu.css">
  <link rel="stylesheet" href="../assets/css/adminPos.css">

  <script src="../assets/js/form.js" defer></script>
  <script src="../assets/js/addToCart.js" defer></script>
  <script src="../assets/js/cart.js" defer></script>
  <script src="../assets/js/adminPos.js" defer></script>

  <?php require '../database/site-setting.php' ?>

  <title>Document</title>
</head>

<body>
  <div class="main-container">
    <div class="inline pos-nav">
      <a href="../pages/dashboard.php" class="pos-nav-btn">
        <i class="fa-regular fa-chevron-left"></i> Return To Dashboard
      </a>
      <a href="../pages/queuing.php" class="pos-nav-btn">
        Go To Queuing <i class="fa-regular fa-chevron-right"></i>
      </a>
    </div>
    <hr>
    <h1>Point of Sale</h1>

    <div class="inner-container grid">
      <div class="pos-wrapper flex vertical">
        <!-- <div class="search-wrapper inline">
          <input type="text" placeholder="Search product" id="searchProduct">
          <button type="button" id="searchProductBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div> -->
        <div class="category-wrapper flex vertical">
          <h2>Category</h2>
          <ul class="category-nav inline">
            <?php load_category() ?>
          </ul>
        </div>
        <div class="product-wrapper flex vertical">
          <h2>Menu</h2>
          <div class="menu-wrapper grid">
            <?php load_product() ?>
          </div>
        </div>
      </div>

      <div class="cart flex vertical">
        <h2>Orders</h2>
        <hr>
        <ul class="orders">
          <?php load_cart($user_id, 'pos') ?>
        </ul>
        <div class="payment-wrapper flex vertical">
          <hr>
          <span class="inline">
            <p class="label">Total:</p>
            <p class="total-price">
              <?php echo get_pos_price($user_id); ?>
            </p>
          </span>
          <a href="./pos-checkout.php" class="main-btn" id="proceedPaymentBtn">Proceed To Payment</a>
        </div>
      </div>
    </div>
  </div>

  <?php include '../includes/menu-modal.php' ?>
</body>

</html>