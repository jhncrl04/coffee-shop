<?php
require 'connection.php';

function load_orders()
{
  global $db_conn;
  $query = "SELECT 
      order_table.order_id,
      order_table.customer_name,
      order_table.order_details,
      order_table.total_price,
      order_table.contact,
      order_table.order_address,
      order_table.payment_method,
      order_table.payment_proof,
      order_table.order_status,
      order_table.date_added
  FROM 
      order_table
  JOIN 
      user_table ON order_table.user_id = user_table.user_id
  ORDER BY 
    order_table.order_id DESC
    ;";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $order_id = $row['order_id'];
      $customer_name = $row['customer_name'];
      $address = $row['order_address'];
      $contact = $row['contact'];
      $order_details = json_decode($row['order_details'], true);
      $total_price = $row['total_price'];
      $payment_method = $row['payment_method'];
      $payment_proof = base64_encode($row['payment_proof']);
      $order_status = $row['order_status'];
      $date_added = $row['date_added'];

      $payment_proof_img = "<img src='data:image/jpeg;base64,$payment_proof' class='payment-proof-img'>";
      if (!$payment_proof) {
        $payment_proof_img = "<p>WALK-IN</p>";
      }

      $product_details = "<div class='flex center'>";
      $addons = "";

      $totalOrders = count($order_details); // Get the total number of orders
      $currentOrderIndex = 0; // Initialize an index to track the current iteration

      foreach ($order_details as $order) {
        $currentOrderIndex++; // Increment the index for each order

        $name = $order['product_name'];
        $size = explode(' ', $order['size']);
        $size = $size[0];
        $flavor = $order['flavor'];
        $pump = $order['pump_count'];
        $qnty = $order['quantity'] . "x";

        $product_details .= "
        
        <div class='flex vertical order-info'>
          <input type='hidden' value='$pump' id='pumpCount'>
          <div class='flex'><p class='quantity'>$qnty</p><p class='product-name'>$name</p><p>-</p><p class='flavor'>$flavor</p></div>
          <p class='size'>$size</p>
          <p class='add-ons-wrapper'> Add-ons:</p>
          <div class='flex flexwrap'>
        ";

        foreach ($order['addons'] as $add) {
          $addons .= "<p class='addons'>" . $add['add_ons'] . "</p>";
        }

        if ($currentOrderIndex < $totalOrders) {
          $product_details .= "$addons</div></div></div><div class='flex center'>";
        } elseif ($currentOrderIndex === $totalOrders) {
          $product_details .= "$addons</div></div>";
        }

        $addons = '';
      }

      // use table on product detail and addons

      echo "
      <tr class='orders' data-order_id = '$order_id' data-order_status = '$order_status'>
        <td class='sticky'>
          <p>
            $order_id
          </p>
        </td>
        <td class='vertical customer-details sticky'>
          <div>
            <p>Name:</p><p class='customer-name'>$customer_name</p><br>
            <p>Address:</p><p class='customer-address'>$address</p><br>
            <p>Contact:</p><p class='customer-contact'>$contact</p><br>
          </div>
        </td>
        <td class='flex vertical order-details'>
            $product_details
        </td>
        <td class='sticky'>
          <p class='total-price'>
            P $total_price
          </p>
        </td>
        <td class='sticky'>
          <p class='payment-method'>
            $payment_method
          </p>
        </td>
        <td class='sticky'>
          $payment_proof_img
        </td>
        <td class='sticky'>
          <p class='order-status'>
            $order_status
          </p>
        </td>
        <td class='sticky'>
          <p class='date-added'>
            $date_added
          </p>
        </td>
      </tr>
      ";
    }
  }
}

function load_sale_history()
{
  global $db_conn;
  $query = "SELECT 
      user_table.user_id,
      order_table.order_id,
      order_table.customer_name,
      order_table.order_details,
      order_table.total_price,
      order_table.contact,
      order_table.order_address,
      order_table.payment_method,
      order_table.payment_proof,
      order_table.order_status,
      order_table.date_added,
      user_table.user_role
  FROM 
      order_table
  JOIN 
      user_table ON order_table.user_id = user_table.user_id
  WHERE
      order_table.order_status = 'COMPLETED'
  ORDER BY 
    order_table.order_id DESC
    ;";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $order_id = $row['order_id'];
      $customer_id = $row['user_id'];
      $user_role = $row['user_role'];
      $customer_name = $row['customer_name'];
      $address = $row['order_address'];
      $contact = $row['contact'];
      $order_details = json_decode($row['order_details'], true);
      $total_price = $row['total_price'];
      $payment_method = $row['payment_method'];
      $payment_proof = base64_encode($row['payment_proof']);
      $order_status = $row['order_status'];
      $date_added = $row['date_added'];

      $order_method = $payment_proof ? "Online" : "Walk-In";

      $payment_proof_img = "<img src='data:image/jpeg;base64,$payment_proof' class='payment-proof-img'>";
      if (!$payment_proof) {
        $payment_proof_img = "<p>CASH</p>";
      }

      $product_details = "<div class='flex center'>";
      $addons = "";

      $totalOrders = count($order_details); // Get the total number of orders
      $currentOrderIndex = 0; // Initialize an index to track the current iteration

      foreach ($order_details as $order) {
        $currentOrderIndex++; // Increment the index for each order

        $name = $order['product_name'];
        $size = explode(' ', $order['size']);
        $size = $size[0];
        $flavor = $order['flavor'];
        $pump = $order['pump_count'];
        $qnty = $order['quantity'] . "x";

        $product_details .= "
        
        <div class='flex vertical order-info'>
          <input type='hidden' value='$pump' id='pumpCount'>
          <div class='flex'><p class='quantity'>$qnty</p><p class='product-name'>$name</p><p>-</p><p class='flavor'>$flavor</p></div>
          <p class='size'>$size</p>
          <p class='add-ons-wrapper'> Add-ons:</p>
          <div class='flex flexwrap'>
        ";

        foreach ($order['addons'] as $add) {
          $addons .= "<p class='addons'>" . $add['add_ons'] . "</p>";
        }

        if ($currentOrderIndex < $totalOrders) {
          $product_details .= "$addons</div></div></div><div class='flex center'>";
        } elseif ($currentOrderIndex === $totalOrders) {
          $product_details .= "$addons</div></div>";
        }

        $addons = '';
      }

      // use table on product detail and addons

      echo "
      <tr class='orders' data-order_id = '$order_id' data-order_status = '$order_status'>
        <td class='sticky'>
          <p>
            $customer_id
          </p>
        </td>
        <td class='sticky'>
          <div>
            <p class='customer-name'>$customer_name</p>
          </div>
        </td>
        <td class='flex vertical order-details'>
            $product_details
        </td>
        <td class='sticky'>
          <p class='total-price'>
            P $total_price
          </p>
        </td>
        <td class='sticky'>
          <p class='order-method'>
            $order_method
          </p>
        </td>
        <td class='sticky'>
          $payment_proof_img
        </td>
        <td class='sticky'>
          <p class='date-added'>
            $date_added
          </p>
        </td>
      </tr>
      ";
    }
  }
}
