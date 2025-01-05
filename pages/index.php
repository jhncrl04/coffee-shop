<?php
session_start();
$user_role = $_SESSION['user_role'] ?? '';
if ($user_role === 'admin') {
  header('Location: dashboard.php');
}

$title = 'Cool Beans Coffee';

require '../database/site-setting.php';
require '../database/slider.php';
?>

<!DOCTYPE html>
<html lang="en">

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

  <!-- MY JAVASCRIPT -->
  <script src="../assets/js/form.js" defer></script>
  <script src="../assets/js/accountValidation.js" defer></script>
  <script src="../assets/js/dropdown.js" defer></script>

  <?php require '../database/site-setting.php' ?>

  <!-- disabled slider for now -->
  <script src="../assets/js/slider.js" defer></script>

</head>

<body>
  <!-- import nav from includes folder -->
  <?php require '../includes/nav.php' ?>

  <section id="landingPage">
    <div class="catchphraseContainer">
      <div class="catchphrase">
        <h1>WELCOME TO COOL BEANS COFFEE</h1>
        <p>Exprience The Best Coffee In Town</p>
      </div>
      <a href="menu.php" class="main-btn wrap-width">ORDER NOW</a>
    </div>
    <div class="img-wrapper">
      <img src="../assets/images/PngItem_3646386.png" alt="" id="hero-img">
      <div id="shadowIllusion"></div>
    </div>
  </section>
  <section class="pagePreview" id="menuPreview">
    <div class="previewContainer">
      <div class="previewTextContainer">
        <h1 class="previewBrand">COOL BEANS COFFEE</h1>
        <p class="previewHeader">WHAT WE OFFER</p>
      </div>
      <div class="menuPreviewSlider">
        <div class="menuPreviewImageContainer">
          <?php include '../database/category.php';
          home_category($result) ?>
        </div>
      </div>
      <div class="prev-next-btn-container">
        <button id="menuSliderPrevBtn">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button id="menuSliderNextBtn">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </section>

  <section class="pagePreview" id="bestSellerPreview">
    <div class="previewContainer">
      <div class="previewTextContainer">
        <h1 class="previewBrand">FEATURING</h1>
        <p class="previewHeader">OUR RECOMMENDATION</p>
      </div>

      <div class="carousel-container" id="carouselContainer">
        <div class="carousel-slide" id="carouselSlide">
          <?php loadSlider() ?>
        </div>
        <div class="slider-btn-wrapper">
          <button id="sliderPrevBtn">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
          <button id="sliderNextBtn">
            <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>
      </div>
      <!-- <div class="slider-controller">
      </div> -->
  </section>
  <section class="pagePreview" id="aboutusPreview">
    <img src="../assets/images/our-story-img.jpg" alt="">
    <div class="previewContainer">
      <div class="previewTextContainer">
        <h1 class="previewBrand">OUR STORY</h1>
        <p class="previewHeader">Where every cup sparks joy and connection.</p>
      </div>
      <p class="storyPreview">Cool Beans Coffee is a specialty coffee destination located in the heart of Binagbag, Angat, Bulacan. Dedicated to bringing you the finest coffee experiences, we carefully source the best beans from around the world and craft them to perfection. Whether you’re a coffee connoisseur or just looking for your daily brew, we’re here to serve you with quality, passion, and the warmest hospitality.</p>
      <hr>
      <button class="main-btn wrap-width">MORE ABOUT US <i class="fa-regular fa-arrow-right icon"></i></button>
    </div>
  </section>

  <section class="pagePreview" id="contactPreview">
    <div class="previewContainer">
      <div class="previewTextContainer">
        <h1 class="previewBrand">CONTACT</h1>
        <p class="previewHeader">CONNECT WITH US</p>
      </div>
      <div class="container" id="contactTextContainer">
        <span>
          <i class="fa-light fa-location-dot icon"></i>
          <p>047 Brunei St., Binagbag, Angat, Bulacan, Philippines</p>
        </span>
        <span>
          <i class="fa-light fa-phone icon"></i>
          <p>+(63) 945-788-0606</p>
        </span>
        <span>
          <i class="fa-light fa-envelope icon"></i>
          <p>info.coolbeanscoffee@gmail.com</p>
        </span>
      </div>
      <div class="container" id="iconContainer">
        <!-- maybe remove the text -->
        <span>
          <a href="https://www.facebook.com/coolbeansph" target="_blank" class=" iconContainer"><i class="fa-brands fa-facebook-f icon"></i></a>
          <!-- <a href="https://www.facebook.com/coolbeansph">facebook.com/coolbeansph</a> -->
        </span>
        <span>
          <a href="https://www.instagram.com/coolbeans_ph" target="_blank" class=" iconContainer"><i class="fa-brands fa-instagram icon"></i></a>
          <!-- <a href="https://www.instagram.com/coolbeans_ph">instagram.com/coolbeans_ph</a> -->
        </span>
        <span>
          <a href="https://x.com/coolbeans_ph" target="_blank" class=" iconContainer"><i class="fa-brands fa-x-twitter icon"></i></a>
          <!-- <a href="https://x.com/coolbeans_ph">x.com/coolbeans_ph</a> -->
        </span>
      </div>
      <button class="main-btn wrap-width">WRITE A REVIEW</button>
    </div>
    <img src="../assets/images/contact-header.jpg" alt="">
  </section>

  <!-- footer -->
  <?php
  require_once "../includes/footer.php";
  // include login and signup form
  require "../includes/auth.php";
  require '../includes/cart.php';
  ?>

</body>

</html>