<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the product ID is provided
    if (isset($_POST['product_id'])) {
        // Retrieve the product details from the POST data
        $product_id = $_POST['product_id'];
        $product_title = isset($_POST['title']) ? $_POST['title'] : ''; // Check if 'title' is set in POST data
        $product_price = isset($_POST['price']) ? $_POST['price'] : ''; // Check if 'price' is set in POST data
        $product_img = isset($_POST['img_path']) ? $_POST['img_path'] : ''; // Check if 'img_path' is set in POST data
        
        // Initialize the session cart array if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
        // Add the product details to the session cart array
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'title' => $product_title,
            'price' => $product_price,
            'img_path' => $product_img
        );

        // Redirect the user back to the previous page or any desired page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
