<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Mark as read
if (isset($_GET['action']) && $_GET['action'] == 'mark_read' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "UPDATE contacts SET status = 'read' WHERE id = $id");
    header('Location: manage_contacts.php');
    exit;
}

// Fetch all contacts
$contacts = mysqli_query($conn, "SELECT * FROM contacts ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: var(--bg-light);">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="color: var(--primary-color);">Manage Contact Messages</h1>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <div class="card" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--primary-color); color: white;">
                        <th style="padding: 15px; text-align: left;">ID</th>
                        <th style="padding: 15px; text-align: left;">Name</th>
                        <th style="padding: 15px; text-align: left;">Email</th>
                        <th style="padding: 15px; text-align: left;">Phone</th>
                        <th style="padding: 15px; text-align: left;">Subject</th>
                        <th style="padding: 15px; text-align: left;">Message</th>
                        <th style="padding: 15px; text-align: left;">Date</th>
                        <th style="padding: 15px; text-align: left;">Status</th>
                        <th style="padding: 15px; text-align: left;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($contacts && mysqli_num_rows($contacts) > 0) {
                        while ($contact = mysqli_fetch_assoc($contacts)) {
                            $status_color = $contact['status'] == 'unread' ? '#dc3545' : '#28a745';
                            echo '<tr style="border-bottom: 1px solid #e0e0e0;">';
                            echo '<td style="padding: 15px;">#' . $contact['id'] . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($contact['name']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($contact['email']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($contact['phone']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($contact['subject']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars(substr($contact['message'], 0, 50)) . '...</td>';
                            echo '<td style="padding: 15px;">' . date('M d, Y', strtotime($contact['created_at'])) . '</td>';
                            echo '<td style="padding: 15px;"><span style="background: ' . $status_color . '; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">' . ucfirst($contact['status']) . '</span></td>';
                            echo '<td style="padding: 15px;">';
                            if ($contact['status'] == 'unread') {
                                echo '<a href="?action=mark_read&id=' . $contact['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Mark Read</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="9" style="padding: 30px; text-align: center; color: var(--text-light);">No contact messages yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
