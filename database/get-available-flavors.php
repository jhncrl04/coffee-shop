<?php
// Start the session if needed
session_start();

require 'connection.php';

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);
$product_name = $data['productName'];

$query = "SELECT flavor FROM product_flavor_table WHERE product_name = '$product_name'";
$sql = mysqli_query($db_conn, $query);

if ($sql) {
  $rows = []; // Initialize an array to hold all rows
  while ($row = mysqli_fetch_assoc($sql)) {
    $flavors[] = $row; // Add each row to the array
  }
  // Return the rows as a JSON response
  echo json_encode([
    'success' => true,
    'flavors' => $flavors
  ]);
} else {
  // Return an error response
  echo json_encode([
    'success' => false,
    'message' => 'Query failed: ' . mysqli_error($db_conn)
  ]);
}
