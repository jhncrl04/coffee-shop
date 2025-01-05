<?php

require "connection.php";

function load_category()
{
  global $db_conn;

  $category_name = $_GET['category'] ?? '';

  if (!$category_name) {
    $query = "SELECT * FROM category_table ORDER BY category_id ASC LIMIT 1";
    $sql = mysqli_query($db_conn, $query);

    if ($sql && mysqli_num_rows($sql) > 0) {
      $row = mysqli_fetch_assoc($sql);
      $category_name = strtolower($row['category_name']);
    }
  }

  $query = "SELECT * FROM category_table";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $category_name_db = strtolower($row['category_name']);

      if ($category_name === $category_name_db) {
        echo "<li><a href='?category=$category_name_db' class='active'>$category_name_db</a></li>";
      } else {
        echo "<li><a href='?category=$category_name_db'>$category_name_db</a></li>";
      }
    }
  } else {
    echo "<li><a href=''>Missing Category</a></li>";
  }
}

function load_product()
{
  global $db_conn;

  $category_name = $_GET['category'] ?? '';

  if (!$category_name) {
    $query = "SELECT * FROM category_table ORDER BY category_id ASC LIMIT 1";
    $sql = mysqli_query($db_conn, $query);

    if ($sql && mysqli_num_rows($sql) > 0) {
      $row = mysqli_fetch_assoc($sql);
      $category_name = $row['category_name'];
    }
  }

  $query = "SELECT * FROM product_table WHERE product_category = '$category_name'";

  $sql = mysqli_query($db_conn, $query);
  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {

      $product_id = $row['product_id'];
      $product_name = $row['product_name'];
      $product_preview = $row['product_preview'];
      $product_price = $row['product_price'];

      echo "<div class='card product flex vertical' data-product_id = '$product_id'>
              <img src='../uploads/$product_preview' alt='' class='product-img'>
              <div class='product-infoflex vertical'>
                <p class='product-name'>$product_name</p>
                <p class='product-price'>P $product_price</p>
              </div>
            </div>";
    }
  } else {
    echo "<div class='card flex vertical'>
    <img src='../assets/images/no-product.jpg' alt='' class='product-img'>
    <div class='product-infoflex vertical'>
      <p class='product-name'>Missing Product</p>
      <p class='product-price'>P 0.00</p>
    </div>
  </div>";
  }
}


if (isset($_POST['user_id'])) {
  $user_id = intval($_POST['user_id']);
  echo get_pos_price($user_id);
}

function get_pos_price($user_id)
{
  global $db_conn;

  $query = "SELECT SUM(total_price) as total_price FROM cart_table WHERE user_id = $user_id;";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    return $row['total_price'] ?? '0.00';
  }
}

function load_pos_checkout($user_id)
{
  global $db_conn;

  $query = "SELECT * FROM cart_table WHERE user_id = $user_id";
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

          if ($add) {
            $addons_string .= "$add <br>";
          }
        }
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


function get_last_order_id()
{
  global $db_conn;

  $query = "SELECT order_id FROM order_table ORDER BY order_id DESC LIMIT 1";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
    $order_id = $row['order_id'] + 1;

    echo "ORDER ID: $order_id";
  }
}

function load_receipt($user_id)
{
  global $db_conn;

  $query = "SELECT * FROM cart_table WHERE user_id = $user_id";
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

          if ($add) {
            $addons_string .= "$add <br>";
          }
        }
      }

      echo "<tr>
          <td>
            <p>$quantity</p>
          </td>
          <td>
            <span class='inline'>
              <p>$product_name</p>
              <p>(16 oz)</p>
            </span>
            <p>Flavor: $flavor</p>
            <div class='addons-wrapper'>
              <p class='label'>Addons:</p>
              <p class='addons'>$addons_string</p>
            </div>
          </td>
          <td>
            <p class='price'>$total_price</p>
          </td>
        </tr>";
    }
  }
}

function load_pos_queue()
{
  global $db_conn;

  $query = "SELECT * FROM order_table WHERE payment_method = 'CASH' AND order_status = 'APPROVED' ORDER BY last_updated ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $order_id = $row['order_id'];

      echo "<li class='order preparing-item' data-order_id = '$order_id'>$order_id</li>";
    }
  }
}

function load_pos_claimable()
{
  global $db_conn;

  $query = "SELECT * FROM order_table WHERE payment_method = 'CASH' AND order_status = 'TO COLLECT' ORDER BY last_updated DESC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $order_id = $row['order_id'];

      echo "<li class='order claimable-item' data-order_id='$order_id'>$order_id</li>";
    }
  }
}
