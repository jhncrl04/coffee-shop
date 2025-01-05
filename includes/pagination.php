<?php
require '../database/connection.php';

function menu_product_pagination()
{
  global $db_conn;

  $category_query = "SELECT * FROM category_table ORDER BY category_name ASC LIMIT 1";
  $query = mysqli_query($db_conn, $category_query);
  $row = mysqli_fetch_assoc($query);

  $product_category = '';

  if (isset($_GET['category'])) {
    $product_category = $_GET['category'];
  } elseif (!isset($_GET['category'])) {
    $product_category = $row['category_name'] ?? '';
  }

  $search = $_GET['s'] ?? '';

  if ($search) {
    $productQuery = "SELECT * FROM product_table WHERE product_name = '$search'";
  } else {
    $productQuery = "SELECT * FROM product_table WHERE product_category = '$product_category'";
  }
  $query = mysqli_query($db_conn, $productQuery);

  $product_count = 0;
  $page_count = 1;

  if (mysqli_num_rows($query) > 6) {
    echo "
        <span>
          <button id='pagePrev'>
            PREV
          </button>
        </span>
        <span>
          <input type='radio' name='page' id='page-$page_count' value='$page_count' checked>
          <label for='page-$page_count'>$page_count</label>
        </span>";

    while ($row = mysqli_fetch_assoc($query)) {
      $product_count++;

      if ($product_count === 7) {
        $page_count++;

        if (isset($_GET['page']) && $page_count === (int)$_GET['page']) {
          echo "<span>
          <input type='radio' name='page' id='page-$page_count' value='$page_count' checked>
          <label for='page-$page_count'>$page_count</label>
        </span>";
        } else {
          echo "<span>
              <input type='radio' name='page' id='page-$page_count' value='$page_count'>
              <label for='page-$page_count'>$page_count</label>
            </span>";
        }

        $product_count = 0;
      }
    }

    echo "<span>
          <button id='pageNext'>
            NEXT
          </button>
        </span>";
  }
}

function menu_category_pagination()
{
  global $db_conn;

  // Fetch all distinct categories
  $category_query = "SELECT category_name FROM category_table ORDER BY category_name ASC";

  $query = mysqli_query($db_conn, $category_query);

  // Check if any categories exist
  $categories = [];
  while ($row = mysqli_fetch_assoc($query)) {
    $categories[] = $row['category_name'];
  }

  if (empty($categories)) {
    // No categories found
    echo "<span>
            <input type='radio' name='category-page' id='noCategory' value='no-category' checked>
            <label for='noCategory'>No Category</label>
          </span>";
  } else {
    // Loop through categories and render radio buttons
    foreach ($categories as $category) {
      $categoryLower = strtolower($category); // Use lowercase for IDs/values
      $isChecked = (!isset($_GET['category']) && $category === $categories[0]) ||
        (isset($_GET['category']) && $categoryLower === strtolower($_GET['category']));

      echo "<span>
                <input type='radio' name='category-page' id='$categoryLower' value='$categoryLower' " . ($isChecked ? 'checked' : '') . ">
                <label for='$categoryLower'>$category</label>
              </span>";
    }
    echo "<span>
                <input type='radio' name='category-page' id='custom-drink' value='custom-drink'>
                <label for='custom-drink'>Make A Drink</label>
              </span>";
  }
}

function admin_product_pagination()
{
  global $db_conn;

  $productQuery = "SELECT * FROM product_table";
  $query = mysqli_query($db_conn, $productQuery);

  $product_count = 0;
  $page_count = 1;

  if (mysqli_num_rows($query) > 5) {
    echo "<span>
          <input type='radio' name='page' id='page-$page_count' value='$page_count' checked>
          <label for='page-$page_count'>$page_count</label>
        </span>";

    while ($row = mysqli_fetch_assoc($query)) {
      $product_count++;

      if ($product_count === 6) {
        $page_count++;

        if (isset($_GET['page']) && $page_count === (int)$_GET['page']) {
          echo "<span>
          <input type='radio' name='page' id='page-$page_count' value='$page_count' checked>
          <label for='page-$page_count'>$page_count</label>
        </span>";
        } else {
          echo "<span>
              <input type='radio' name='page' id='page-$page_count' value='$page_count'>
              <label for='page-$page_count'>$page_count</label>
            </span>";
        }

        $product_count = 0;
      }
    }
  }
}

function inventory_pagination()
{
  global $db_conn;

  $query = "SELECT COUNT(item_id) FROM inventory_table";
  $sql = mysqli_query($db_conn, $query);
  $row = mysqli_fetch_assoc($sql);

  $page_count = 1;
  $item_count = 0;

  $query = "SELECT * FROM inventory_table";
  if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $query = "SELECT * FROM inventory_table WHERE type = '$type'";
  }

  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 5) {
    echo "<span>
            <input type='radio' name='page' id='page-$page_count' value='$page_count' checked>
            <label for='page-$page_count'>$page_count</label>
          </span>";

    while ($row = mysqli_fetch_assoc($sql)) {
      $item_count++;

      if ($item_count === 5) {
        $page_count++;

        if (isset($_GET['page']) && $page_count === (int)$_GET['page']) {
          echo "<span>
                  <input type='radio' name='page' id='page-$page_count' value='$page_count' checked>
                  <label for='page-$page_count'>$page_count</label>
                </span>";
        } else {
          echo "<span>
                  <input type='radio' name='page' id='page-$page_count' value='$page_count'>
                  <label for='page-$page_count'>$page_count</label>
                </span>";
        }

        $item_count = 0;
      }
    }
  }
}
