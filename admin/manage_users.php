<?php
include('../config/database.php'); // Include your database connection

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $role = $_GET['role']; // Added to determine from which table to delete

    // Determine which table to delete from
    $table = $role === 'vendor' ? 'vendors' : ($role === 'admin' ? 'admins' : 'users');

    // SQL query to delete the user
    $sql = "DELETE FROM $table WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        $message = "User deleted successfully!";
    } else {
        $error = "Error deleting user: " . mysqli_error($conn);
    }
}

// Handle role update and move data
if (isset($_POST['update_role'])) {
    $id = $_POST['user_id'];
    $new_role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : '';

    // Ensure the role is either 'vendor' or 'admin'
    if (in_array($new_role, ['vendor', 'admin'])) {
        // Fetch the user data from the `users` table
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $error = "Error fetching user data: " . mysqli_error($conn);
        } else {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data) {
                // Determine the next available ID for the destination table
                $new_table = $new_role === 'vendor' ? 'vendors' : 'admins';
                $next_id_sql = "SELECT IFNULL(MAX(id), 0) + 1 AS next_id FROM $new_table";
                $next_id_result = mysqli_query($conn, $next_id_sql);
                $next_id_row = mysqli_fetch_assoc($next_id_result);
                $new_id = $next_id_row['next_id'];

                // Insert the user data into the new table
                $insert_sql = "INSERT INTO $new_table (id, username, email, created_at) VALUES ('$new_id', '" . $user_data['username'] . "', '" . $user_data['email'] . "', '" . $user_data['created_at'] . "')";

                if (mysqli_query($conn, $insert_sql)) {
                    // If the user was inserted successfully, delete them from the `users` table
                    $delete_sql = "DELETE FROM users WHERE id = '$id'";

                    if (mysqli_query($conn, $delete_sql)) {
                        $message = "User role updated and moved to $new_role table successfully!";
                    } else {
                        $error = "Error deleting user from users table: " . mysqli_error($conn);
                    }
                } else {
                    $error = "Error inserting user into $new_role table: " . mysqli_error($conn);
                }
            } else {
                $error = "User not found!";
            }
        }
    } else {
        $error = "Invalid role selected.";
    }
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    <h2>Manage Users</h2>

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
                <th>Role</th>
                <th>Created At</th>
                <th>Update Role</th>
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
                        <td><?php echo $row['role']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <!-- Update Role Form -->
                            <form method="POST" action="manage_users.php">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="current_role" value="<?php echo $row['role']; ?>">
                                <select name="role">
                                    <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
                                    <option value="vendor" <?php if ($row['role'] == 'vendor') echo 'selected'; ?>>Vendor</option>
                                    <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                                </select>
                                <button type="submit" name="update_role">Update Role</button>
                            </form>
                        </td>
                        <td>
                            <a href="manage_users.php?delete=<?php echo $row['id']; ?>&role=<?php echo $row['role']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">
                                <button>Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No users found</td>
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
