<?php
require 'connection.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['action']) && $_GET['action'] === 'delete-user') {
    $user_ids = json_decode($_POST['user_ids'], true);

    if (is_array($user_ids) && count($user_ids) > 0) {
      $user_ids_stringify = implode(',', $user_ids);

      $query = "DELETE FROM user_table WHERE user_id IN ($user_ids_stringify)";
      $sql = mysqli_query($db_conn, $query);

      $referer = $_SERVER['HTTP_REFERER'];

      if ($sql) {
        echo "<script>
                alert(`Users Delete Successfully!`)
                window.location.href = '$referer';
              </script>";
      }
    }
  } elseif (isset($_GET['action']) && $_GET['action'] === 'block-user') {
    $user_ids = json_decode($_POST['user_ids'], true);

    if (is_array($user_ids) && count($user_ids) > 0) {
      $user_ids_stringify = implode(',', $user_ids);

      $query = "SELECT * FROM user_table WHERE user_id IN ($user_ids_stringify)";
      $sql = mysqli_query($db_conn, $query);
      $row = mysqli_fetch_assoc($sql);
      $is_blocked = $row['is_blocked'];

      $block_status = $is_blocked === "1" ? 0 : 1;
      $alert;

      if ($block_status === 1) {
        $alert = 'Users Blocked Successfully!';
      } else {
        $alert = 'Users Unblocked Successfully!';
      }

      $query = "UPDATE user_table SET is_blocked = $block_status WHERE user_id IN ($user_ids_stringify)";
      $sql = mysqli_query($db_conn, $query);

      $referer = $_SERVER['HTTP_REFERER'];

      if ($sql) {
        echo "<script>
                alert(`$alert`)
                window.location.href = '$referer';
              </script>";
      }
    }
  }
} else {
  $query = 'SELECT * FROM user_table WHERE user_role = "customer"';
  $sql = mysqli_query($db_conn, $query);

  if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
      $customer_id = $row['user_id'];
      $customer_name = $row['fname'] . ' ' . $row['lname'];
      $customer_email = $row['email'];
      $contact = $row['contact'];
      $is_verified = $row['is_verified'] ? '<i class="fa-solid fa-check true"></i>' : '<i class="fa-solid fa-xmark false"></i>';
      $is_blocked = $row['is_blocked'] ? '<span class="blocked"><i class="fa-solid fa-ban"></i> Blocked</span>' : '<span class="not-blocked"><i class="fa-solid fa-ban"></i> Not Block</span>';

      $addresses = $row['user_address'];
      $json_address = json_decode($addresses, true);
      $html_address = '';

      if ($addresses) {
        foreach ($json_address as $address) {
          $html_address .= $address['address'] . '<br>';
        }
      }

      echo "<tr class='customer-details' data-value='$customer_id'>
          <td><p>$customer_id</p></td>
          <td><p>$customer_name</p></td>
          <td><p>$customer_email</p></td>
          <td><p>$contact</p></td>
          <td><p>$html_address</p></td>
          <td><p>$is_verified</p></td>
          <td><p>$is_blocked</p></td>
        </tr>";
    }
  } else {
    echo "<tr>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
        </tr>";
  }
}
