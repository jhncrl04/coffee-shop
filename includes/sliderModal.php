<dialog id="addSliderModal" class="slider-modal">
  <button class="closeModal" onclick="close_modal(addSliderModal)"><i class="fa-solid fa-xmark"></i></button>
  <h1>Add Slider</h1>
  <div class="slider-item">
    <img src="../assets/images/no-product.jpg" alt="" id="sliderImg">
    <div class="text-container">
      <p class="phrase" id="phrase">Phrase Goes Here</p>
      <p class="product-name" id="productName">Product Name</p>
      <button class="order-now-btn main-btn">Order Now</button>
    </div>
  </div>
  <form action="../database/slider.php?action=add-slider" enctype="multipart/form-data" method="POST" id="addSliderForm">
    <div class="input-wrapper file">
      <label for="sliderImgInput">Slider Image</label>
      <input type="file" name="sliderImgInput" id="sliderImgInput" class="slider-img" required>
    </div>
    <div class="input-wrapper">
      <label for="productNameInput">Product:</label>
      <select name="productNameInput" id="productNameInput" class="slider-product-name" required>
        <option value="" selected disabled>Select Product</option>
        <?php admin_product_list() ?>
      </select>
    </div>
    <div class="input-wrapper">
      <label for="phraseInput">Phrase:</label>
      <textarea name="phraseInput" id="phraseInput" class="slider-phrase" required></textarea>
    </div>
    <button type="submit" id="addSliderBtn">Add Slider</button>
  </form>
</dialog>

<dialog id="editSliderModal" class="slider-modal">
  <button class="closeModal" onclick="close_modal(editSliderModal)"><i class="fa-solid fa-xmark"></i></button>
  <h1>Edit Slider</h1>
  <div class="slider-item">
    <img src="../assets/images/no-product.jpg" alt="" id="sliderImg">
    <div class="text-container">
      <p class="phrase" id="phrase">Phrase Goes Here</p>
      <p class="product-name" id="productName">Product Name</p>
      <button class="order-now-btn main-btn">Order Now</button>
    </div>
  </div>
  <form action="../database/slider.php?action=edit-slider" enctype="multipart/form-data" method="POST" id="editSliderForm">
    <input type="hidden" name="sliderId">
    <div class="input-wrapper file">
      <label for="editSliderImgInput">Slider Image</label>
      <input type="file" name="editSliderImgInput" id="editSliderImgInput" class="slider-img">
    </div>
    <div class="input-wrapper">
      <label for="editProductNameInput">Product:</label>
      <select name="editProductNameInput" id="editProductNameInput" class="slider-product-name" required>
        <option selected disabled>Select Product</option>
        <?php admin_product_list() ?>
      </select>
    </div>
    <div class="input-wrapper">
      <label for="editPhraseInput">Phrase:</label>
      <textarea name="editPhraseInput" id="editPhraseInput" class="slider-phrase" required></textarea>
    </div>
    <button type="submit" id="editSliderBtn">Save Edit</button>
  </form>
</dialog>

<dialog id="deleteSliderModal" class="slider-modal">
  <button class="closeModal" onclick="close_modal(deleteSliderModal)"><i class="fa-solid fa-xmark"></i></button>
  <h1>Delete Slider</h1>
  <form action="../database/slider.php?action=delete-slider" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="sliderId">
    <h2>Do you want to delete this slider?</h2>
    <button type="submit" id="deleteSliderBtn">Delete</button>
  </form>
</dialog>

<dialog id="confirmPasswordModal" class="slider-modal">
  <button class="closeModal" onclick="close_modal(confirmPasswordModal)"><i class="fa-solid fa-xmark"></i></button>
  <h1>Confirm Password</h1>
  <div class="input-wrapper">
    <label for="changeConfirmPassword">Password</label>
    <input autofocus type="password" id="changeConfirmPassword">
    <button class="main-btn" id="confirmChangeBtn" type="submit">Confirm</button>
  </div>
</dialog>