<?php
require 'connection.php';

$query = 'SELECT category_name FROM category_table';
$sql = mysqli_query($db_conn, $query);
$counter = 1;
$value = 1;

if (mysqli_num_rows($result) > 4) {
  echo '<div class="sliderBtnContainer">
          <button id="sliderPrevBtn">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
          <span>';
  while ($row = mysqli_fetch_assoc($sql)) {
    if ($counter % 5 === 0) {
      if ($value === 1) {
        echo "<input type='radio' name='sliderBtn' value='$value' checked>";
      }
      echo "<input type='radio' name='sliderBtn' value='$value'>";
      $counter = 1;
      $value++;
    }
    $counter++;
  }
  echo '</span>
          <button id="sliderNextBtn">
            <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>';
}

/*
<div class="sliderBtnContainer">
  <button id="sliderPrevBtn">
    <i class="fa-solid fa-chevron-left"></i>
  </button>
  <span>
    <input type='radio' name='sliderBtn' value='0' checked>
    <?php require '../database/sliderController.php' ?>
  </span>
  <button id="sliderNextBtn">
    <i class="fa-solid fa-chevron-right"></i>
  </button>
</div>
*/