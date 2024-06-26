<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['p_id'])) {
        
        $product_id = $_POST['p_id'];

      
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            
            foreach ($_SESSION['cart'] as $key => $product) {
                
                if ($product['id'] == $product_id) {
                  
                    unset($_SESSION['cart'][$key]);
                   
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                    break; 
                }
            }
        }

        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
