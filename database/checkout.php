<?php
require 'connection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart_ids = $_POST['cart-ids'] ?? [];
  $total_price = $_POST['total-price'];
  $customer_name = $_POST['customer-name'];
  $address = $_POST['address'] ?? 'walk-in';
  $contact = $_POST['contact'] ?? '';
  $payment_method = strtoupper($_POST['payment-method'] ?? "cash");

  if (isset($_FILES) && ($_FILES['payment-proof'] ?? '')) {
    $file = $_FILES['payment-proof'];
    $fileNAME = $_FILES['payment-proof']['name'];
    $fileTMPNAME = $_FILES['payment-proof']['tmp_name'];
    $fileERROR = $_FILES['payment-proof']['error'];
    $fileSIZE = $_FILES['payment-proof']['size'];

    $fileEXT = explode('.', $fileNAME);
    $fileACTUALEXT = strtolower(end($fileEXT));

    $fileALLOWED = array('jpg', 'jpeg', 'png');

    if (in_array($fileACTUALEXT, $fileALLOWED)) {
      $fileDATA = file_get_contents($fileTMPNAME);

      $fileDataEscaped = mysqli_real_escape_string($db_conn, $fileDATA);
    }
  }

  $cart_details = json_encode(get_order_details($cart_ids));
  $current_date = date("Y-m-d");

  $query = "INSERT INTO order_table (user_id, customer_name, order_details, total_price, order_address, order_status, payment_method, date_added) VALUES ($user_id, '$customer_name', '$cart_details', $total_price, '$address', 'APPROVED', '$payment_method', '$current_date')";

  if (!empty($cart_ids)) {
    $query = "INSERT INTO order_table (user_id, customer_name, order_details, total_price, contact, order_address, payment_method, payment_proof, date_added) VALUES ($user_id, '$customer_name', '$cart_details', $total_price, '$contact', '$address', '$payment_method', '$fileDataEscaped', '$current_date')";
  }

  if (insert_to_db($query)) {
    delete_cart_item($cart_ids);
  }
}

function get_order_details($ids)
{
  global $db_conn;
  global $user_id;

  $query = "SELECT * FROM cart_table WHERE user_id = $user_id";

  if (!empty($ids)) {
    $query = "SELECT * FROM cart_table WHERE cart_id IN ($ids)";
  }
  $sql = mysqli_query($db_conn, $query);

  $cart_details = [];
  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $product_name = $row['product_name'];
      $product_id = $row['product_id'];
      $size = $row['cup_size'];
      $flavor = $row['flavor'];
      $pump_count = $row['pump_count'];
      $addons = json_decode($row['add_ons'], true);
      $quantity = $row['quantity'];
      $total_price = $row['total_price'];

      $json_addons = [];

      foreach ($addons as $add) {
        $json_addons[] = [
          'add_ons' => $add['add_ons'],
        ];
      }

      $cart_details[] = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'size' => $size,
        'flavor' => $flavor,
        'pump_count' => $pump_count,
        'addons' => $json_addons,
        'quantity' => $quantity,
      ];
    }
  }
  return $cart_details;
}

function insert_to_db($query)
{
  global $db_conn;

  return mysqli_query($db_conn, $query);
}

function delete_cart_item($ids)
{
  global $db_conn;
  global $user_id;

  $query = "DELETE FROM cart_table WHERE user_id = $user_id";

  if (!empty($ids)) {
    $query = "DELETE FROM cart_table WHERE cart_id IN ($ids)";
  }
  $sql = mysqli_query($db_conn, $query);

  if ($sql) {
    if (!empty($ids)) {
      echo "<script> window.location.href = '../pages/menu.php#menu' </script>";
    } else {
      echo "<script> window.location.href = '../pages/admin-pos.php' </script>";
    }
  }
}
