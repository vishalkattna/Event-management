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
    <title>Manage Items</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <span>Welcome, <?php echo $vendorName; ?></span>
        </div>
        <div class="navbar-right">
            <a href="product_status.php">Product Status</a>
            <a href="request_item.php">Request Item</a>
            <a href="view_product.php">View Product</a>
            <a href="login.php">Logout</a>
        </div>
    </div>
    <div class="main-content">
        <div class="left-side">
            <h2>Add New Product</h2>
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="product_price">Product Price:</label>
                    <input type="number" id="product_price" name="product_price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="product_image">Product Image:</label>
                    <input type="file" id="product_image" name="product_image" accept="image/*" required>
                </div>
                <button type="submit">Add Product</button>
            </form>
        </div>
        <div class="right-side">
            <h2>Product Information</h2>
            <!-- Example product info; replace with dynamic content from database -->
            <div class="product-info">
                <img src="https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Zm9vZHxlbnwwfHwwfHx8MA%3D%3D" alt="Product Image">
                <p><strong>Product Name:</strong> Example Product</p>
                <p><strong>Price:</strong> $19.99</p>
                <div class="actions">
                    <a href="delete_product.php?id=1" class="delete-button">Delete</a>
                    <button class="edit-button">Edit</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
