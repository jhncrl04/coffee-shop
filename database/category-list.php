<?php
require 'connection.php';

function category_checklist()
{
  global $db_conn;

  $query = "SELECT * FROM category_table ORDER BY category_name ASC";
  $result = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $categoryImg = $row['category_img'];
      $categoryName = $row['category_name'];
      $categoryNameId = str_replace(' ', '', $categoryName);

      echo "<span class='checkbox'>
                <input type='checkbox' id='$categoryName' name='$categoryName' value='$categoryName' class='categorySorter'>
                <label for='$categoryName'>$categoryName</label>
              </span>";
    }
  }
}

function category_options()
{
  global $db_conn;

  $query = "SELECT * FROM category_table ORDER BY category_name ASC";
  $result = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $categoryName = $row['category_name'];

      echo "<option value='$categoryName'>$categoryName</option>";
    }
  }
}
