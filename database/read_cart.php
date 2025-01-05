<?php

require 'connection.php';

function load_cart($user_id, $cart_type)
{
  global $db_conn;

  $query = "SELECT * FROM cart_table WHERE user_id = $user_id ORDER BY date_added ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {

    while ($row = mysqli_fetch_assoc($sql)) {
      $cart_id = $row['cart_id'];
      $product_name = $row['product_name'];
      $flavor = $row['flavor'];
      $qnty = $row['quantity'] . 'x';
      $total_price = $row['total_price'];
      $cupSize = explode(' ', $row['cup_size']);
      $cupSize = $cupSize[0];

      if ($cart_type === 'customer-menu') {
        echo "
        <li data-price='$total_price' data-cart_id='$cart_id'>
          <i class='fa-regular fa-circle-info view-item'></i>
          <div class='vertical'>
            <div class='inline qnty'>
              <span class='cd-qty'>$qnty</span>
              <p class='cart-product-name'>$product_name</p>
            </div>
            <div class='inline gap'>
            <p class='cart-flavor'>$flavor</p>
            <p class='cart-size'>$cupSize</p>
            </div>
            <div class='cd-price'>P $total_price</div>
          </div>
          <i class='fa-solid fa-x cd-item-remove cd-img-replace'></i>
        </li>
        ";
      } elseif ($cart_type === 'pos') {

        $addons = json_decode($row['add_ons'], true);
        $addons_list = '';

        foreach ($addons as $add) {
          $addons_name = $add['add_ons'];
          $addons_list .= "<p class='addons'>$addons_name</p>";
        }

        if (!$addons_list) {
          $addons_list = "<p class='addons'>no addons</p>";
        }

        echo "<li class='order-item flex vertical' data-cart_id='$cart_id'>
            <button class='remove-order-btn'>
              <i class='fa-solid fa-x'></i>
            </button>
            <div class='inline'>
              <div class='order-detail'>
                <span class='inline'>
                  <p class='product-name'>$product_name</p>
                  <p class='quantity'>($qnty)</p>
                </span>
                <span class='inline'>
                  <p class='flavor'>Vanilla</p>
                  <p class='size'>$cupSize</p>
                </span>
                <div class='inline addons-wrapper'>
                  $addons_list
                </div>
              </div>
              <div class='price'>P $total_price</div>
            </div>
            <hr>
          </li>";
      }
    }
  }
}

function load_checkout($ids)
{
  global $db_conn;

  $query = "SELECT * FROM cart_table WHERE cart_id IN ($ids)";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {

      $product_name = $row['product_name'];
      $size = explode(" ", $row['cup_size']);
      $size = $size[0];
      $flavor = $row['flavor'];
      $quantity = $row['quantity'];
      $total_price = $row['total_price'];

      if ($row['add_ons']) {
        $json_addons = json_decode($row['add_ons'], true);
        $addons_string = '';

        foreach ($json_addons as $addons) {
          $add = $addons['add_ons'];
          $addons_string .= "$add <br>";
        }
      } else {
        $addons_string = 'none';
      }


      echo "
      <tr>
        <td><p>$product_name</p></td>
        <td><p>$size</p></td>
        <td><p>$flavor</p></td>
        <td><p>$addons_string</p></td>
        <td><p>$quantity</p></td>
        <td><p>P $total_price</p></td>
      <tr>
      ";
    }
  }
}

function get_checkout_total_price($ids)
{
  global $db_conn;

  $query = "SELECT SUM(total_price) as total_price FROM cart_table WHERE cart_id IN ($ids)";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    return $row['total_price'];
  }

  return 0.00;
}
