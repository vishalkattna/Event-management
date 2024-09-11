<?php
// Start session and check if the user is logged in
session_start();

if (!isset($_SESSION['vendor_name'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$vendorName = htmlspecialchars($_SESSION['vendor_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Welcome, <span id="username"><?php echo $vendorName; ?></span></h1>
        </header>
        <div class="container">
            <div class="column">
                <h2>Your Items</h2>
                <!-- Content for "Your Items" -->
            </div>
            <div class="column">
                <a href="manage_item.php"><h2>Add New Item</h2></a>
                <!-- Content for "Add New Item" -->
            </div>
            <div class="column">
                <h2>Transactions</h2>
                <!-- Content for "Transactions" -->
            </div>
            <div class="column">
                <h2><a href="login.php">Logout</a></h2>
                <!-- Logout link -->
            </div>
        </div>
    </div>
</body>
</html>
