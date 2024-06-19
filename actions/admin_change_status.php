<?php
session_start();
include_once '../utils/db.php';

// Check if order ID is provided via POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update order status
    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    $result = $conn->query($sql);

    if ($result) {
      // Redirect user back to the previous page
      header("Location: " . $_SERVER['HTTP_REFERER']);
      exit();
  } else {
      // Handle error if deletion fails
      echo "<script>alert('Failed to update order status.')</script>";
  }
} else {
  // Redirect user if order ID is not provided
  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit();
}
?>