<dialog id="addToCartModal" class="modal">
  <div class="product-info">
    <img src="" alt="" class="product-preview">
    <div class="product-info-text">
      <div>
        <p class="product-name"></p>
        <p class="product-category"></p>
      </div>
      <p class="product-price"></p>
    </div>
  </div>
  <form action="../database/cart.php?action=add-to-cart" method="POST">
    <input type="hidden" name="productId" id="productId">
    <input type="hidden" name="productName" id="productName">
    <input type="hidden" name="basePrice" id="basePrice">
    <button type="reset" onclick="close_modal(addToCartModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
    <div class="input-wrapper">
      <p class="label">Size *</p>
      <div class="inline size-wrapper">
      </div>
    </div>
    <div class="inline flavor-wrapper">
      <div class="input-wrapper flavor">
        <label for="flavor">Flavor *</label>
        <select name="flavor" id="flavor">
        </select>
      </div>
      <div class="input-wrapper pump">
        <label for="pump">Pumps *</label>
        <input type="number" name="pump" id="pump" value="1" min="1" max="5">
      </div>
    </div>
    <div class="input-wrapper">
      <p class="label">Add-Ons</p>
      <div class="checkbox-wrapper addons-wrapper">
        <?php display_add_ons() ?>
      </div>
    </div>
    <hr>
    <div class="inline">
      <div class="input-wrapper">
        <p class="label">Total Price:</p>
        <input type="text" class="input" name="totalPrice" id="totalPrice" readonly>
      </div>
      <div class="input-wrapper quantity-wrapper">
        <p class="label">Quantity:</p>
        <div class="inline">
          <button type="button" id="decreaseQnty" disabled><i class="fa-regular fa-minus"></i></button>
          <input type="number" value="1" min="1" max="10" class="input" name="product_qnty" id="product-qnty">
          <button type="button" id="increaseQnty"><i class="fa-regular fa-plus"></i></button>
        </div>
      </div>
    </div>
    <div class="inline">
      <input type="reset" class="secondary-btn" value="Cancel" onclick="close_modal(addToCartModal)">
      <input type="submit" class="main-btn" value="Add To Cart">
    </div>
  </form>
</dialog>