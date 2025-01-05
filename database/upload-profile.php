<?php
require "connection.php";

session_start();
$email = $_SESSION['email'] ?? "profile";

include_once '../includes/encryptDecrypt.php';

$cipherEmail = preg_replace('/[^\w-]/', '_', encryptData($email));

if (isset($_FILES['profileUpload'])) {

  $file = $_FILES['profileUpload'];

  $fileNAME = $_FILES['profileUpload']['name'];
  $fileTMPNM = $_FILES['profileUpload']['tmp_name'];
  $fileERROR = $_FILES['profileUpload']['error'];
  $fileSIZE = $_FILES['profileUpload']['size'];

  // Extract file extension
  $fileEXT = explode('.', $fileNAME);
  $fileACTUALEXT = strtolower(end($fileEXT));

  // Allowed file extensions
  $fileALLOWED = array('jpg', 'jpeg', 'png');

  if (in_array($fileACTUALEXT, $fileALLOWED)) {

    $query = "SELECT * FROM user_table WHERE email = '$email'";
    $sql = mysqli_query($db_conn, $query);

    if ($sql && mysqli_num_rows($sql) > 0) {
      $row = mysqli_fetch_assoc($sql);
      $profile = $row['profile'] ?? $cipherEmail;

      // Use the profile name if it exists, otherwise use the cipherEmail
      $newFileName = $profile . '.' . $fileACTUALEXT;
    }

    // Define the upload location
    $location = "../uploads/" . $newFileName;

    // Move the uploaded file to the new location
    if (move_uploaded_file($fileTMPNM, $location)) {
      echo "File uploaded successfully as $newFileName";

      $query = "UPDATE user_table SET profile = '$newFileName' WHERE email = '$email'";
      mysqli_query($db_conn, $query);

      $_SESSION['profile'] = $newFileName;

      echo $query;

      header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
      echo "Error moving the uploaded file.";
    }
  } else {
    echo "You can't upload this type of file!";
  }
}
