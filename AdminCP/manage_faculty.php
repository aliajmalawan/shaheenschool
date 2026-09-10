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
    if (mysqli_query($conn, "DELETE FROM faculty WHERE id = $id")) {
        $message = "Faculty member deleted successfully!";
    }
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $subjects = mysqli_real_escape_string($conn, $_POST['subjects']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = intval($_POST['experience']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (isset($_POST['faculty_id']) && !empty($_POST['faculty_id'])) {
        // Update
        $id = intval($_POST['faculty_id']);
        $query = "UPDATE faculty SET name='$name', designation='$designation', subjects='$subjects', qualification='$qualification', experience=$experience, status='$status' WHERE id=$id";
    } else {
        // Insert
        $query = "INSERT INTO faculty (name, designation, subjects, qualification, experience, status) VALUES ('$name', '$designation', '$subjects', '$qualification', $experience, '$status')";
    }

    if (mysqli_query($conn, $query)) {
        $message = "Faculty member saved successfully!";
    } else {
        $message = "Error saving faculty member.";
    }
}

// Fetch faculty for editing
$edit_faculty = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM faculty WHERE id = $edit_id");
    $edit_faculty = mysqli_fetch_assoc($result);
}

// Fetch all faculty
$faculty = mysqli_query($conn, "SELECT * FROM faculty ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Faculty - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: var(--bg-light);">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="color: var(--primary-color);">Manage Faculty</h1>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <?php if ($message): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <div class="card" style="margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_faculty ? 'Edit Faculty Member' : 'Add New Faculty Member'; ?></h2>
            <form method="POST">
                <?php if ($edit_faculty): ?>
                    <input type="hidden" name="faculty_id" value="<?php echo $edit_faculty['id']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" required value="<?php echo $edit_faculty ? htmlspecialchars($edit_faculty['name']) : ''; ?>">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Designation *</label>
                        <input type="text" name="designation" required value="<?php echo $edit_faculty ? htmlspecialchars($edit_faculty['designation']) : ''; ?>" placeholder="e.g., Senior Teacher">
                    </div>

                    <div class="form-group">
                        <label>Subjects *</label>
                        <input type="text" name="subjects" required value="<?php echo $edit_faculty ? htmlspecialchars($edit_faculty['subjects']) : ''; ?>" placeholder="e.g., Physics, Mathematics">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Qualification *</label>
                        <input type="text" name="qualification" required value="<?php echo $edit_faculty ? htmlspecialchars($edit_faculty['qualification']) : ''; ?>" placeholder="e.g., MSc Physics">
                    </div>

                    <div class="form-group">
                        <label>Experience (Years) *</label>
                        <input type="number" name="experience" required value="<?php echo $edit_faculty ? htmlspecialchars($edit_faculty['experience']) : ''; ?>" placeholder="e.g., 10">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($edit_faculty && $edit_faculty['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_faculty && $edit_faculty['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $edit_faculty ? 'Update Faculty' : 'Add Faculty'; ?>
                </button>
                <?php if ($edit_faculty): ?>
                    <a href="manage_faculty.php" class="btn btn-primary" style="background: var(--text-light); margin-left: 10px;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Faculty List -->
        <div class="card" style="overflow-x: auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">All Faculty Members</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--primary-color); color: white;">
                        <th style="padding: 15px; text-align: left;">ID</th>
                        <th style="padding: 15px; text-align: left;">Name</th>
                        <th style="padding: 15px; text-align: left;">Designation</th>
                        <th style="padding: 15px; text-align: left;">Subjects</th>
                        <th style="padding: 15px; text-align: left;">Qualification</th>
                        <th style="padding: 15px; text-align: left;">Experience</th>
                        <th style="padding: 15px; text-align: left;">Status</th>
                        <th style="padding: 15px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($faculty && mysqli_num_rows($faculty) > 0) {
                        while ($member = mysqli_fetch_assoc($faculty)) {
                            echo '<tr style="border-bottom: 1px solid #e0e0e0;">';
                            echo '<td style="padding: 15px;">#' . $member['id'] . '</td>';
                            echo '<td style="padding: 15px;"><strong>' . htmlspecialchars($member['name']) . '</strong></td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($member['designation']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($member['subjects']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($member['qualification']) . '</td>';
                            echo '<td style="padding: 15px;">' . $member['experience'] . ' years</td>';
                            echo '<td style="padding: 15px;"><span style="background: ' . ($member['status'] == 'active' ? '#28a745' : '#dc3545') . '; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">' . ucfirst($member['status']) . '</span></td>';
                            echo '<td style="padding: 15px;">';
                            echo '<a href="?edit=' . $member['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; margin-right: 5px;">Edit</a>';
                            echo '<a href="?action=delete&id=' . $member['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #dc3545;" onclick="return confirm(\'Delete this faculty member?\')">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" style="padding: 30px; text-align: center; color: var(--text-light);">No faculty members yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
