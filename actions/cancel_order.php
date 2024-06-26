<?php
session_start();
include_once '../utils/db.php';


if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // die($order_id);

    
    $delete_query = "DELETE FROM orders WHERE id = $order_id";
    $result = $conn->query($delete_query);

    if ($result) {
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        
        echo "<script>alert('Failed to cancel order. Please try again.');</script>";
    }
} else {
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
