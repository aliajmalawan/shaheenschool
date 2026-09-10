<?php
// Fix Download Paths - Run this once to fix existing database entries
require_once 'includes/config.php';

echo "<h2>Fixing Download Paths...</h2>";

// Get all downloads
$result = mysqli_query($conn, "SELECT id, file_path FROM downloads");

$fixed = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $old_path = $row['file_path'];
    $new_path = str_replace('../uploads/', 'uploads/', $old_path);

    if ($old_path != $new_path) {
        mysqli_query($conn, "UPDATE downloads SET file_path = '$new_path' WHERE id = {$row['id']}");
        echo "Fixed ID {$row['id']}: $old_path → $new_path<br>";
        $fixed++;
    }
}

echo "<br><strong>Total Fixed: $fixed</strong><br>";
echo "<br><a href='downloads.php'>Go to Downloads Page</a> | <a href='AdminCP/manage_downloads.php'>Go to Admin Panel</a>";
echo "<br><br><em>You can delete this file (fix_download_paths.php) after running it once.</em>";
?>
