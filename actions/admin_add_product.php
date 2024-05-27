<?php
session_start(); // Starting the session
include_once '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is an admin
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) {
        // Extracting data from the form and sanitizing it
        $title = $conn->real_escape_string($_POST['title']);
        $price = $conn->real_escape_string($_POST['price']);

        // File upload handling
        $image = $_FILES['image']; // Accessing the uploaded image file
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'wpeg'];
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        // Validate file extension
        if (in_array($fileExtension, $allowedExtensions)) {
            $imageName = uniqid() . '.' . $fileExtension; // Generating a unique image name
            $targetDir = "../uploads/"; // Directory where images will be stored
            $targetPath = $targetDir . $imageName; // Path where the image will be saved on the server

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO products (title, price, img_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $price, $targetPath);

            if ($stmt->execute()) {
                // If insertion is successful, move the uploaded image to the target directory
                move_uploaded_file($image['tmp_name'], $targetPath);
                header('Location: ../admin/addProduct.php?msg=Product added successfully');
                exit;
            } else {
                // If there's an error with the query, display the error
                header('Location: ../admin/addProduct.php?msg=Product add failed');
                exit;
            }
        } else {
            header('Location: ../admin/addProduct.php?msg=Invalid file type');
            exit;
        }
    } else {
        // If the user is not an admin, redirect to the login page
        header('Location: ../login.php');
        exit;
    }
}
?>
