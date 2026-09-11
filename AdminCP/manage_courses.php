<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (mysqli_query($conn, "DELETE FROM courses WHERE id = $id")) {
        $message = "Course deleted successfully!";
    }
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $fee = mysqli_real_escape_string($conn, $_POST['fee']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (isset($_POST['course_id']) && !empty($_POST['course_id'])) {
        // Update
        $id = intval($_POST['course_id']);
        $query = "UPDATE courses SET name='$name', description='$description', duration='$duration', fee='$fee', status='$status' WHERE id=$id";
    } else {
        // Insert
        $query = "INSERT INTO courses (name, description, duration, fee, status) VALUES ('$name', '$description', '$duration', '$fee', '$status')";
    }

    if (mysqli_query($conn, $query)) {
        $message = "Course saved successfully!";
    } else {
        $message = "Error saving course.";
    }
}

// Fetch course for editing
$edit_course = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM courses WHERE id = $edit_id");
    $edit_course = mysqli_fetch_assoc($result);
}

// Fetch all courses
$courses = mysqli_query($conn, "SELECT * FROM courses ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body style="background: var(--bg-light);">
<div class="admin-shell">
<?php $active_page = 'manage_courses.php'; include 'includes/sidebar.php'; ?>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="main-content">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
            <div class="admin-topbar-left">
                <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu" aria-expanded="false" aria-controls="adminSidebar"><i class="fas fa-bars"></i></button>
                <h1 style="color: var(--primary-color); margin:0;">Manage Courses</h1>
            </div>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <?php if ($message): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <div class="card" style="margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_course ? 'Edit Course' : 'Add New Course'; ?></h2>
            <form method="POST">
                <?php if ($edit_course): ?>
                    <input type="hidden" name="course_id" value="<?php echo $edit_course['id']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Course Name *</label>
                    <input type="text" name="name" required value="<?php echo $edit_course ? htmlspecialchars($edit_course['name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Description *</label>
                    <textarea name="description" required rows="4"><?php echo $edit_course ? htmlspecialchars($edit_course['description']) : ''; ?></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" name="duration" value="<?php echo $edit_course ? htmlspecialchars($edit_course['duration']) : ''; ?>" placeholder="e.g., 6 Months">
                    </div>

                    <div class="form-group">
                        <label>Fee (Rs.)</label>
                        <input type="number" name="fee" value="<?php echo $edit_course ? htmlspecialchars($edit_course['fee']) : ''; ?>" placeholder="e.g., 5000">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($edit_course && $edit_course['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_course && $edit_course['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $edit_course ? 'Update Course' : 'Add Course'; ?>
                </button>
                <?php if ($edit_course): ?>
                    <a href="manage_courses.php" class="btn btn-primary" style="background: var(--text-light); margin-left: 10px;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Courses List -->
        <div class="card" style="overflow-x: auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">All Courses</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--primary-color); color: white;">
                        <th style="padding: 15px; text-align: left;">ID</th>
                        <th style="padding: 15px; text-align: left;">Course Name</th>
                        <th style="padding: 15px; text-align: left;">Duration</th>
                        <th style="padding: 15px; text-align: left;">Fee</th>
                        <th style="padding: 15px; text-align: left;">Status</th>
                        <th style="padding: 15px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($courses && mysqli_num_rows($courses) > 0) {
                        while ($course = mysqli_fetch_assoc($courses)) {
                            echo '<tr style="border-bottom: 1px solid #e0e0e0;">';
                            echo '<td style="padding: 15px;">#' . $course['id'] . '</td>';
                            echo '<td style="padding: 15px;"><strong>' . htmlspecialchars($course['name']) . '</strong></td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($course['duration']) . '</td>';
                            echo '<td style="padding: 15px;">Rs. ' . number_format($course['fee']) . '</td>';
                            echo '<td style="padding: 15px;"><span style="background: ' . ($course['status'] == 'active' ? '#28a745' : '#dc3545') . '; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">' . ucfirst($course['status']) . '</span></td>';
                            echo '<td style="padding: 15px;">';
                            echo '<a href="?edit=' . $course['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; margin-right: 5px;">Edit</a>';
                            echo '<a href="?action=delete&id=' . $course['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #dc3545;" onclick="return confirm(\'Delete this course?\')">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6" style="padding: 30px; text-align: center; color: var(--text-light);">No courses yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<script src="assets/admin.js"></script>
</body>
</html>
