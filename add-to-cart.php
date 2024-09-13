<?php
session_start();
require 'products.php';

// Add to cart logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Find the product details from products array
    $product = array_filter($products, function($p) use ($product_id) {
        return $p['id'] == $product_id;
    });
    
    if ($product) {
        $product = array_shift($product);
        // Add to cart session
        $_SESSION['cart'][] = $product;
    }
}

// Redirect to the cart page
header("Location: cart.php");
exit();
?>
