<dialog id="receiptModal" class="modal">
  <div class="customer-info flex vertical">
    <h3 class="order-id">
      <?php get_last_order_id() ?>
    </h3>
    <div class="inline name-date">
      <div>
        <p class="customer-name">John Carlo Servidad</p>
      </div>
      <div>
        <div class="order-date-wrapper">
          <p class="order-date">01/01/2024</p>
        </div>
      </div>
    </div>
  </div>
  <div class="order-info flex vertical">
    <hr>
    <table class="pos-order-table">
      <thead>
        <tr>
          <td>Qty</td>
          <td>Item</td>
          <td>Price</td>
        </tr>
      </thead>
      <tbody>
        <?php load_receipt($user_id) ?>
      </tbody>
    </table>
    <hr>
    <div class="payment-info">
      <p class="total-price">Total: <?php echo get_pos_price($user_id) ?></p>
      <p class="change">Change: P 9.00</p>
    </div>
    <div class="inline button-container">
      <button onclick="closeModal(receiptModal)" id="closeModal" class="secondary-btn">Close</button>
      <button id="confirmBtn" class="main-btn">Confirm</button>
    </div>
  </div>
</dialog>