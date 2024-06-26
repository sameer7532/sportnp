<?php
session_start(); 
include_once '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) {
    
        $title = $conn->real_escape_string($_POST['title']);
        $price = $conn->real_escape_string($_POST['price']);

       
        $image = $_FILES['image']; 
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'wpeg'];
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

      
        if (in_array($fileExtension, $allowedExtensions)) {
            $imageName = uniqid() . '.' . $fileExtension; 
            $targetDir = "../uploads/"; 
            $targetPath = $targetDir . $imageName; 

          
            $stmt = $conn->prepare("INSERT INTO products (title, price, img_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $price, $targetPath);

            if ($stmt->execute()) {
               
                move_uploaded_file($image['tmp_name'], $targetPath);
                header('Location: ../admin/addProduct.php?msg=Product added successfully');
                exit;
            } else {
              
                header('Location: ../admin/addProduct.php?msg=Product add failed');
                exit;
            }
        } else {
            header('Location: ../admin/addProduct.php?msg=Invalid file type');
            exit;
        }
    } else {
        
        header('Location: ../login.php');
        exit;
    }
}
?>
