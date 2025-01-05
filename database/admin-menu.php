<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action']) && $_GET['action'] === 'add-category') {
    $categoryName = $_POST['categoryName'];
    $query = "SELECT * FROM category_table WHERE category_name = '$categoryName'";
    $sql = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($sql);

    if ($row > 0) {
      $referer = $_SERVER['HTTP_REFERER'];
      echo "<script> 
              alert('Category already exist!');
              window.location.href = '$referer';
            </script>";
    } else if (isset($_FILES['categoryPreview'])) {

      $file = $_FILES['categoryPreview'];

      $fileNAME = $_FILES['categoryPreview']['name'];
      $fileTMPNM = $_FILES['categoryPreview']['tmp_name'];
      $fileERROR = $_FILES['categoryPreview']['error'];
      $fileSIZE = $_FILES['categoryPreview']['size'];

      // Extract file extension
      $fileEXT = explode('.', $fileNAME);
      $fileACTUALEXT = strtolower(end($fileEXT));

      // Allowed file extensions
      $fileALLOWED = array('jpg', 'jpeg', 'png');

      if (in_array($fileACTUALEXT, $fileALLOWED)) {
        // Define the new filename
        $newFileName = "$categoryName." . $fileACTUALEXT;

        // Define the upload location
        $location = "../uploads/" . $newFileName;

        // Move the uploaded file to the new location
        if (move_uploaded_file($fileTMPNM, $location)) {
          echo "File uploaded successfully as $newFileName";

          $query = "INSERT INTO category_table (category_img, category_name) VALUES ('$newFileName', '$categoryName')";
          mysqli_query($db_conn, $query);
          header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
          echo "Error moving the uploaded file.";
        }
      } else {
        echo "You can't upload this type of file!";
      }
    }
  } else if (isset($_GET['action']) && $_GET['action'] === 'edit-category') {
    edit_category();
  } else if (isset($_GET['action']) && $_GET['action'] === 'delete-category') {
    $categoryName = $_POST['deleteCategoryName'];
    $query = "DELETE FROM category_table WHERE category_name = '$categoryName'";
    mysqli_query($db_conn, $query);

    $query = "DELETE FROM product_table WHERE product_category = '$categoryName'";
    mysqli_query($db_conn, $query);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
  } else if (isset($_GET['action']) && $_GET['action'] === 'add-product') {

    $product_name = $_POST['productName'];
    $product_category = $_POST['category'];
    $product_description = $_POST['productDescription'];
    $product_price = $_POST['productPrice'];
    $product_price = $result = preg_replace("/[a-zA-Z]/", "", $product_price);
    $flavors = $_POST['flavors'];

    $file = $_FILES['productPreview'];
    $fileNAME = $_FILES['productPreview']['name'];
    $fileTMPNM = $_FILES['productPreview']['tmp_name'];
    $fileERROR = $_FILES['productPreview']['error'];
    $fileSIZE = $_FILES['productPreview']['size'];

    // Extract file extension
    $fileEXT = explode('.', $fileNAME);
    $fileACTUALEXT = strtolower(end($fileEXT));

    // Allowed file extensions
    $fileALLOWED = array('jpg', 'jpeg', 'png');

    if (in_array($fileACTUALEXT, $fileALLOWED)) {
      // Define the new filename
      $newFileName = "$product_name." . $fileACTUALEXT;

      // Define the upload location
      $location = "../uploads/" . $newFileName;

      // Move the uploaded file to the new location
      if (move_uploaded_file($fileTMPNM, $location)) {
        echo "File uploaded successfully as $newFileName";

        $query = "INSERT INTO product_table (product_preview, product_name, product_description, product_price, product_category) VALUES ('$newFileName', '$product_name', '$product_description', '$product_price', '$product_category')";
        if (mysqli_query($db_conn, $query)) {
          if ($flavors) {
            $flavor_query = 'INSERT INTO product_flavor_table (product_name, flavor) VALUES ';
            foreach ($flavors as $flavor) {
              $flavor_query .= "('$product_name', '$flavor'),";
            }

            $flavor_query = rtrim($flavor_query, ',') . ';';

            mysqli_query($db_conn, $flavor_query);
          }

          $query = "SELECT MAX(product_id) AS product_id FROM product_table";
          $sql = mysqli_query($db_conn, $query);
          if ($sql && mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $product_id = $row['product_id'];

            $query = "INSERT INTO sales_table (product_id) VALUES ($product_id)";
            mysqli_query($db_conn, $query);
          }
        }


        header("Location: " . $_SERVER["HTTP_REFERER"]);
      } else {
        echo "Error moving the uploaded file.";
      }
    } else {
      echo "You can't upload this type of file!";
    }
  } else if (isset($_GET['action']) && $_GET['action'] === 'edit-product') {
    $process = $_POST['process'];
    $product_id = $_GET['product-id'];
    $product_name = $_POST['productName'];

    if (isset($_FILES['editProductPreview'])) {
      $file = $_FILES['editProductPreview'];
      $fileNAME = $_FILES['editProductPreview']['name'];
      $fileTMPNM = $_FILES['editProductPreview']['tmp_name'];
      $fileERROR = $_FILES['editProductPreview']['error'];
      $fileSIZE = $_FILES['editProductPreview']['size'];

      // Extract file extension
      $fileEXT = explode('.', $fileNAME);
      $fileACTUALEXT = strtolower(end($fileEXT));

      // Allowed file extensions
      $fileALLOWED = array('jpg', 'jpeg', 'png');
    }

    if ($process === 'Save Change') {
      $product_category = $_POST['category'];
      $product_description = $_POST['productDescription'];
      $product_price = $_POST['productPrice'];
      $product_price = $result = preg_replace("/[a-zA-Z]/", "", $product_price);
      $flavors = $_POST['flavors'];

      if (in_array($fileACTUALEXT, $fileALLOWED)) {
        $newFileName = "$product_name.$fileACTUALEXT";
        $location = "../uploads/$newFileName";

        // Move the uploaded file to the new location
        if (move_uploaded_file($fileTMPNM, $location)) {
          echo "File uploaded successfully as $newFileName";

          $query = "UPDATE product_table SET product_preview = '$newFileName', product_name = '$product_name', product_description = '$product_description', product_price = '$product_price', product_category = '$product_category' WHERE product_id = '$product_id'";

          mysqli_query($db_conn, $query);

          $flavor_query = "DELETE FROM product_flavor_table WHERE product_name = '$product_name'";
          mysqli_query($db_conn, $flavor_query);

          foreach ($flavors as $flavor) {
            $flavor_query = "INSERT INTO product_flavor_table (product_name, flavor) VALUES ('$product_name', '$flavor')";
            mysqli_query($db_conn, $flavor_query);
          }

          header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
          echo "Error moving the uploaded file.";
        }
      } else {
        $query = "UPDATE product_table SET product_name = '$product_name', product_description = '$product_description', product_price = '$product_price', product_category = '$product_category' WHERE product_id = '$product_id'";
        mysqli_query($db_conn, $query);


        $flavor_query = "DELETE FROM product_flavor_table WHERE product_name = '$product_name'";
        mysqli_query($db_conn, $flavor_query);

        foreach ($flavors as $flavor) {
          $flavor_query = "INSERT INTO product_flavor_table (product_name, flavor) VALUES ('$product_name', '$flavor')";
          mysqli_query($db_conn, $flavor_query);
        }

        header("Location: " . $_SERVER["HTTP_REFERER"]);
      }
    } else {
      $query = "DELETE FROM product_table WHERE product_id = '$product_id'";
      mysqli_query($db_conn, $query);

      $delete_product_flavor = "DELETE FROM product_flavor_table WHERE product_name = '$product_name'";
      mysqli_query($db_conn, $delete_product_flavor);

      header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  } else if (isset($_GET['action']) && $_GET['action'] === 'product-multi-delete') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_ids'])) {

      $productIds = json_decode($_POST['product_ids'], true);

      if (is_array($productIds) && count($productIds) > 0) {
        $productIdsStringify = implode(',', $productIds);

        $query = "DELETE FROM product_table WHERE product_id IN ($productIdsStringify)";
        $sql = mysqli_query($db_conn, $query);
        if ($sql) {
          echo 'Products successfully deleted!';
          header('Location: ../pages/admin-product.php');
        }
      } else {
        echo "Invalid data!";
      }
    } else {
      echo "No products selected!";
    }
  } else if (isset($_GET['action']) && $_GET['action'] === 'category-multi-delete') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_ids'])) {

      $categoryIds = json_decode($_POST['category_ids'], true);

      if (is_array($categoryIds) && count($categoryIds) > 0) {
        $categoryIdsStringify = implode(',', $categoryIds);

        $query = "DELETE FROM category_table WHERE category_id IN ($categoryIdsStringify)";
        echo $query;
        $sql = mysqli_query($db_conn, $query);
        if ($sql) {
          echo 'Products successfully deleted!';
          header('Location:' . $_SERVER['HTTP_REFERER']);
        }
      } else {
        echo "Invalid data!";
      }
    } else {
      echo "No category selected!";
    }
  }
}

