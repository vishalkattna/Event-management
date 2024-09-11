<?php
// Start session and check if the user is logged in
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: dashboard.php"); // Redirect to login page if not logged in
    exit();
}

$userName = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="welcome-container">
        <header>
            <h1>Welcome, <?php echo $userName; ?></h1>
        </header>
        <div class="button-container">
            <a href="vendor.php" class="button">Vendor</a>
            <a href="shopping_cart.php" class="button">Cart</a>
            <a href="guest_list.php" class="button">Guest List</a>
            <a href="order_status.php" class="button">Order Status</a>
            <a href="login.php" class="button">Logout</a>
        </div>
    </div>
</body>
</html>
