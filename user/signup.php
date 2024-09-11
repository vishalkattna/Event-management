<?php
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";
    
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
    <title>User Signup</title>
</head>
<body>
    <h2>User Signup</h2>
    <form method="post" action="signup.php">
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
