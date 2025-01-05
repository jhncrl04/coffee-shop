<div class="backdrop"></div>
<dialog id="orderInfoModal" class="modal">
  <div class="customer-info flex vertical">
    <span class="inline">
      <p class="label">Order ID:</p>
      <p class="order-id">1</p>
    </span>
    <span class="inline">
      <p>Name:</p>
      <p class="customer-name"></p>
    </span>
    <span class="inline">
      <p>Address:</p>
      <p class="customer-address"></p>
    </span>
    <span class="inline">
      <p>Contact:</p>
      <p class="customer-contact"></p>
    </span>
    <hr>
  </div>
  <div class="order-wrapper flex vertical">
  </div>
  <div class="inline">
    <p class="label">Payment Method:</p>
    <p class="payment-method">GCASH</p>
  </div>
  <div class="inline">
    <p class="label">Order Status:</p>
    <p class="order-status">PENDING</p>
  </div>
  <div class="inline">
    <p class="label">Order Date:</p>
    <p class="order-added">2024-12-26</p>
  </div>
  <div class="inline">
    <p class="label">Price:</p>
    <p class="total-price">P 999.99</p>
  </div>
  <hr>
  <div class="inline">
    <button onclick="orderInfoModal.close()" class="close-btn">Close</button>
  </div>
</dialog>