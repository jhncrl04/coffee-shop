<dialog id="addNewCategoryModal" class="modal">
  <button type="reset" onclick="closeModal(addCategoryModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
  <h1>ADD NEW CATEGORY</h1>
  <form action="../database/admin-menu.php?action=add-category" enctype="multipart/form-data" method="POST">
    <div class="input-wrapper">
      <label for="categoryName">Category *</label>
      <input type="text" name="categoryName" id="categoryName" required>
    </div>
    <div class="input-wrapper">
      <input type="file" id="categoryPreview" name="categoryPreview" required>
      <label for="categoryPreview">Select preview image *</label>
    </div>
    <button type="submit" class="main-btn">Add Category</button>
  </form>
</dialog>

<!-- edit category modal -->
<dialog id="editCategoryModal" class="modal">
  <button type="reset" onclick="closeModal(editCategoryModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
  <h1>EDIT CATEGORY</h1>
  <form action="../database/admin-menu.php?action=edit-category" enctype="multipart/form-data" method="POST">
    <div class="input-wrapper">
      <label for="editCategoryName">Category Name *</label>
      <input type="text" name="oldCategoryName" id="oldCategoryName" class="category-name" readonly>
    </div>
    <div class="input-wrapper">
      <label for="editCategoryName">New Category Name *</label>
      <input type="text" name="editCategoryName" id="editCategoryName" placeholder="Category name">
    </div>
    <div class="input-wrapper">
      <input type="file" id="editCategoryPreview" name="editCategoryPreview">
      <label for="editCategoryPreview">Select preview image *</label>
    </div>
    <button type="submit" class="main-btn">Edit Category</button>
  </form>
</dialog>

<!-- delete category modal -->
<dialog id="deleteCategoryModal" class="modal">
  <button type="reset" onclick="closeModal(deleteCategoryModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
  <h1>DELETE CATEGORY</h1>
  <form action="../database/admin-menu.php?action=delete-category" enctype="multipart/form-data" method="POST">
    <div class="input-wrapper">
      <label for="deleteCategoryName">Category *</label>
      <input type="text" name="deleteCategoryName" id="deleteCategoryName" class="category-name" readonly>
    </div>
    <button type="submit" class="main-btn">Delete Category</button>
  </form>
</dialog>

<!-- add product modal -->
<dialog id="addProductModal" class="modal">

  <h1>ADD NEW PRODUCT</h1>
  <form action="../database/admin-menu.php?action=add-product" enctype="multipart/form-data" method="POST">
    <button type="reset" onclick="closeModal(addProductModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
    <div class="inline">
      <div class="input-wrapper">
        <label for="productName">Product Name *</label>
        <input type="text" name="productName" id="productName" required>
      </div>
      <div class="input-wrapper">
        <label for="category">Category *</label>
        <select name="category" id="category">
          <?php category_options() ?>
        </select>
      </div>
    </div>
    <div class="inline">
      <div class="input-wrapper">
        <label for="productPrice">Price *</label>
        <input type="text" name="productPrice" id="productPrice">
      </div>
      <div class="input-wrapper">
        <label>Preview *</label>
        <input type="file" id="productPreview" name="productPreview" required>
        <label for="productPreview">Select preview image *</label>
      </div>
    </div>
    <div class="input-wrapper">
      <label for="">Flavor *</label>
      <div class="flavor-wrapper checkbox-wrapper">
        <?php display_flavors('add') ?>
      </div>
    </div>
    <div class="input-wrapper">
      <label for="productDescription">Product Description *</label>
      <textarea type="text" name="productDescription" id="productDescription" required></textarea>
    </div>

    <button type="submit" class="main-btn">Add Product</button>
  </form>
</dialog>

<!-- product edit & delete modal -->
<dialog id="productModal" class="modal">
  <h1>EDIT OR DELETE PRODUCT</h1>
  <form action="../database/admin-menu.php?action=edit-product" enctype="multipart/form-data" method="POST">
    <button type="reset" onclick="closeModal(productModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
    <div class="inline">
      <div class="input-wrapper">
        <label for="productName">Product Name *</label>
        <input type="text" name="productName" id="productName">
      </div>
      <div class="input-wrapper">
        <label for="category">Category *</label>
        <select name="category" id="category">
          <?php category_options() ?>
        </select>
      </div>
    </div>
    <div class="inline">
      <div class="input-wrapper">
        <label for="productPrice">Price *</label>
        <input type="text" name="productPrice" id="productPrice">
      </div>
      <div class="input-wrapper">
        <label for="">Image</label>
        <input type="file" id="editProductPreview" name="editProductPreview">
        <label for="editProductPreview">Select preview image *</label>
      </div>
    </div>
    <div class="input-wrapper">
      <label for="">Flavor *</label>
      <div class="flavor-wrapper checkbox-wrapper">
        <?php display_flavors('edit') ?>
      </div>
    </div>
    <div class="input-wrapper">
      <label for="productDescription">Product Description *</label>
      <textarea type="text" name="productDescription" id="productDescription"></textarea>
    </div>

    <div class="inline">
      <input type="submit" name="process" value="Save Change" class="main-btn">
      <input type="submit" name="process" value="Delete Product" class="secondary-btn">
    </div>
  </form>
</dialog>