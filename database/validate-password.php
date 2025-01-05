<?php
// Start the session if needed
session_start();

require 'connection.php';

$email = $_SESSION['email'];

$query = "SELECT * FROM user_table WHERE email = '$email'";
$sql = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($sql);
$password = $row['user_password'];

// Replace this with the actual password storage/retrieval logic
$storedPassword = $password; // This could be retrieved from a database

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if the password matches
if (isset($data['password']) && $data['password'] === $storedPassword) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false]);
}
