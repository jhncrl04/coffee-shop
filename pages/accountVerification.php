<?php
require '../database/connection.php';

session_start();

require '../database/site-setting.php';

$verificationSuccess = false;

$email = $_GET['email'] ?? "";

$query = "SELECT * FROM user_table WHERE email = '$email'";
$result = mysqli_query($db_conn, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $is_verified = $row['is_verified'];

  if (!$is_verified) {
    $update = "UPDATE user_table SET is_verified = true WHERE email = '$email'";

    if (mysqli_query($db_conn, $update)) {
      $verificationSuccess = true;

      echo "<script> alert('Verification Successful!');window.location.href='index.php'</script>";
    }
  }
}

if (!$verificationSuccess) {
  session_destroy();

  echo "<script> alert('Verification Unsuccessful!');window.location.href='index.php'</script>";
}
