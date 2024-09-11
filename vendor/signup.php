<?php
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_name = $_POST['vendor_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO vendors (vendor_name, username, email, password) VALUES ('$vendor_name', '$username', '$email', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: login.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Signup</title>
</head>
<body>
    <h2>Vendor Signup</h2>
    <form method="post" action="signup.php">
        <label for="vendor_name">Vendor Name:</label>
        <input type="text" name="vendor_name" required>
        <br>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Signup</button>
    </form>
</body>
</html>
