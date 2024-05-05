<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the product ID is provided
    if (isset($_POST['p_id'])) {
        // Retrieve the product ID to be removed
        $product_id = $_POST['p_id'];

        // Check if the cart exists in the session and is not empty
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Loop through each product in the cart
            foreach ($_SESSION['cart'] as $key => $product) {
                // Check if the product ID matches the ID to be removed
                if ($product['id'] == $product_id) {
                    // Remove the product from the session cart array
                    unset($_SESSION['cart'][$key]);
                    break; // Exit the loop after removing the product
                }
            }
        }

        // Redirect the user back to the previous page or any desired page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
