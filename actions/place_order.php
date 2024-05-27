<?php
session_start();
include_once '../utils/db.php';

// Retrieve user's email from session
$user_email = $_SESSION['email'];

// Loop through each product in the cart
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $location = $_POST['location'];
  $phone_number = $_POST['phone_number'];

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        
        // Insert order details into the orders table
        $insert_query = "INSERT INTO orders (customer_email, product_id, location, phone_number) VALUES ('$user_email', $product_id, '$location', '$phone_number')";
        $conn->query($insert_query);
    }

    // Clear the cart session after the order is placed
    unset($_SESSION['cart']);
    header("Location: ../myOrders.php"); // Redirect to order confirmation page
} else {
    // Redirect user to the cart page if cart is empty
    header("Location: ../cart.php");
}
?>
