<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_POST['product_id'])) {
        
        $product_id = $_POST['product_id'];
        $product_title = isset($_POST['title']) ? $_POST['title'] : ''; 
        $product_price = isset($_POST['price']) ? $_POST['price'] : '';
        $product_img = isset($_POST['img_path']) ? $_POST['img_path'] : ''; 
        
       
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
       
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'title' => $product_title,
            'price' => $product_price,
            'img_path' => $product_img
        );


        header('Location: ../index.php#our-products');
        exit;
    }
}
?>
