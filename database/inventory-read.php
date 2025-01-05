<?php

require 'connection.php';

function get_inventory_data()
{
  global $db_conn;

  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = 5 * ($page - 1);

  $query = "SELECT * FROM inventory_table LIMIT 5 OFFSET $offset";
  if (isset($_GET['type'])) {
    $type = $_GET['type'];

    $query = "SELECT * FROM inventory_table WHERE type = '$type' LIMIT 5 OFFSET $offset";
  }

  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $item_id = $row['item_id'];
      $item_img = $row['item_img'];
      $item_name = $row['name'];
      $item_type = $row['type'];
      $item_qnty = $row['stock_quantity'];
      $item_price = $row['unit_price'];

      $img_src = $item_img ? "<img src='../uploads/$item_img'>" : "<img src='../assets/images/no-image.jpg'>";

      $qnty_suffix = 'ML';
      if (strtolower($item_type) === 'cup') {
        $qnty_suffix = 'Pcs';
      } else if (strtolower($item_type) === 'add-ons' || strtolower($item_type) === 'toppings' || strtolower($item_type) === 'drizzle') {
        $qnty_suffix = 'Servings';
      }

      echo "<tr class='item-details' data-value='$item_id'>
          <td><p>$item_id</p></td>
          <td>$img_src</td>
          <td><p>$item_name</p></td>
          <td><p>$item_type</p></td>
          <td><p>$item_qnty $qnty_suffix</p></td>
          <td><p>P $item_price</p></td>
        </tr>";
    }
  } else {
    echo "<tr>
          <td><p>N/A</p></td>
          <td><p>N/A</p></td>
          <td><p>N/A</p></td>
          <td><p>N/A</p></td>
          <td><p>N/A</p></td>
          <td><p>N/A</p></td>
        </tr>";
  }
}

function get_item_types()
{
  global $db_conn;

  $query = "SELECT DISTINCT(type) AS type FROM inventory_table";
  $sql = mysqli_query($db_conn, $query);


  if ($sql && mysqli_num_rows($sql) > 0) {
    // Get the current URL and query string
    $url = basename($_SERVER['PHP_SELF']);
    $currentType = $_GET['type'] ?? '';

    // Add the "All" link
    $allClass = empty($currentType) ? 'active' : '';
    echo "<a href='admin-inventory.php' class='inventory-link $allClass'>All</a>";

    // Loop through the item types and generate links
    while ($row = mysqli_fetch_assoc($sql)) {
      $item_type = htmlspecialchars($row['type']); // Escape the item type for safety
      $typeClass = ($currentType === $item_type) ? 'active' : '';
      echo "<a href='admin-inventory.php?type=$item_type' class='inventory-link $typeClass'>$item_type</a>";
    }
  }
}
