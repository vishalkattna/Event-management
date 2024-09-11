<?php
include('../config/database.php'); // Include your database connection

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // SQL query to delete the admin
    $sql = "DELETE FROM admins WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Admin deleted successfully!";
    } else {
        $error = "Error deleting admin: " . mysqli_error($conn);
    }
}

// Handle role update and move data
if (isset($_POST['update_role'])) {
    $id = $_POST['admin_id'];
    $new_role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : '';

    // Ensure the role is either 'user' or 'vendor'
    if (in_array($new_role, ['user', 'vendor'])) {
        // Fetch the admin data from the `admins` table
        $sql = "SELECT * FROM admins WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $admin_data = mysqli_fetch_assoc($result);

        if ($admin_data) {
            // Determine the next available ID for the destination table
            if ($new_role == 'user') {
                $next_id_sql = "SELECT IFNULL(MAX(id), 0) + 1 AS next_id FROM users";
                $next_id_result = mysqli_query($conn, $next_id_sql);
                $next_id_row = mysqli_fetch_assoc($next_id_result);
                $new_id = $next_id_row['next_id'];

                $insert_sql = "INSERT INTO users (id, username, email, role, created_at) VALUES ('$new_id', '" . $admin_data['username'] . "', '" . $admin_data['email'] . "', 'user', '" . $admin_data['created_at'] . "')";

            } elseif ($new_role == 'vendor') {
                $next_id_sql = "SELECT IFNULL(MAX(id), 0) + 1 AS next_id FROM vendors";
                $next_id_result = mysqli_query($conn, $next_id_sql);
                $next_id_row = mysqli_fetch_assoc($next_id_result);
                $new_id = $next_id_row['next_id'];

                $insert_sql = "INSERT INTO vendors (id, username, email, created_at) VALUES ('$new_id', '" . $admin_data['username'] . "', '" . $admin_data['email'] . "', '" . $admin_data['created_at'] . "')";
            }

            if (mysqli_query($conn, $insert_sql)) {
                // If the admin was inserted successfully, delete them from the `admins` table
                $delete_sql = "DELETE FROM admins WHERE id = '$id'";

                if (mysqli_query($conn, $delete_sql)) {
                    $message = "Admin role updated and moved to $new_role table successfully!";
                } else {
                    $error = "Error deleting admin from admins table: " . mysqli_error($conn);
                }
            } else {
                $error = "Error inserting admin into $new_role table: " . mysqli_error($conn);
            }
        } else {
            $error = "Admin not found!";
        }
    } else {
        $error = "Invalid role selected.";
    }
}

// Handle data update
if (isset($_POST['update_admin'])) {
    $id = $_POST['admin_id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // SQL query to update admin data
    $update_sql = "UPDATE admins SET username='$username', email='$email' WHERE id='$id'";

    if (mysqli_query($conn, $update_sql)) {
        $message = "Admin data updated successfully!";
    } else {
        $error = "Error updating admin data: " . mysqli_error($conn);
    }
}

// Fetch all admins
$sql = "SELECT * FROM admins";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
        th, td {
            text-align: left;
        }
        button {
            padding: 5px 10px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }
        select, input[type="text"], input[type="email"] {
            padding: 5px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h2>Manage Admins</h2>

    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Update Data</th>
                <th>Change Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <!-- Update Admin Data Form -->
                            <form method="POST" action="manageadmins.php">
                                <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="Username">
                                <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Email">
                                <button type="submit" name="update_admin">Update Data</button>
                            </form>
                        </td>
                        <td>
                            <!-- Change Role Form -->
                            <form method="POST" action="manageadmins.php">
                                <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
                                <select name="role">
                                    <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
                                    <option value="vendor" <?php if ($row['role'] == 'vendor') echo 'selected'; ?>>Vendor</option>
                                </select>
                                <button type="submit" name="update_role">Change Role</button>
                            </form>
                        </td>
                        <td>
                            <a href="manageadmins.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">
                                <button>Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No admins found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
