<?php
/**
 * Setup Admin User with Password
 * Run this file once to create/update admin credentials
 *
 * Username: admin
 * Password: sphs786
 */

require_once 'includes/config.php';

// Hash the password
$username = 'admin';
$password = 'sphs786';
$email = 'sphs.pk.148@gmail.com';
$full_name = 'Administrator';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if admin_users table exists
$check_table = "SHOW TABLES LIKE 'admin_users'";
$result = mysqli_query($conn, $check_table);

if (mysqli_num_rows($result) == 0) {
    // Create table if it doesn't exist
    $create_table = "CREATE TABLE `admin_users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        `email` varchar(100) NOT NULL,
        `full_name` varchar(100) DEFAULT NULL,
        `role` varchar(50) DEFAULT 'admin',
        `status` enum('active','inactive') DEFAULT 'active',
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `last_login` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if (mysqli_query($conn, $create_table)) {
        echo "✓ Admin users table created successfully.<br>";
    } else {
        die("Error creating table: " . mysqli_error($conn));
    }
}

// Check if admin user exists
$check_user = "SELECT id FROM admin_users WHERE username = 'admin'";
$user_result = mysqli_query($conn, $check_user);

if (mysqli_num_rows($user_result) > 0) {
    // Update existing admin
    $update_query = "UPDATE admin_users SET
                     password = '$hashed_password',
                     email = '$email',
                     full_name = '$full_name',
                     status = 'active'
                     WHERE username = '$username'";

    if (mysqli_query($conn, $update_query)) {
        echo "✓ Admin user updated successfully!<br>";
    } else {
        echo "✗ Error updating admin: " . mysqli_error($conn) . "<br>";
    }
} else {
    // Insert new admin
    $insert_query = "INSERT INTO admin_users (username, password, email, full_name, role, status)
                     VALUES ('$username', '$hashed_password', '$email', '$full_name', 'admin', 'active')";

    if (mysqli_query($conn, $insert_query)) {
        echo "✓ Admin user created successfully!<br>";
    } else {
        echo "✗ Error creating admin: " . mysqli_error($conn) . "<br>";
    }
}

echo "<br><strong>Admin Credentials:</strong><br>";
echo "Username: <strong>admin</strong><br>";
echo "Password: <strong>sphs786</strong><br>";
echo "<br><a href='AdminCP/login.php'>Go to Admin Login</a><br>";
echo "<br><strong style='color: red;'>IMPORTANT: Delete this file after setup!</strong>";
?>
