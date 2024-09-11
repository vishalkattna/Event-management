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
    <title>Transaction</title>
    <link rel="stylesheet" href="stylestrans.css">
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
            <a href="login.php">Logout</a>
        </div>
    </div>
    <div class="content">
        <h1>Transaction Details</h1>
        <form action="process_transaction.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="number">Phone Number:</label>
                <input type="tel" id="number" name="number" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="upi">UPI</option>
                </select>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>
            </div>
            <div class="form-group">
                <label for="pin_code">Pin Code:</label>
                <input type="text" id="pin_code" name="pin_code" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