function edit_category()
{
  global $db_conn;

  $oldCategoryName = $_POST['oldCategoryName'];
  $newCategoryName = $_POST['editCategoryName'] !== ''
    ? $_POST['editCategoryName']
    : $oldCategoryName;

  $file = $_FILES['editCategoryPreview'];

  $fileNAME = $_FILES['editCategoryPreview']['name'];
  $fileTMPNM = $_FILES['editCategoryPreview']['tmp_name'];
  $fileERROR = $_FILES['editCategoryPreview']['error'];
  $fileSIZE = $_FILES['editCategoryPreview']['size'];

  // Extract file extension
  $fileEXT = explode('.', $fileNAME);
  $fileACTUALEXT = strtolower(end($fileEXT));

  // Allowed file extensions
  $fileALLOWED = array('jpg', 'jpeg', 'png');

  if (in_array($fileACTUALEXT, $fileALLOWED)) {
    // Define the new filename
    $newFileName = "$newCategoryName." . $fileACTUALEXT;

    // Define the upload location
    $location = "../uploads/" . $newFileName;

    // Move the uploaded file to the new location
    if (move_uploaded_file($fileTMPNM, $location)) {
      echo "File uploaded successfully as $newFileName";

      $query = "UPDATE category_table SET category_img = '$newFileName', category_name = '$newCategoryName' WHERE category_name = '$oldCategoryName'";

      mysqli_query($db_conn, $query);
    } else {
      echo "Error moving the uploaded file.";
    }
  } else {
    $query = "UPDATE category_table SET category_name = '$newCategoryName' WHERE category_name = '$oldCategoryName'";

    mysqli_query($db_conn, $query);
  }
  header("Location: " . $_SERVER["HTTP_REFERER"]);
}
