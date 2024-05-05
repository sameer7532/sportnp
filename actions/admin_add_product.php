<?php
session_start(); // Starting the session
include_once '../utils/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is an admin
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) {
        // Extracting data from the form
        $title = $_POST['title'];
        $price = $_POST['price'];

        // File upload handling
        $image = $_FILES['image']; // Accessing the uploaded image file
        $imageName = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION); // Generating a unique image name
        $targetDir = "../uploads/"; // Directory where images will be stored
        $targetPath = $targetDir . $imageName; // Path where the image will be saved on the server

        // Attempt to insert product data into the database
        $query = "INSERT INTO products (title, price, img_path) VALUES ('$title', '$price', '$targetPath')";
        if ($conn->query($query) === TRUE) {
            // If insertion is successful, move the uploaded image to the target directory
            move_uploaded_file($image['tmp_name'], $targetPath);
            header('Location: ../admin/addProduct.php?msg=Product added successfully');
            exit; // Terminating script after redirection
        } else {
            // If there's an error with the query, display the error
            header('Location: ../admin/addProduct.php?msg=Product add failed');
        }
    } else {
        // If the user is not an admin, redirect to the login page
        header('Location: ../login.php');
        exit; // Terminating script after redirection
    }
}
?>
