<?php

require 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action'])) {
    if ($_GET['action'] === 'add-to-cart') {
      $user_id = $_SESSION['user_id'];
      $product_id = $_POST['productId'];
      $product_name = $_POST['productName'];
      $cup_size = $_POST['cupSize'];
      $flavor = $_POST['flavor'];
      $pump = $_POST['pump'];
      $base_price = $_POST['basePrice'];
      $total_price = explode(" ", $_POST['totalPrice']);
      $total_price = $total_price[1];
      $product_qnty = $_POST['product_qnty'];

      $mapped_addons = [];

      //array addons from form
      $addons = $_POST['add-ons'] ?? '';
      //check if $addons exist
      if ($addons) {

        //iterate to addons array
        foreach ($addons as $add) {

          //insert each addons on mapped addons
          $mapped_addons[] = ['add_ons' => $add];
        }
      }
      //convert mapped_addons into json
      $json_addons = json_encode($mapped_addons);
      $current_date = date("Y-m-d");

      $query = "SELECT cart_id, quantity, total_price FROM cart_table WHERE user_id = $user_id AND product_id = '$product_id' AND flavor = '$flavor' AND pump_count = $pump AND add_ons = '$json_addons'";

      // Check if the item exist and return the quantity and cart id
      if (is_item_exist($query) !== []) {
        $json = is_item_exist($query);
        $id = $json['id'];
        $qnty = $json['qnty'] + $product_qnty;
        $price = $json['price'] + $total_price;

        echo $json['price'];

        $query = "UPDATE cart_table SET quantity = $qnty, total_price = $price WHERE cart_id = $id";

        echo $query;
        update_cart($query);
      } else {
        $query = "INSERT INTO cart_table (user_id, product_id, product_name, base_price, cup_size, flavor, pump_count, add_ons, quantity, total_price, date_added) VALUES ($user_id, $product_id, '$product_name', $base_price, '$cup_size', '$flavor', $pump, '$json_addons', $product_qnty, $total_price, '$current_date')";

        insert_to_db($query);
      }
    } elseif ($_GET['action'] === 'remove-cart-item') {
      $data = json_decode(file_get_contents('php://input'), true);
      $id = $data['id'] ?? null;

      if ($id) {
        $success = delete_cart_item($id);
        echo json_encode([
          'success' => $success,
        ]);
      } else {
        echo json_encode([
          'success' => false,
          'message' => 'Invalid or missing cart ID',
        ]);
      }
      exit(); // Ensure no additional output is sent
    }
  }
}

function insert_to_db($query)
{
  global $db_conn;

  $sql = mysqli_query($db_conn, $query);
  if ($sql) {

    $referer = $_SERVER['HTTP_REFERER'] . "#menu" ?? 'index.php';

    header("Location: $referer");
  }
}

function update_cart($query)
{
  global $db_conn;

  $sql = mysqli_query($db_conn, $query);

  if ($sql) {

    $referer = $_SERVER['HTTP_REFERER'] . "#menu" ?? 'index.php';

    header("Location: $referer");
  }
}

function is_item_exist($query)
{
  global $db_conn;

  $sql = mysqli_query($db_conn, $query);
  if ($sql && mysqli_num_rows($sql)) {
    $row = mysqli_fetch_assoc($sql);
    $cart_id = $row['cart_id'];
    $quantity = $row['quantity'];
    $price = $row['total_price'];

    $json = [
      'id' => $cart_id,
      'qnty' => $quantity,
      'price' => $price
    ];

    return $json;
  }

  return [];
}

function delete_cart_item($ids)
{
  if (!empty($ids)) {
    global $db_conn;

    // Convert IDs array to a sanitized string for SQL
    $sanitized_ids = implode(',', array_map('intval', $ids));

    $query = "DELETE FROM cart_table WHERE cart_id IN ($sanitized_ids)";
    $sql = mysqli_query($db_conn, $query);

    if ($sql) {
      return true;
    }
    return false;
  }
  return false;
}
