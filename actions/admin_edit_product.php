<?php
session_start();
include_once '../utils/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

  
    if ($_FILES['image']['error'] === 0) {
       
        $get_old_image_query = "SELECT img_path FROM products WHERE id = $product_id";
        $old_image_result = $conn->query($get_old_image_query);
        $old_image_path = $old_image_result->fetch_assoc()['img_path'];
        unlink($old_image_path);

     
        $image = $_FILES['image']; 
        $imageName = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION); 
        $targetDir = "../uploads/"; 
        $targetPath = $targetDir . $imageName; 


        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $image_path = $targetPath;
        } else {
       
            echo "<script>alert('Failed to upload image. Please try again.');</script>";
            exit();
        }

      
        $update_query = "UPDATE products SET title = '$title', price = $price, img_path = '$image_path' WHERE id = $product_id";
    } else {
        
        $update_query = "UPDATE products SET title = '$title', price = $price WHERE id = $product_id";
    }


    $result = $conn->query($update_query);

    if ($result) {
     
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?success=Product updated successfully");
        exit();
    } else {
       
        echo "<script>alert('Failed to update product. Please try again.');</script>";
    }
} else {

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$conn->close();
?>
