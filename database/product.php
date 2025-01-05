<?php
require 'connection.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  // Decode the JSON request body
  $data = json_decode(file_get_contents('php://input'), true);

  if (isset($_GET['action']) && $_GET['action'] === 'get-product-info') {
    $productName = $data['productName'] ?? null;

    if ($productName) {
      // Call your PHP function to get product info
      $productInfo = [
        'productInfo' => get_product_info($productName),
        'cupSizes' => get_available_cups(),
        'flavors' => get_product_flavors($productName),
      ];

      // Return a JSON response
      echo json_encode([
        'success' => true,
        'productInfo' => $productInfo,
      ]);
    } else {
      // Handle missing product name
      echo json_encode([
        'success' => false,
        'message' => 'Product name is required.',
      ]);
    }
  }
  if (isset($_GET['action']) && $_GET['action'] === 'get-flavor-price') {
    $flavor = $data['flavor'] ?? null;

    if ($flavor) {
      // Return a JSON response
      echo json_encode([
        'success' => true,
        'flavorPrice' => get_flavor_price($flavor),
      ]);
    } else {
      // Handle missing product name
      echo json_encode([
        'success' => false,
        'message' => 'Flavor name is required.',
      ]);
    }
  }
}

function product_menu()
{
  global $db_conn;

  $category_query = "SELECT * FROM category_table ORDER BY category_name ASC LIMIT 1";
  $query = mysqli_query($db_conn, $category_query);
  $row = mysqli_fetch_assoc($query);

  global $product_category;

  if (isset($_GET['category'])) {
    $product_category = $_GET['category'];
  } elseif (!isset($_GET['category'])) {
    $product_category = $row['category_name'] ?? '';
  }

  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = 6 * ($page - 1);

  $search = $_GET['s'] ?? '';

  if ($search) {
    $product_query = "SELECT * FROM product_table WHERE product_name = '$search'";
  } else {
    $product_query = "SELECT * FROM product_table WHERE product_category = '$product_category' LIMIT 6 OFFSET $offset";
  }

  $query = mysqli_query($db_conn, $product_query);

  if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {

      $product_preview = $row['product_preview'];
      $product_name = $row['product_name'];
      $product_description = $row['product_description'];
      $product_price = $row['product_price'];

      echo "
          <div class='card product'>
            <img src='../uploads/$product_preview' alt=''>
            <div class='product-info'>
              <div class='name-description-wrapper'>
                <p class='product-name'>$product_name</p>
                <p class='product-description'>$product_description
                </p>
              </div>
              <div class='inline'>
                <p class='product-price'>P$product_price</p>
                <button class='cta main-btn'>ADD TO CART</button>
              </div>
            </div>
          </div>";
    }
  } else {
    echo "
          <div class='card'>
            <div class='img-container error'>
              <img src='../assets/images/no-product.png' class='error-img' alt=''>
            </div>
            <div class='product-info'>
              <div class='name-description-wrapper'>
                <p class='product-name'>Ooops! It's empty</p>
                <p class='product-description'>Seems like there are no product under this category.
                <br>
                Check again later.
                </p>
              </div>
            </div>
          </div>";
  }
}

function admin_product()
{
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = 5 * ($page - 1);

  $product_query = "SELECT * FROM product_table LIMIT 5 OFFSET $offset";
  global $db_conn;

  $query = mysqli_query($db_conn, $product_query);

  while ($row = mysqli_fetch_assoc($query)) {

    $product_preview = $row['product_preview'];
    $product_name = $row['product_name'];
    $product_category = $row['product_category'];
    $product_description = $row['product_description'];
    $product_price = $row['product_price'];
    $product_id = $row['product_id'];

    echo "<div class='card product-card' data-value='$product_id'>
          <input class='product-card-selector' type='checkbox'>
          <img src='../uploads/$product_preview' alt=''>
          <div class='product-info'>
            <div>
              <h1 class='product-name'>$product_name</h1>
              <p class='product-category'>$product_category</p>
            </div>
            <p class='product-description'>$product_description</p>
            <p class='product-price'>P$product_price</p>
          </div>
        </div>";
  }
}

function admin_product_list()
{
  $product_query = "SELECT * FROM product_table";
  global $db_conn;

  $query = mysqli_query($db_conn, $product_query);

  if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {

      $product_name = $row['product_name'];
      $product_id = $row['product_id'];

      echo "<option value='$product_name'>
            $product_name
          </option>";
    }
  } else {
    echo "<option value=''>
            No Product
          </option>";
  }
}

function price_per_cup()
{

  global $db_conn;

  $query = "SELECT DISTINCT(name) FROM inventory_table WHERE type = 'cup'";
  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $size = $row['name'];

      echo "
      <div class='input-wrap'>
      <label for='$size'>$size</label>
      <input type='text' name='$size' id='$size'>
      </div>
      ";
    }
  } else {
    echo '<input type="text" name="productPrice" id="productPrice">';
  }
}

