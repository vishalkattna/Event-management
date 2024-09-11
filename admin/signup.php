<?php
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $category = $_POST['category']; // New field

    $sql = "INSERT INTO admins (username, email, password, category) VALUES ('$username', '$email', '$password', '$category')";
    
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
    <title>Admin Signup</title>
</head>
<body>
    <h2>Admin Signup</h2>
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
        <label for="category">Category:</label>
        <select name="category" required>
            <option value="">Select a category</option>
            <option value="Catering">Catering</option>
            <option value="Florist">Florist</option>
            <option value="Decoration">Decoration</option>
            <option value="Lighting">Lighting</option>
        </select>
        <br>
        <button type="submit">Signup</button>
    </form>
</body>
</html>
