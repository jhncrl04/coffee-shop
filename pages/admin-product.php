<?php
session_start();

require '../database/category-list.php';
require '../database/product.php';
require '../includes/pagination.php';
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
  <link rel="stylesheet" href="../assets/css/adminMenu.css">
  <link rel="stylesheet" href="../assets/css/main.css">

  <?php require '../database/site-setting.php' ?>

  <script src="../assets/js/adminMenu.js" defer></script>
  <script src="../assets/js/menuPagination.js" defer></script>

  <title>Document</title>
</head>

<body>
  <?php include '../includes/admin_nav.php'; ?>
  <div class="main-container">
    <h1>PRODUCTS</h1>

    <div class="section-container" id="categoryContainer">
      <div class="inline category-inline-btn">
        <h2>Menu Category</h2>
        <button id="categoryMultiDeleteBtn" class="multi-delete-btn">Delete All</button>
      </div>
      <div class="slider-container" id="sliderContainer">
        <!-- ADD CATEGORY BUTTON -->
        <div class="add-category" id="addCategory" onclick="openModal(addCategoryModal)">
          <i class="fa-solid fa-plus"></i>
        </div>

        <!-- IMPORT THE CATEGORIES FROM THE DATABASE -->
        <div class="sliderWrapper" id="sliderWrapper">
          <div class="category-slider" id="categorySlider">
            <?php include '../database/category.php';
            admin_category($result) ?>
          </div>
        </div>
      </div>
      <!-- SLIDER BTN -->
      <?php require '../database/sliderController.php' ?>
    </div>
    <div class="section-container" id="productContainer">
      <h2>Products</h2>
      <div class="wrapper">
        <!-- <div id="categoryWrapper">
          <h3>Category</h3>
          <div>
            <?php #category_checklist() 
            ?>
          </div>
        </div> -->
        <div class="mainProductWrapper">
          <button id="productMultiDeleteBtn" class="multi-delete-btn">Delete All</button>
          <div id="productCardWrapper">
            <div class="card" id="addProductCard" onclick="openModal(addProductModal)">
              <img src="../assets/images/no-product.png" alt="">
              <p class="add-product-label">ADD PRODUCT</p>
            </div>
            <?php admin_product() ?>
          </div>

          <div class="product-pagination">
            <?php admin_product_pagination() ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require '../includes/add-product.php' ?>
</body>

</html>