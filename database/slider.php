<?php
require 'connection.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action'])) {
    if ($_GET['action'] === 'add-slider') {

      $slider_name = $_POST['productNameInput'];
      $slider_phrase = $_POST['phraseInput'];

      if (isset($_FILES['sliderImgInput'])) {

        $file = $_FILES['sliderImgInput'];

        $fileNAME = $_FILES['sliderImgInput']['name'];
        $fileTMPNM = $_FILES['sliderImgInput']['tmp_name'];
        $fileERROR = $_FILES['sliderImgInput']['error'];
        $fileSIZE = $_FILES['sliderImgInput']['size'];

        echo $file;

        // Extract file extension
        $fileEXT = explode('.', $fileNAME);
        $fileACTUALEXT = strtolower(end($fileEXT));

        // Allowed file extensions
        $fileALLOWED = array('jpg', 'jpeg', 'png');

        if (in_array($fileACTUALEXT, $fileALLOWED)) {
          // Define the new filename
          $newFileName = "$slider_name" . "slider.$fileACTUALEXT";

          // Define the upload location
          $location = "../uploads/" . $newFileName;

          // Move the uploaded file to the new location
          if (move_uploaded_file($fileTMPNM, $location)) {
            echo "File uploaded successfully as $newFileName";

            $query = "INSERT INTO slideshow_table (slider_img, slider_phrase, slider_name) VALUES ('$newFileName', '$slider_phrase', '$slider_name')";

            if (mysqli_query($db_conn, $query)) {
              header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
          } else {
            echo "Error moving the uploaded file.";
          }
        } else {
          echo "You can't upload this type of file!";
        }
      }
    }
    if ($_GET['action'] === 'edit-slider') {

      $slider_name = $_POST['editProductNameInput'];
      $slider_phrase = $_POST['editPhraseInput'];
      $slider_id = $_POST['sliderId'];

      if (isset($_FILES['editSliderImgInput'])) {

        $file = $_FILES['editSliderImgInput'];

        $fileNAME = $_FILES['editSliderImgInput']['name'];
        $fileTMPNM = $_FILES['editSliderImgInput']['tmp_name'];
        $fileERROR = $_FILES['editSliderImgInput']['error'];
        $fileSIZE = $_FILES['editSliderImgInput']['size'];

        // Extract file extension
        $fileEXT = explode('.', $fileNAME);
        $fileACTUALEXT = strtolower(end($fileEXT));

        // Allowed file extensions
        $fileALLOWED = array('jpg', 'jpeg', 'png');

        if (in_array($fileACTUALEXT, $fileALLOWED)) {
          // Define the new filename
          $newFileName = "$slider_name" . "slider.$fileACTUALEXT";

          // Define the upload location
          $location = "../uploads/" . $newFileName;

          // Move the uploaded file to the new location
          if (move_uploaded_file($fileTMPNM, $location)) {
            echo "File uploaded successfully as $newFileName";

            $query = "UPDATE slideshow_table SET slider_img = '$newFileName', slider_phrase = '$slider_phrase', slider_name = '$slider_name' WHERE slider_id = '$slider_id'";
            if (mysqli_query($db_conn, $query)) {
              header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
          } else {
            echo "Error moving the uploaded file.";
          }
        } else {
          $query = "UPDATE slideshow_table SET slider_phrase = '$slider_phrase', slider_name = '$slider_name' WHERE slider_id = '$slider_id'";

          if (mysqli_query($db_conn, $query)) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
          }
        }
      }
    } elseif ($_GET['action'] === 'delete-slider') {
      $slider_id = $_POST['sliderId'];

      $query = "DELETE FROM slideshow_table WHERE slider_id = '$slider_id'";


      if (mysqli_query($db_conn, $query)) {
        $referer = $_SERVER['HTTP_REFERER'];

        echo "<script> alert('Slider item has been deleted'); window.location.href = '$referer' </script>";
      }
    }
  }
}


function loadSlider()
{
  global $db_conn;

  $query = 'SELECT * FROM slideshow_table';
  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {

      $slider_id = $row['slider_id'];
      $slider_img = $row['slider_img'];
      $slider_name = $row['slider_name'];
      $slider_phrase = $row['slider_phrase'];

      echo "<div class='slider-item' data-id='$slider_id'>
              <img src='../uploads/$slider_img' alt=''>
              <div class='text-container'>
                <p class='phrase'>$slider_phrase</p>
                <p class='product-name'>$slider_name</p>
                <a href='menu.php?s=$slider_name' class='order-now-btn main-btn'>Order Now</a>
              </div>
            </div>";
    }
  } else {
    echo "<div class='slider-item'>
    <img src='../assets/images/contact-header.jpg' alt=''>
    <div class='text-container'>
      <p class='phrase'>No Best Seller Yet</p>
      <a href='menu.php' class='order-now-btn main-btn'>View Menu</a>
    </div>
  </div>";
  }
}

// function loadSliderController()
// {
//   global $db_conn;

//   $query = 'SELECT * FROM slideshow_table';
//   $sql = mysqli_query($db_conn, $query);
//   $controller_count = 1;

//   if (mysqli_num_rows($sql) > 0) {
//     while ($row = mysqli_fetch_assoc($sql)) {
//       if ($controller_count === 1) {
//         echo "
//         <input type='radio' name='controller' id='controller' value='$controller_count' checked>
//         ";
//       } else {
//         echo "
//         <input type='radio' name='controller' id='controller' value='$controller_count'>
//         ";
//       }
//       $controller_count++;
//     }
//   }
// }
