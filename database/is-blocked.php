<?php
// Start the session if needed
session_start();

require 'connection.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['userId'])) {
  echo json_encode(['error' => 'User ID is required']);
  exit;
}

$user_id = $data['userId'];

$query = "SELECT * FROM user_table WHERE user_id = '$user_id'";
$sql = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($sql);
$is_blocked = $row['is_blocked'];

// Check if the password matches
if ($is_blocked) {
  echo json_encode(['blocked' => true]);
} else {
  echo json_encode(['blocked' => false]);
}
