<?php
session_start();
require 'products.php';

// Generate a random order code
$order_code = bin2hex(random_bytes(8)); // 16 characters long

// Get cart items
$cart = $_SESSION['cart'];
$total = 0;

// Open a file to write the order
$order_file = fopen("orders-$order_code.txt", "w");

// Write order details to the file
fwrite($order_file, "Order Code: $order_code\n");
fwrite($order_file, "Date and Time Ordered: " . date('Y-m-d H:i:s') . "\n");
fwrite($order_file, "Order Items:\n");

foreach ($cart as $item) {
    fwrite($order_file, "Product ID: " . $item['id'] . "\n");
    fwrite($order_file, "Product Name: " . $item['name'] . "\n");
    fwrite($order_file, "Price: " . $item['price'] . " PHP\n");
    fwrite($order_file, "------------------------\n");
    $total += $item['price'];
}

fwrite($order_file, "Total Price: $total PHP\n");
fclose($order_file);

// Clear the cart
$_SESSION['cart'] = [];

// Display confirmation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p>Order Code: <?php echo htmlspecialchars($order_code); ?></p>
    <p>Total Price: <?php echo htmlspecialchars($total); ?> PHP</p>
</body>
</html>
