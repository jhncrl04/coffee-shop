<?php
session_start();

$title = 'Cool Beans Coffee - Menu';

require '../database/product.php';
require '../includes/pagination.php';

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
  <link rel="stylesheet" href="../assets/css/homepage.css">
  <link rel="stylesheet" href="../assets/css/userAuthentication.css">
  <link rel="stylesheet" href="../assets/css/footer.css">
  <link rel="stylesheet" href="../assets/css/accountVerificationModal.css">
  <link rel="stylesheet" href="../assets/css/menu.css">

  <?php require '../database/site-setting.php' ?>

  <!-- MY JAVASCRIPT -->
  <script src="../assets/js/form.js" defer></script>
  <script src="../assets/js/accountValidation.js" defer></script>
  <script src="../assets/js/dropdown.js" defer></script>
  <script src="../assets/js/menuPagination.js" defer></script>

  <?php
  if ($is_login) {
    echo '<script src="../assets/js/addToCart.js" defer></script>';
  } else {
    echo '<script src="../assets/js/addToCartLogin.js" defer></script>';
  }

  ?>
</head>

<body>
  <!-- import nav from includes folder -->
  <?php require '../includes/nav.php' ?>

  <div id="isLogin" data-is_login='<?php echo $is_login ?>'></div>

  <div class="header">
    <img src="../assets/images/contact-header.jpg" alt="" class="header-img">
    <h1 class="header-label">SIP AND SNACKS</h1>
  </div>
  <div class="menu-container">

    <div class="page-info">
      <div>
        <h1 class="page-title">MENU BOARD</h1>
        <h1 class="page-catchphrase">SIP, RELAX, AND ENJOY</h1>
      </div>
      <p>Discover your perfect brew: from bold espresso shots to creamy lattes and refreshing cold brews, every sip is crafted to brighten your day!</p>
    </div>

    <div class="menu-board">
      <div class="best-seller-container">
        <h1>OUR BEST SELLERS</h1>
        <div class="best-seller-menu" id="bestSellers">
          <?php load_best_sellers('menu') ?>
        </div>
      </div>
      <div class="menu-pagination" id="menu">
        <hr>
        <div class="pages">
          <?php menu_category_pagination() ?>
        </div>
      </div>

      <div class="main-menu">

        <?php product_menu() ?>

      </div>

      <div class="product-pagination">
        <?php menu_product_pagination() ?>
      </div>
    </div>
  </div>

  <?php
  require_once '../includes/footer.php';
  require "../includes/auth.php";
  require "../includes/menu-modal.php";
  require '../includes/cart.php';
  ?>
</body>

</html>