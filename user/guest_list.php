<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user/auth.php');
    exit();
}

// Retrieve guest list data

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest List</title>
</head>
<body>

<h2>Your Guest List</h2>

<!-- Guest list items will be displayed dynamically -->

<div>
    <a href="update_guest.php">Update Guest</a>
    <a href="delete_guest.php">Delete Guest</a>
</div>

</body>
</html>
