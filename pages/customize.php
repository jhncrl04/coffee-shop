<?php
session_start();

$title = 'Cool Beans Coffee - Menu';

require '../database/customize.php';

$is_login = $_SESSION['is_login'] ?? false;

?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= $title ?></title>

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

  <!-- MY CSS -->
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/footer.css">
  <link rel="stylesheet" href="../assets/css/customize.css">

  <?php require '../database/site-setting.php' ?>

  <!-- MY JAVASCRIPT -->

  <script src="../assets/js/customize.js" defer></script>

</head>

<body>

  <div class="main-container">
    <a href="../pages/menu.php" id="returnToMenuBtn">
      <i class="fa-regular fa-chevron-left"></i> Return To Menu
    </a>
    <h1>Make a Drink</h1>
    <div class="inline" id="order-summary">
      <div class="inline">
        <label for="drink-name">Name Your Drink:</label>
        <input type="text" id="drink-name">
      </div>
      <div class="inline">
        <label for="total-price">Total Price:</label>
        <input type="text" id="total-price" value="0.00">
      </div>
    </div>

    <form action="../database/checkout.php?action=customize" class="customize-container">
      <section>
        <div class="customize-preview">
          <div class="unmasked-image">
            <?php load_unmasked_images() ?>
          </div>
          <div class="masked-image">
            <?php load_masked_images() ?>
          </div>
          <div class="shadow"></div>
        </div>
      </section>
      <div class="flex vertical">
        <div class="container cup-container">
          <h2>Select Cup Size:</h2>
          <div class="flex">
            <?php load_sizes() ?>
          </div>
        </div>
        <div class="container toppings-container">
          <h2>Choose your Toppings:</h2>
          <div class="flex vertical">
            <?php load_toppings() ?>

            <select name="whipped-cream" id="whipped-cream">
              <option value="none" selected disabled>Add Whipped Cream</option>
              <option value="none">None</option>
              <?php load_whipped_creams() ?>
            </select>
          </div>
        </div>
        <div class="container flavor-container">
          <h2>Select Flavor:</h2>
          <div class="flex vertical">
            <?php load_flavors() ?>
          </div>
        </div>
      </div>
      <div class="container addons-container">
        <h2>Choose your add-ons</h2>
        <div class="flex vertical">
          <?php load_addons() ?>
        </div>
      </div>
      <div class="inline">
        <button type="reset">Clear Selection</button>
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>
  <?php
  require_once '../includes/footer.php';
  ?>
</body>

</html>