<?php
session_start();
include_once '../utils/db.php';

// Check if order ID is provided via POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // die($order_id);

    // Delete the order from the database based on order ID
    $delete_query = "DELETE FROM orders WHERE id = $order_id";
    $result = $conn->query($delete_query);

    if ($result) {
        // Redirect user back to the previous page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Handle error if deletion fails
        echo "<script>alert('Failed to cancel order. Please try again.');</script>";
    }
} else {
    // Redirect user if order ID is not provided
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
