<dialog id="addItemModal" class="modal">
  <button type="reset" onclick="close_modal(addItemModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
  <h1>ADD ITEM</h1>

  <form action="../database/inventory.php?action=add-item" enctype="multipart/form-data" method="POST">
    <div class="input-wrapper">
      <input type="file" id="itemImage" name="itemImage">
      <label for="itemImage">Select Image *</label>
    </div>
    <div class="input-wrapper">
      <label for="itemName">Name *</label>
      <input type="text" name="itemName" id="itemName" required>
    </div>
    <div class="input-wrapper">
      <label for="itemType">Type *</label>
      <Select name="itemType" id="itemType" required>
        <option value="cup">Cup</option>
        <option value="flavor">Flavor</option>
        <option value="toppings">Toppings</option>
        <option value="whipped cream">Whipped Cream</option>
        <option value="add-ons">Add-ons</option>
      </Select>
    </div>
    <div class="input-wrapper">
      <label for="quantity">Quantity *</label>
      <input type="text" id="quantity" name="quantity" required>
    </div>
    <div class="input-wrapper">
      <label for="price">Price *</label>
      <input type="text" id="price" name="price" required>
    </div>
    <button type="submit" class="main-btn">Add Item</button>
  </form>
</dialog>

<dialog id="editItemModal" class="modal">
  <button type="reset" onclick="close_modal(editItemModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
  <h1>EDIT/RESTOCK ITEM</h1>

  <form action="../database/inventory.php?action=edit-item" enctype="multipart/form-data" method="POST">
    <input type="hidden" id="itemId" name="itemId">
    <div class="input-wrapper">
      <input type="file" id="editImage" name="editImage">
      <label for="editImage">Select Image *</label>
    </div>
    <div class="input-wrapper">
      <label for="itemName">Name *</label>
      <input type="text" name="itemName" id="itemName" required>
    </div>
    <div class="input-wrapper">
      <label for="itemType">Type *</label>
      <Select name="itemType" id="itemType" required>
        <option value="cup">Cup</option>
        <option value="flavor">Flavor</option>
        <option value="toppings">Toppings</option>
        <option value="whipped cream">Whipped Cream</option>
        <option value="add-ons">Add-ons</option>
      </Select>
    </div>
    <div class="input-wrapper">
      <label for="quantity">Quantity *</label>
      <input type="text" id="quantity" name="quantity" required>
    </div>
    <div class="input-wrapper">
      <label for="price">Price *</label>
      <input type="text" id="price" name="price" required>
    </div>
    <button type="submit" class="main-btn">Save Changes</button>
  </form>
</dialog>

<dialog id="deleteItemModal" class="modal">
  <button type="reset" onclick="close_modal(deleteItemModal)" class="close-modal-btn"><i class="fa-solid fa-x"></i></button>
  <h1>DELETE ITEM</h1>
  <form action="../database/inventory.php?action=delete-item" method="POST">
    <div class="input-wrapper">
      <img src="" alt="" id="deleteItemImg">
    </div>
    <input type="hidden" name="itemId" id="itemId" readonly required>
    <div class="input-wrapper">
      <label for="itemName">Name *</label>
      <input type="text" name="itemName" id="itemName" readonly required>
    </div>
    <div class="input-wrapper">
      <label for="itemType">Type *</label>
      <input type="text" name="itemType" id="itemType" readonly required>
    </div>
    <button type="submit" class="main-btn">Delete Item</button>
  </form>
</dialog>