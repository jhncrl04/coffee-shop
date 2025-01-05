<?php

require 'connection.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if (isset($_GET['action'])) {
    $new_status = strtoupper($_GET['action']);
    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    $order_ids = array_map('intval', $data['orderIds']); // Ensure all IDs are integers

    $order_ids = implode(",", $order_ids);

    $query = "UPDATE order_table SET order_status = '$new_status', last_updated =  CURRENT_TIMESTAMP() WHERE order_id IN ($order_ids)";

    if (mysqli_query($db_conn, $query)) {

      if ($new_status === 'COMPLETED') {
        $query = "SELECT order_details FROM order_table WHERE order_id IN ($order_ids)";
        update_inventory_stock($query);
        update_sales_table($order_ids);
      }

      echo json_encode([
        'success' => true,
        'status' => $new_status,
        'query' => $query
      ]);
    } else {
      echo json_encode([
        'success' => false,
      ]);
    }
  }
}
function update_inventory_stock($query)
{
  global $db_conn;

  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $order_details = json_decode($row['order_details'], true);

      foreach ($order_details as $order) {
        // print_r($order);
        $cup_size = $order['size'];
        $flavor = $order['flavor'];
        $pump_count = intval($order['pump_count']);
        $addons = $order['addons'];
        $quantity = intval($order['quantity']);

        $cup_query = "UPDATE inventory_table SET stock_quantity = stock_quantity - $quantity WHERE name LIKE '$cup_size' AND type = 'cup';";
        $flavor_query = "UPDATE inventory_table SET stock_quantity = stock_quantity - ($pump_count * $quantity) WHERE name LIKE '$flavor %' AND type = 'flavor';";

        $addons_queries = [];
        foreach ($addons as $add) {
          $add = implode(',', $add);
          $addons = $add;

          $addons_queries[] = "UPDATE inventory_table SET stock_quantity = stock_quantity - $quantity WHERE name = '$addons'";
        }

        // Execute each query
        if (!mysqli_query($db_conn, $cup_query)) {
          return "Error updating cup stock: " . mysqli_error($db_conn);
        }

        if (!mysqli_query($db_conn, $flavor_query)) {
          return "Error updating flavor stock: " . mysqli_error($db_conn);
        }

        foreach ($addons_queries as $addon_query) {
          if (!mysqli_query($db_conn, $addon_query)) {
            return "Error updating addon stock: " . mysqli_error($db_conn);
          }
        }
      }
    }
  }
  return true;
}

function update_sales_table($ids)
{
  global $db_conn;

  if ($ids) {
    $query = "SELECT * FROM order_table WHERE order_id IN ($ids)";
    $sql = mysqli_query($db_conn, $query);

    if ($sql && mysqli_num_rows($sql) > 0) {
      while ($row = mysqli_fetch_assoc($sql)) {
        $order_details = json_decode($row['order_details'], true);

        foreach ($order_details as $order) {
          $product_id = $order['product_id'];
          $quantity = intval($order['quantity']);

          $query = "UPDATE sales_table SET total_quantity = total_quantity + $quantity WHERE product_id = $product_id";
          mysqli_query($db_conn, $query);
        }
      }
    }
  }
}
