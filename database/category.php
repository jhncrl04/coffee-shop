<?php
require 'connection.php';

$query = "SELECT * FROM category_table";
$result = mysqli_query($db_conn, $query);


function admin_category($result)
{
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $categoryId = $row['category_id'];
      $categoryImg = $row['category_img'];
      $categoryName = $row['category_name'];

      echo "<div class='category' data-value='$categoryId'>
              <input type='checkbox' value='$categoryName' id='$categoryName' class='category-selector'>
              <img src='../uploads/$categoryImg' alt=''>
              <div class='inner-content'>
                <p>$categoryName</p>
                <div class='inline'>
                  <button id='editCategoryBtn' class='main-btn' onclick='openModal(editCategoryModal, `$categoryName`)'>Edit</button>
                  <button class='secondary-btn' onclick='openModal(deleteCategoryModal, `$categoryName`)'>Delete</button>
                </div>
              </div>
            </div>";
    }
  }
}

function home_category($result)
{
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $categoryId = $row['category_id'];
      $categoryImg = $row['category_img'];
      $categoryName = $row['category_name'];

      echo "<div class='imgContainer'>
          <img src='../uploads/$categoryImg' alt=''>
          <div class='text-container'>
            <h1>$categoryName</h1>
            <a href='menu.php?category=$categoryName' class='main-btn wrap-width'>VIEW MENU</a>
          </div>
        </div>";
    }
  }
}
