<?php
include('../config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query to fetch the vendor details
    $sql = "SELECT * FROM vendors WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $vendor = mysqli_fetch_assoc($result);
        // Verify the password
        if (password_verify($password, $vendor['password'])) {
            $_SESSION['vendor_id'] = $vendor['id'];
            $_SESSION['vendor_name'] = $vendor['vendor_name'];
            header('Location: dashboard.php');  // Redirect to vendor's main page
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No vendor found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Login</title>
</head>
<body>
    <h2>Vendor Login</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
