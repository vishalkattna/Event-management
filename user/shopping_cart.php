<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="index.php">Home</a>
        </div>
        <div class="navbar-center">
            <a href="view_products.php">View Products</a>
            <a href="request_items.php">Request Items</a>
            <a href="product_status.php">Product Status</a>
        </div>
        <div class="navbar-right">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="content">
        <h1>Your Shopping Cart</h1>
        <a href="transsction.php">helo</a>
        <!-- Cart content will go here -->
    </div>
</body>
</html>
