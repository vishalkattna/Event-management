<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <a href="manage_users.php">Manage Users</a>
    <a href="managevendors.php">Manage Vendors</a>
    <a href="manageadmins.php">Manage Admins</a>
    <a href="logout.php">Logout</a>
</body>
</html>
