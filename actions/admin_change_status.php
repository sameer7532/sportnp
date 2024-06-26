<?php
session_start();
include_once '../utils/db.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    $result = $conn->query($sql);

    if ($result) {
      
      header("Location: " . $_SERVER['HTTP_REFERER']);
      exit();
  } else {
      
      echo "<script>alert('Failed to update order status.')</script>";
  }
} else {
 
  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit();
}
?>