function display_flavors($action)
{
  global $db_conn;

  $query = "SELECT DISTINCT(name) FROM inventory_table WHERE type = 'flavor'";
  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $flavor = str_ireplace(' syrup', '', $row['name']);

      echo "
      <div class='inline'>
      <input type='checkbox' id='$flavor$action' name='flavors[]' value='$flavor'>
      <label for='$flavor$action'>$flavor</label>
      </div>
      ";
    }
  } else {
    echo '<input type="text" name="productPrice" id="productPrice">';
  }
}


function get_product_info($product_name)
{
  global $db_conn;

  $query = "SELECT * FROM product_table WHERE product_name = '$product_name'";
  $sql = mysqli_query($db_conn, $query);
  if ($sql && mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    return $row;
  }
}

function get_available_cups()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type = 'cup' AND stock_quantity > 0";
  $sql = mysqli_query($db_conn, $query);
  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $result[] = $row;
    }

    return $result;
  }
}

function get_product_flavors($productName)
{
  global $db_conn;

  $query = "SELECT DISTINCT(flavor) as flavor FROM product_flavor_table WHERE product_name = '$productName'";
  $sql = mysqli_query($db_conn, $query);
  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $result[] = $row;
    }

    return $result;
  }
}

function get_flavor_price($flavor)
{
  global $db_conn;

  $query = "SELECT unit_price FROM inventory_table WHERE name = '$flavor Syrup'";
  $sql = mysqli_query($db_conn, $query);
  $row = mysqli_fetch_assoc($sql);

  return $row['unit_price'];
}
function display_add_ons()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type IN('toppings', 'add-ons', 'drizzle') AND stock_quantity > 0";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql)) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $name = $row['name'];
      $price = $row['unit_price'];

      echo "
      <div class='inline'>
      <input type='checkbox' id='$name' name='add-ons[]' value='$name' data-price='$price'>
      <label for='$name'>$name</label>
      </div>
      ";
    }
  } else {
    echo '<input type="text" name="productPrice" id="productPrice">';
  }
}

function load_best_sellers($page)
{
  global $db_conn;

  $query = "SELECT sales_table.total_quantity, product_table.* FROM `sales_table` JOIN product_table ON sales_table.product_id = product_table.product_id WHERE total_quantity > 0 ORDER BY sales_table.total_quantity DESC LIMIT 5";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $product_name = $row['product_name'];
      $product_preview = $row['product_preview'];
      $product_description = $row['product_description'];
      $product_price = $row['product_price'];
      $total_quantity = $row['total_quantity'];

      if ($page === 'dashboard') {
        echo "<div class='card'>
                <img src='../uploads/$product_preview' alt=''>
                <p class='product-name'>
                  $product_name
                </p>
                <p class='sale-quantity'>
                  $total_quantity orders
                </p>
                <div class='gradient-bg'></div>
              </div>";
      } elseif ($page === 'menu') {
        echo "
          <div class='card product'>
            <img src='../uploads/$product_preview' alt=''>
            <div class='product-info'>
              <div class='name-price-wrapper'>
                <p class='product-name'>$product_name</p>
                <p class='product-price'>P$product_price</p>
              </div>
              <button class='cta main-btn'>ADD TO CART</button>
            </div>
          </div>";
      }
    }
  } else {
    if ($page === 'dashboard') {
      echo "<div class='card'>
              <img src='../assets/images/no-product.png' alt=''>
              <p class='sale-quantity'>
                no product found
              </p>
              <div class='gradient-bg'></div>
            </div>";
    }
  }
}

function load_least_sellers()
{
  global $db_conn;

  $query = "SELECT sales_table.total_quantity, product_table.* FROM `sales_table` JOIN product_table ON sales_table.product_id = product_table.product_id  WHERE sales_table.total_quantity < 10 ORDER BY sales_table.total_quantity ASC LIMIT 5";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $product_name = $row['product_name'];
      $product_preview = $row['product_preview'];
      $product_description = $row['product_description'];
      $total_quantity = $row['total_quantity'];

      echo "<div class='card'>
              <img src='../uploads/$product_preview' alt=''>
              <p class='product-name'>
                $product_name
              </p>
              <p class='sale-quantity'>
                $total_quantity orders
              </p>
              <div class='gradient-bg'></div>
            </div>";
    }
  } else {
    echo "<div class='card'>
            <img src='../assets/images/no-product.png' alt=''>
            <p class='sale-quantity'>
              no product found
            </p>
            <div class='gradient-bg'></div>
          </div>";
  }
}
