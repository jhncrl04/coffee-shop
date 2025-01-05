<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action']) && $_GET['action'] === 'add-item') {
    $item_name = $_POST['itemName'];
    $item_type = $_POST['itemType'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $query = "SELECT * FROM inventory_table WHERE name = '$item_name' AND type = '$item_type'";
    $sql = mysqli_query($db_conn, $query);

    if (mysqli_num_rows($sql) > 0) {
      echo 'exist';
    } else {
      if (isset($_FILES['itemImage'])) {
        $file = $_FILES['itemImage'];

        $fileNAME = $_FILES['itemImage']['name'];
        $fileTMPNM = $_FILES['itemImage']['tmp_name'];
        $fileERROR = $_FILES['itemImage']['error'];
        $fileSIZE = $_FILES['itemImage']['size'];

        // Extract file extension
        $fileEXT = explode('.', $fileNAME);
        $fileACTUALEXT = strtolower(end($fileEXT));

        // Allowed file extensions
        $fileALLOWED = array('jpg', 'jpeg', 'png');

        if (in_array($fileACTUALEXT, $fileALLOWED)) {
          // Define the new filename
          $newFileName = "inventory-" . "$item_name.$fileACTUALEXT";

          // Define the upload location
          $location = "../uploads/" . $newFileName;

          // Move the uploaded file to the new location
          if (move_uploaded_file($fileTMPNM, $location)) {
            echo "File uploaded successfully as $newFileName";

            $query = "INSERT INTO inventory_table (item_img, name, type, stock_quantity, unit_price) VALUES ('$newFileName', '$item_name', '$item_type', '$quantity', $price)";
          }
        } else {
          $query = "INSERT INTO inventory_table (name, type, stock_quantity, unit_price) VALUES ('$item_name', '$item_type', '$quantity', $price)";
        }
        mysqli_query($db_conn, $query);
      }
      echo $query;
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  }
  if (isset($_GET['action']) && $_GET['action'] === 'edit-item') {
    $item_id = $_POST['itemId'];
    $item_name = $_POST['itemName'];
    $item_type = $_POST['itemType'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $query = "UPDATE inventory_table SET name = '$item_name', type = '$item_type', stock_quantity = $quantity, unit_price = $price WHERE item_id = $item_id";

    if (isset($_FILES['editImage'])) {
      $file = $_FILES['editImage'];

      $fileNAME = $_FILES['editImage']['name'];
      $fileTMPNM = $_FILES['editImage']['tmp_name'];
      $fileERROR = $_FILES['editImage']['error'];
      $fileSIZE = $_FILES['editImage']['size'];

      // Extract file extension
      $fileEXT = explode('.', $fileNAME);
      $fileACTUALEXT = strtolower(end($fileEXT));

      // Allowed file extensions
      $fileALLOWED = array('jpg', 'jpeg', 'png');

      if (in_array($fileACTUALEXT, $fileALLOWED)) {
        // Define the new filename
        $newFileName = "inventory-" . "$item_name.$fileACTUALEXT";

        // Define the upload location
        $location = "../uploads/" . $newFileName;

        // Move the uploaded file to the new location
        if (move_uploaded_file($fileTMPNM, $location)) {
          echo "File uploaded successfully as $newFileName";

          $query = "UPDATE inventory_table SET item_img = '$newFileName', name = '$item_name', type = '$item_type', stock_quantity = $quantity, unit_price = $price WHERE item_id = $item_id";
        }
      }
    }
    mysqli_query($db_conn, $query);
    header("Location: " . $_SERVER["HTTP_REFERER"]);
  }
  if (isset($_GET['action']) && $_GET['action'] === 'delete-item') {
    $item_id = $_POST['itemId'];
    $item_name = $_POST['itemName'];
    $item_type = $_POST['itemType'];

    $query = "DELETE FROM inventory_table WHERE item_id = $item_id";

    if (mysqli_query($db_conn, $query)) {
      $referer = $_SERVER['HTTP_REFERER'];
      header("Location: $referer");
    }
  }
}
