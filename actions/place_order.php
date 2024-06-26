<?php
session_start();
include_once '../utils/db.php';


$user_email = $_SESSION['email'];


if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $location = $_POST['location'];
  $phone_number = $_POST['phone_number'];

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        
     
        $insert_query = "INSERT INTO orders (customer_email, product_id, location, phone_number) VALUES ('$user_email', $product_id, '$location', '$phone_number')";
        $conn->query($insert_query);
    }

  
    unset($_SESSION['cart']);
    header("Location: ../myOrders.php"); 
} else {
    
    header("Location: ../cart.php");
}
?>
