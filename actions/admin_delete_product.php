<?php
session_start(); // Starting the session
include_once '../utils/db.php';

// Check if the user is an admin and the request method is POST
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the product ID is provided
    if (isset($_POST['product_id'])) {
        // Sanitize the product ID to prevent SQL injection
        $product_id = $_POST['product_id'];

        //select the image path from the database
        $get_image_query = "SELECT img_path FROM products WHERE id = $product_id";
        $image_result = $conn->query($get_image_query);
        $image_path = $image_result->fetch_assoc()['img_path'];

        // Delete the image from the server
        unlink($image_path);

        // Query to delete the product from the database
        $query = "DELETE FROM products WHERE id = $product_id";

        // Attempt to delete the product
        if ($conn->query($query) === TRUE) {
            // If deletion is successful, redirect to a success page
            header('Location: ../admin/addProduct.php?msg=Product deleted successfully');
            exit; // Terminating script after redirection
        } else {
            // If there's an error with the query, redirect to a failure page
            header('Location: ../admin/addProduct.php?msg=Failed to delete product');
            exit; // Terminating script after redirection
        }
    } else {
        // If the product ID is not provided, redirect to a failure page
        header('Location: ../admin/addProduct.php?msg=Product ID is missing');
        exit; // Terminating script after redirection
    }
} else {
    // If the user is not an admin or the request method is not POST, redirect to the login page
    header('Location: ../admin/login.php');
    exit; // Terminating script after redirection
}
?>
