<?php
require 'connection.php';

$bg_color = '#faf9f8';
$font_color = '#2c2c2c';
$accent_color = '#b38b1a';
$logo = '../assets/images/logo.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action']) && $_GET['action'] === 'reset-bg') {
    $query = "UPDATE site_setting_table SET bg_color = '$bg_color' WHERE id = 1";
    mysqli_query($db_conn, $query);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else if (isset($_GET['action']) && $_GET['action'] === 'reset-font') {
    $query = "UPDATE site_setting_table SET font_color = '$font_color' WHERE id = 1";
    mysqli_query($db_conn, $query);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else if (isset($_GET['action']) && $_GET['action'] === 'reset-accent') {
    $query = "UPDATE site_setting_table SET accent_color = '$accent_color' WHERE id = 1";
    mysqli_query($db_conn, $query);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else if (isset($_GET['action']) && $_GET['action'] === 'reset-logo') {
    $query = "UPDATE site_setting_table SET site_logo = '$logo' WHERE id = 1";
    mysqli_query($db_conn, $query);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else {
    if (isset($_POST['mainBg'])) {
      $new_bg = $_POST['mainBg'];

      $query = "UPDATE site_setting_table SET bg_color = '$new_bg' WHERE id = 1";
      mysqli_query($db_conn, $query);

      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    if (isset($_POST['fontColor'])) {
      $new_font_color = $_POST['fontColor'];

      $query = "UPDATE site_setting_table SET font_color = '$new_font_color' WHERE id = 1";
      mysqli_query($db_conn, $query);

      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    if (isset($_POST['accentColor'])) {
      $new_accent_color = $_POST['accentColor'];

      $query = "UPDATE site_setting_table SET accent_color = '$new_accent_color' WHERE id = 1";
      mysqli_query($db_conn, $query);

      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    if (isset($_FILES['logo'])) {

      $file = $_FILES['logo'];

      $fileNAME = $_FILES['logo']['name'];
      $fileTMPNM = $_FILES['logo']['tmp_name'];
      $fileERROR = $_FILES['logo']['error'];
      $fileSIZE = $_FILES['logo']['size'];

      // Extract file extension
      $fileEXT = explode('.', $fileNAME);
      $fileACTUALEXT = strtolower(end($fileEXT));

      // Allowed file extensions
      $fileALLOWED = array('jpg', 'jpeg', 'png');

      if (in_array($fileACTUALEXT, $fileALLOWED)) {
        // Define the new filename
        $newFileName = "logo.$fileACTUALEXT";

        // Define the upload location
        $location = "../uploads/" . $newFileName;

        // Move the uploaded file to the new location
        if (move_uploaded_file($fileTMPNM, $location)) {
          echo "File uploaded successfully as $newFileName";

          $query = "UPDATE site_setting_table SET site_logo = '$location' WHERE id = 1";
          mysqli_query($db_conn, $query);
          header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
      }
    }
  }
}

$query = 'SELECT * FROM site_setting_table';
$sql = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($sql);

$db_bg_color = $row['bg_color'] ?? $font_color;
$db_font_color = $row['font_color'] ?? $font_color;
$db_accent_color = $row['accent_color'] ?? $accent_color;
$db_logo = $row['site_logo'] ?? $logo;

echo "
<style>
  :root {
    font-size: 10px;
    --main-bg: $db_bg_color;
    --secondary-bg: #ece9d2;
    --main-text: $db_font_color;
    --white-text: #faf9f8;
    --secondary-text: #2c2c2cb3;
    --footer-bg: #2c2c2c;
    --border: #2b2b2b3a;
    --accent: $db_accent_color;
    --accent-disable: #97885e;
    --card-bg: #f0ead6;
    --shadow: rgba(44, 44, 44, 0.3);

    --error: #c91432;
    --error-bg: #fce9ed;
    --success:rgb(40, 136, 68);
    --success-bg:rgb(199, 224, 197);
    --edit: #0d6efd;
  }
</style>";
