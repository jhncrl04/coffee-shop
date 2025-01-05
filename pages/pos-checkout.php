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
  <link rel="stylesheet" href="../assets/css/checkout.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/adminPos.css">

  <script src="../assets/js/adminPos.js" defer></script>

  <?php require '../database/site-setting.php' ?>

  <title>Document</title>
</head>

<body>
  <div class="main-container">
    <div class="inline pos-nav">
      <a href="./admin-pos.php" class="pos-nav-btn">
        <i class="fa-regular fa-chevron-left"></i> Return To Point of Sale
      </a>
      <a href="../pages/dashboard.php" class="pos-nav-btn">
        Go To Queuing <i class="fa-regular fa-chevron-right"></i>
      </a>
    </div>
    <hr>
    <h1>Checkout</h1>
    <div class="grid checkout-grid">
      <div class="items-wrapper">
        <table id="checkoutTable">
          <thead>
            <tr class="header">
              <td>Product Name</td>
              <td>Size</td>
              <td>Flavor</td>
              <td>Add-ons</td>
              <td>Qnty</td>
              <td>Price</td>
            </tr>
          </thead>
          <?php load_pos_checkout($user_id) ?>
        </table>
      </div>
      <div class="checkout-details">
        <form action="../database/checkout.php" method="POST" id="posForm">
          <fieldset>
            <legend>Checkout Details</legend>
            <div class="input-wrapper">
              <label for="customer-name">Customer Name</label>
              <input type="text" name="customer-name" id="customer-name" value="" required>
            </div>
            <div class="input-wrapper">
              <div class="grid">
                <label for="total-price">Total Price:</label>
                <input type="text" name="total-price" id="total-price" value="<?php echo get_pos_price($user_id) ?>" readonly>
              </div>
            </div>
            <div class="input-wrapper">
              <div class="grid">
                <label for="cash-received">Cash Received: </label>
                <input type="text" name="cash-received" id="cash-received" value="" placeholder="0.00" required>
              </div>
            </div>
            <div class="input-wrapper">
              <div class="grid">
                <label for="change">Change: </label>
                <input type="text" name="change" id="change" value="" placeholder="0.00" required readonly>
              </div>
            </div>

            <button id="submitCheckout" class="main-btn">Confirm Payment</button>
          </fieldset>
        </form>
      </div>
    </div>
  </div>

  <?php include '../includes/receipt.php' ?>
</body>

</html>