<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include('../config/database.php');

// Fetch cart items
$user_id = $_SESSION['user_id'];
$sql = "SELECT cart.*, items.item_name, items.price FROM cart 
        JOIN items ON cart.item_id = items.id WHERE cart.user_id = $user_id";
$result = mysqli_query($conn, $sql);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate total amount
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <table>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        <?php foreach ($cart_items as $item): ?>
        <tr>
            <td><?php echo $item['item_name']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h2>Total Amount: <?php echo $total; ?></h2>
    <a href="transsction.php">Proceed to Payment</a>
</body>
</html>
