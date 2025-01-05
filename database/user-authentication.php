<?php
require 'connection.php';
include_once '../includes/encryptDecrypt.php';

session_start();

$is_login = false;
$user_profile;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action']) && $_GET['action'] === 'login') {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];
    $loginQuery = "SELECT * FROM user_table WHERE email = '$email' AND user_password = '$password'";

    if (is_blocked($email)) {
      // Redirect to the previous page with login modal
      $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';

      // Parse the URL to check for query strings
      $parsed_url = parse_url($referer);
      parse_str($parsed_url['query'] ?? '', $query_params);

      // Check if 'login-status' exists; update accordingly
      if (!array_key_exists('account_status', $query_params)) {
        $query_params['account-status'] = 'blocked';
      }

      unset($query_params['login-status']);

      // Build the updated query string without duplicates
      $query_string = http_build_query($query_params);

      // Construct the redirect URL
      $redirect_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $query_string;

      // Redirect to the updated URL
      header('Location: ' . $redirect_url);
      exit;
    } else {
      $query = mysqli_query($db_conn, $loginQuery);
      $row = mysqli_fetch_assoc($query);

      if ($row && $row > 0) {

        if ($row['user_address']) {
          $addresses = json_decode($row['user_address'], true);

          $address_count = 1;
          foreach ($addresses as $address) {
            $_SESSION["address_$address_count"] = $address['address'];
            $address_count++;
          }
        }

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['contact'] = $row['contact'];
        $_SESSION['profile'] = $row['profile'];
        $_SESSION['user_role'] = $row['user_role'];
        $_SESSION['is_login'] = true;

        $user_role = $_SESSION['user_role'];

        // Remove 'login-status' parameter from the referer URL
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $parsed_url = parse_url($referer);
        parse_str($parsed_url['query'] ?? '', $query_params);

        // Remove 'login-status' if it exists
        unset($query_params['login-status']);
        unset($query_params['account-status']);
        $new_query_string = http_build_query($query_params);

        // Rebuild the URL without 'login-status'
        $redirect_url = $parsed_url['path'] . ($new_query_string ? '?' . $new_query_string : '');

        if ($user_role === "customer") {
          echo "<script>window.location.href = '$redirect_url';</script>";
          exit;
        }
        header('Location: ../pages/dashboard.php');

        exit;
      } else {
        // Redirect to the previous page with login modal
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';

        // Parse the URL to check for query strings
        $parsed_url = parse_url($referer);
        parse_str($parsed_url['query'] ?? '', $query_params);

        if ($_SESSION['login_attemp'] < 3) {
          $_SESSION['login_attemp']++;
        }
        $login_attemp = $_SESSION['login_attemp'];

        if ($login_attemp === 3 && check_account_role($email) === 'customer') {
          block_account($email);
        } else {
          unset($query_params['account-status']); // Remove account-blocked if not blocked
        }

        // Check if 'login-status' exists; update accordingly
        if (!array_key_exists('login-status', $query_params)) {
          $query_params['login-status'] = 'fail';
        }

        // Build the updated query string without duplicates
        $query_string = http_build_query($query_params);

        // Construct the redirect URL
        $redirect_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $query_string;

        // Redirect to the updated URL
        header('Location: ' . $redirect_url);
        exit;
      }
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'reset-password') {

    $newPassword = $_POST['newPassword'];
    $email = $_GET['email'];

    // FIX THE EMAIL IN THE URL

    if (isset($_GET['email'])) {

      // REPLACE SPACES WITH PLUS SIGN 
      $email = str_ireplace(" ", '+', $email);
      $email = decryptData($email);

      $resetPassQuery = "UPDATE user_table SET user_password = '$newPassword' WHERE email = '$email'";
      if ($query = mysqli_query($db_conn, $resetPassQuery)) {
        echo "<script>
                alert('Password has been successfully changed')
                window.location.href = '../pages/index.php';
              </script>";
      }
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'update-user-info') {

    if ($_POST['address'] || $_POST['additionalAddress']) {
      $address_1 = $_POST['address'] ?? '';
      $address_2 = $_POST['additionalAddress'] ?? '';

      $address = [
        ['address' => $address_1],
        ['address' => $address_2]
      ];
    }

    $json_address = json_encode($address);

    $new_fname = $_POST['firstName'];
    $new_lname = $_POST['lastName'];
    $new_contact = $_POST['contact'] ?? '';
    $new_address = $json_address;
    $email = $_SESSION['email'];

    $update_query = "UPDATE user_table SET fname = '$new_fname', lname = '$new_lname', contact = '$new_contact', user_address = '$new_address' WHERE email = '$email'";
    if ($query = mysqli_query($db_conn, $update_query)) {

      $_SESSION['fname'] = $new_fname;
      $_SESSION['lname'] = $new_lname;
      $_SESSION['contact'] = $new_contact;

      if ($new_address) {
        $addresses = json_decode($new_address, true);

        $address_count = 1;
        foreach ($addresses as $address) {
          $_SESSION["address_$address_count"] = $address['address'];
          $address_count++;
        }
      }

      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'update-email') {
    $new_email = $_POST['email'];
    $confirm_password = $_POST['password'];
    $old_email = $_SESSION['email'];

    $referer = $_SERVER['HTTP_REFERER'];

    $query = "SELECT * FROM user_table WHERE email = '$new_email'";
    $result = mysqli_query($db_conn, $query);

    if (mysqli_num_rows($result) > 0) {
      $msg = 'Change Email Failed!\nEmail Already Exists!';
      echo "<script> alert('$msg'); window.location.href = '$referer'; </script>";
    } else {
      // Verify old email and password
      $query = "SELECT * FROM user_table WHERE email = '$old_email' AND user_password = '$confirm_password'";
      $result = mysqli_query($db_conn, $query);

      if (mysqli_num_rows($result) > 0) {
        // Update the email
        $update_query = "UPDATE user_table SET email = '$new_email' WHERE email = '$old_email' AND user_password = '$confirm_password'";

        if (mysqli_query($db_conn, $update_query)) {
          $_SESSION['email'] = $new_email;

          $msg = 'Email Updated Successfully!';
          echo "<script> alert('$msg');window.location.href='$referer';</script>";
        } else {
          $msg = 'Change Email Failed!\nAn error occurred while updating.';
          echo "<script> alert('$msg'); window.location.href = '$referer'; </script>";
        }
      } else {
        $msg = 'Change Email Failed!\nPlease check your password.';
        echo "<script> alert('$msg'); window.location.href = '$referer'; </script>";
      }
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'edit-password') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $email = $_SESSION['email'];

    $query = "SELECT * FROM user_table WHERE email = '$email' AND user_password = '$old_password'";
    $sql = mysqli_query($db_conn, $query);

    $referer = $_SERVER['HTTP_REFERER'];

    if ($sql && mysqli_num_rows($sql) > 0) {

      $row = mysqli_fetch_assoc($sql);

      $update_query = "UPDATE user_table SET user_password = '$new_password' WHERE email = '$email' AND user_password = '$old_password'";
      if (mysqli_query($db_conn, $update_query)) {
        echo "<script> alert('Account Information Updated!'); window.location.href = '$referer' </script>";
      }
    } else {
      $msg = 'Change Password Failed!\nPlease check your old password';
      echo "<script> alert('$msg'); window.location.href = '$referer' </script>";
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'update-admin-info') {
    $new_fname = $_POST['firstName'];
    $new_lname = $_POST['lastName'];
    $new_email = $_POST['email'];
    $email = $_SESSION['email'];

    $update_query = "UPDATE user_table SET fname = '$new_fname', lname = '$new_lname', email = '$new_email' WHERE email = '$email'";

    if ($query = mysqli_query($db_conn, $update_query)) {

      $query = "SELECT * FROM user_table WHERE email = '$new_email'";

      $sql = mysqli_query($db_conn, $query);
      $row = mysqli_fetch_assoc($sql);

      $_SESSION['email'] = $row['email'];
      $_SESSION['fname'] = $row['fname'];
      $_SESSION['lname'] = $row['lname'];
      $_SESSION['contact'] = $row['contact'];
      $_SESSION['user_address'] = $row['user_address'];
      $_SESSION['profile'] = $row['profile'];
      $_SESSION['user_role'] = $row['user_role'];
      $_SESSION['is_login'] = true;

      $user_role = $_SESSION['user_role'];

      $referer = $_SERVER['HTTP_REFERER'];

      echo "<script> alert('Account Information Updated!'); window.location.href = '$referer' </script>";
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'update-admin-password') {
    $email = $_SESSION['email'];
    $new_password = $_POST['new-password'];

    $update_query = "UPDATE user_table SET user_password = '$new_password' WHERE email = '$email'";

    if (mysqli_query($db_conn, $update_query)) {

      $referer = $_SERVER['HTTP_REFERER'];

      echo "<script> alert('Account Password Updated!'); window.location.href = '$referer' </script>";
    }
  }
}


function check_account_role($email)
{
  global $db_conn;

  $query = "SELECT user_role FROM user_table WHERE email = '$email'";
  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    $role = $row['user_role'];
  }

  return $role;
}

function block_account($email)
{
  global $db_conn;

  $query = "UPDATE user_table SET is_blocked = true WHERE email = '$email'";
  $sql = mysqli_query($db_conn, $query);
}

function is_blocked($email)
{
  global $db_conn;

  $query = "SELECT is_blocked FROM user_table WHERE email = '$email'";
  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    $is_blocked = $row['is_blocked'];
  }

  return $is_blocked;
}
