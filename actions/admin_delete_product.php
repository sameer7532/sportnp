<?php
session_start(); 
include_once '../utils/db.php';


if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true && $_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_POST['product_id'])) {
       
        $product_id = $_POST['product_id'];

        $get_image_query = "SELECT img_path FROM products WHERE id = $product_id";
        $image_result = $conn->query($get_image_query);
        $image_path = $image_result->fetch_assoc()['img_path'];

       
        unlink($image_path);

   
        $query = "DELETE FROM products WHERE id = $product_id";

        
        if ($conn->query($query) === TRUE) {
            
            header('Location: ../admin/addProduct.php?msg=Product deleted successfully');
            exit; 
        } else {
            
            header('Location: ../admin/addProduct.php?msg=Failed to delete product');
            exit; 
        }
    } else {
      
        header('Location: ../admin/addProduct.php?msg=Product ID is missing');
        exit; 
    }
} else {
   
    header('Location: ../admin/login.php');
    exit; 
}
?>
