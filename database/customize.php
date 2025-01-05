<?php
require 'connection.php';


function load_sizes()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type = 'cup' ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $name = $row['name'];
      $size = explode(" ", $name);
      $size = $size[0];
      $price = $row['unit_price'];

      echo "<div class='inline'>
              <span>
                <input type='radio' name='cup-size' id='$size' value='$name' class='size' data-price='$price'>
              </span>
              <label for='$size'>$size - P$price</label>
            </div>";
    }
  }
}

function load_toppings()
{

  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type = 'toppings' ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $name = $row['name'];
      $id = str_ireplace(" ", "-", strtolower($row['name']));
      $price = $row['unit_price'];

      echo "<div class='inline'>
              <span>
                <input type='radio' name='toppings' id='$id' class='toppings' value='$id' data-price='$price'>
              </span>
              <label for='$id'>$name - P$price</label>
            </div>";
    }
  }
}

function load_flavors()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type = 'flavor' ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $name = str_ireplace(" ", "-", strtolower($row['name']));
      $flavor = str_ireplace(' syrup', '', $row['name']);
      $price = $row['unit_price'];

      echo "<div class='inline'>
              <span>
                <input type='radio' name='flavor' id='$name' class='flavor' value='$name' data-price='$price'>
              </span>
              <label for='$name'>$flavor - P$price</label>
            </div>";
    }
  }
}

function load_addons()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type IN ('add-ons', 'drizzle') ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $id = str_ireplace(" ", "-", strtolower($row['name']));
      $name = $row['name'];
      $price = $row['unit_price'];

      echo "<div class='inline'>
              <input type='checkbox' name='addons[]' id='$id' class='addons' value='$id' data-price='$price'>
              <label for='$id'>$name - P$price</label>
            </div>";
    }
  }
}

function load_whipped_creams()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type = 'whipped cream' ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $name = strtolower($row['name']);
      $id = str_ireplace(" ", "-", strtolower($name));
      $price = $row['unit_price'];

      echo "<option name='whipped-cream' id='$id' value='$name' data-price='$price'>$name whipped cream</option>";
    }
  }
}

function load_masked_images()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type IN ('flavor', 'cup', 'add-ons') ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $type = $row['type'];

      $id = $row['name'];
      if ($type !== 'cup') {
        $id =  str_ireplace(" ", "-", strtolower($row['name'])) . "-img";
      }
      $src = $row['item_img'];

      echo "<div class='img-container'>
              <img src='../uploads/$src' id='$id' class='$type'>
            </div>";
    }
  }
}

function load_unmasked_images()
{
  global $db_conn;

  $query = "SELECT * FROM inventory_table WHERE type IN ('toppings', 'whipped cream') ORDER BY name ASC";
  $sql = mysqli_query($db_conn, $query);

  if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $type = str_ireplace(" ", "-", $row['type']);

      $id = $row['name'];
      if ($type !== 'cup') {
        $id =  str_ireplace(" ", "-", strtolower($row['name'])) . "-img";
      }
      $src = $row['item_img'];

      echo "<div class='img-container'>
              <img src='../uploads/$src' id='$id' class='$type'>
            </div>";
    }
  }
}
