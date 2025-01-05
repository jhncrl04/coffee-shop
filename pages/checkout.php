<?php
session_start();

$first_name = $_SESSION['fname'];
$last_name = $_SESSION['lname'];
$fullname = "$first_name $last_name";
$contact = $_SESSION['contact'];
$address_1 = $_SESSION['address_1'] ?? "";
$address_2 = $_SESSION['address_2'] ?? "";

$referer = $_SERVER['HTTP_REFERER'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['cartIds'])) {
    $ids = $_POST['cartIds'];
  }
}

require '../database/read_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php include '../database/site-setting.php' ?>


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

  <script src="../assets/js/checkout.js" defer></script>

  <title>Document</title>
</head>

<body>
  <div class="main-container">
    <button id="returnbtn"><i class="fa-solid fa-chevron-left"></i> Return</button>
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
        <?php load_checkout($ids) ?>
      </table>
      <span id="checkoutTotal">
        <p>Total:<b>P <?php echo get_checkout_total_price($ids) ?></b></p>
      </span>
    </div>
    <div class="checkout-details">
      <form action="../database/checkout.php" method="POST" enctype="multipart/form-data">
        <fieldset>
          <legend>Checkout Details</legend>

          <input type="hidden" name="cart-ids" id="cart-ids" value="<?php echo $ids ?>">
          <input type="hidden" name="total-price" id="total-price" value="<?php echo get_checkout_total_price($ids) ?>">

          <div class="input-wrapper">
            <label for="customer-name">Customer Name</label>
            <input type="text" name="customer-name" id="customer-name" value="<?php echo $fullname ?>" required readonly>
          </div>
          <div class="input-wrapper">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" value="<?php echo $contact ?>" required>
          </div>

          <div class="input-wrapper">
            <label for="address">Address</label>
            <?php
            if ($address_1 || $address_2) {
              echo "<select name='address' id='address' required>";
              echo "<option disabled selected>Select Address</option>";
              if ($address_1) {
                echo "<option value='$address_1'>$address_1</option>";
              }
              if ($address_2) {
                echo "<option value='$address_2'>$address_2</option>";
              }
              echo "</select>";
            } else {
              echo "<input type='text' name='address' id='address' required>";
            }
            ?>
          </div>

          <div class="input-wrapper">
            <label for="payment-method">Payment Method</label>
            <select name="payment-method" id="payment-method" required>
              <option disabled selected>Select Payment Option</option>
              <option value="gcash">Gcash</option>
              <option value="paypal">PayPal</option>
              <option value="maya">Maya</option>
              <option value="bank">Bank Transfer</option>
            </select>
          </div>

          <div class="input-wrapper">
            <label for="payment-proof">Proof of Payment</label>
            <input type="file" name="payment-proof" id="payment-proof" required>
            <label for="payment-proof">
              <img src="../assets/images/no-image.jpg" alt="" id="payment-proof-img">
            </label>
          </div>
          <button id="submitCheckout" class="main-btn">Confirm Payment</button>
        </fieldset>
      </form>
    </div>
  </div>

  <?php
  echo "
  <script defer>
    document.getElementById('returnbtn').addEventListener('click', () => {
      window.location.href = '$referer';
    })
  </script>
  ";
  ?>
</body>

</html>