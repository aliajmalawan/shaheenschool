<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle status updates
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE admissions SET status = 'approved' WHERE id = $id");
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE admissions SET status = 'rejected' WHERE id = $id");
    }

    header('Location: manage_admissions.php');
    exit;
}

// Fetch all admissions
$admissions = mysqli_query($conn, "SELECT * FROM admissions ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admissions - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: var(--bg-light);">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="color: var(--primary-color);">Manage Admissions</h1>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <div class="card" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--primary-color); color: white;">
                        <th style="padding: 15px; text-align: left;">ID</th>
                        <th style="padding: 15px; text-align: left;">Student Name</th>
                        <th style="padding: 15px; text-align: left;">Father Name</th>
                        <th style="padding: 15px; text-align: left;">Phone</th>
                        <th style="padding: 15px; text-align: left;">Course</th>
                        <th style="padding: 15px; text-align: left;">Date</th>
                        <th style="padding: 15px; text-align: left;">Status</th>
                        <th style="padding: 15px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($admissions && mysqli_num_rows($admissions) > 0) {
                        while ($admission = mysqli_fetch_assoc($admissions)) {
                            $status_color = $admission['status'] == 'approved' ? '#28a745' : ($admission['status'] == 'rejected' ? '#dc3545' : '#ffc107');
                            echo '<tr style="border-bottom: 1px solid #e0e0e0;">';
                            echo '<td style="padding: 15px;">#' . $admission['id'] . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($admission['student_name']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($admission['father_name']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($admission['phone']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($admission['course_id']) . '</td>';
                            echo '<td style="padding: 15px;">' . date('M d, Y', strtotime($admission['created_at'])) . '</td>';
                            echo '<td style="padding: 15px;"><span style="background: ' . $status_color . '; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">' . ucfirst($admission['status']) . '</span></td>';
                            echo '<td style="padding: 15px;">';
                            if ($admission['status'] == 'pending') {
                                echo '<a href="?action=approve&id=' . $admission['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; margin-right: 5px;" onclick="return confirm(\'Approve this admission?\')">Approve</a>';
                                echo '<a href="?action=reject&id=' . $admission['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #dc3545;" onclick="return confirm(\'Reject this admission?\')">Reject</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" style="padding: 30px; text-align: center; color: var(--text-light);">No admission applications yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
