<?php include '../database/read_cart.php' ?>

<link rel="stylesheet" href="../assets/css/cart.css">
<script src="../assets/js/cart.js" defer></script>
<div class="cart-container">
  <div id="backdrop" onclick="closeCart()"></div>
  <div id="cd-cart">
    <div class="cart-top">
      <span class="flex space-between">
        <div class="flex gap">
          <h2>My Cart</h2>
          <i class="fa-regular fa-cart-shopping"></i>
        </div>
        <i class="fa-solid fa-x closebtn" onclick="closeCart()"> </i>
      </span>
      <ul class="cd-cart-items">
        <?php load_cart($_SESSION['user_id'], 'customer-menu') ?>
      </ul>
    </div>
    <!-- cd-cart-items -->

    <div class="cart-bottom">
      <div class="cd-cart-total">
        <p>Total: <span id="cartTotalPrice">P 00.00</span></p>
      </div>
      <!-- cd-cart-total -->

      <div class="flex">
        <button type="button" id="checkoutbtn" class="checkout-btn">Checkout</>

          <button type="button" id="removeMultipleItemBtn" class="cd-remove-items">Remove Items</button>
      </div>
    </div>
  </div>
  <!-- cd-cart -->
</div>