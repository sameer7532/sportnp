<?php
session_start();
include_once '../utils/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    // Check if a new image is uploaded
    if ($_FILES['image']['error'] === 0) {
        // Delete the old image
        $get_old_image_query = "SELECT img_path FROM products WHERE id = $product_id";
        $old_image_result = $conn->query($get_old_image_query);
        $old_image_path = $old_image_result->fetch_assoc()['img_path'];
        unlink($old_image_path);

        // // File upload handling
        $image = $_FILES['image']; // Accessing the uploaded image file
        $imageName = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION); // Generating a unique image name
        $targetDir = "../uploads/"; // Directory where images will be stored
        $targetPath = $targetDir . $imageName; // Path where the image will be saved on the server

        // Upload the new image

        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $image_path = $targetPath;
        } else {
            // Handle image upload error
            echo "<script>alert('Failed to upload image. Please try again.');</script>";
            exit();
        }

        // Update product details including the new image path
        $update_query = "UPDATE products SET title = '$title', price = $price, img_path = '$image_path' WHERE id = $product_id";
    } else {
        // Update product details without changing the image
        $update_query = "UPDATE products SET title = '$title', price = $price WHERE id = $product_id";
    }

    // Execute the update query
    $result = $conn->query($update_query);

    if ($result) {
        // Redirect user back to the product page with success message
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?success=Product updated successfully");
        exit();
    } else {
        // Handle error if update fails
        echo "<script>alert('Failed to update product. Please try again.');</script>";
    }
} else {
    // Redirect user if not accessed via POST method
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Close the database connection
$conn->close();
?>
