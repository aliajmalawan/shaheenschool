<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/image_helper.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$error = '';

// Add new alumni
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_alumni'])) {
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
    $current_job = mysqli_real_escape_string($conn, $_POST['current_job']);
    $job_department = mysqli_real_escape_string($conn, $_POST['job_department']);
    $job_city = mysqli_real_escape_string($conn, $_POST['job_city']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $passing_year = intval($_POST['passing_year']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $whatsapp_number = mysqli_real_escape_string($conn, $_POST['whatsapp_number']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Photo upload
    $photo_path = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png');
        $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, $allowed)) {
            $photo_name = time() . '_' . $_FILES['photo']['name'];
            $photo_path = 'uploads/alumni/' . $photo_name;
            compressUploadedImage($_FILES['photo']['tmp_name'], '../' . $photo_path, 800, 85);
        }
    }

    $sql = "INSERT INTO alumni (student_name, father_name, current_job, job_department, job_city, course, passing_year, photo, mobile_number, whatsapp_number, review, status)
            VALUES ('$student_name', '$father_name', '$current_job', '$job_department', '$job_city', '$course', $passing_year, '$photo_path', '$mobile_number', '$whatsapp_number', '$review', '$status')";

    if (mysqli_query($conn, $sql)) {
        $message = 'Alumni added successfully!';
    } else {
        $error = 'Error: ' . mysqli_error($conn);
    }
}

// Approve/Reject alumni
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE alumni SET status = 'approved' WHERE id = $id");
        $message = 'Alumni approved!';
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE alumni SET status = 'rejected' WHERE id = $id");
        $message = 'Alumni rejected!';
    } elseif ($action == 'delete') {
        // Delete photo if exists
        $result = mysqli_query($conn, "SELECT photo FROM alumni WHERE id = $id");
        if ($row = mysqli_fetch_assoc($result)) {
            if ($row['photo'] && file_exists($row['photo'])) {
                unlink($row['photo']);
            }
        }
        mysqli_query($conn, "DELETE FROM alumni WHERE id = $id");
        $message = 'Alumni deleted!';
    }
}

// Fetch all alumni
$alumni = mysqli_query($conn, "SELECT * FROM alumni ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Alumni - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body style="background: var(--bg-light);">
<div class="admin-shell">
<?php $active_page = 'manage_alumni.php'; include 'includes/sidebar.php'; ?>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="main-content">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
            <div class="admin-topbar-left">
                <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu" aria-expanded="false" aria-controls="adminSidebar"><i class="fas fa-bars"></i></button>
                <h1 style="color: var(--primary-color); margin:0;">Manage Alumni</h1>
            </div>
        </div>

        <?php if ($message): ?>
            <div style="background: #28a745; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div style="background: #dc3545; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Add Alumni Form -->
        <div class="card" style="margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Add New Alumni</h2>
            <form method="POST" enctype="multipart/form-data">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Student Name *</label>
                        <input type="text" name="student_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Father Name *</label>
                        <input type="text" name="father_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Course *</label>
                        <input type="text" name="course" required placeholder="e.g., Matric, Intermediate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Passing Year *</label>
                        <input type="number" name="passing_year" required min="1990" max="2030" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Current Job</label>
                        <input type="text" name="current_job" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Department</label>
                        <input type="text" name="job_department" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">City</label>
                        <input type="text" name="job_city" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mobile Number *</label>
                        <input type="text" name="mobile_number" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Status *</label>
                        <select name="status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Photo (JPG, PNG)</label>
                    <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Review *</label>
                    <textarea name="review" required rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                </div>

                <button type="submit" name="add_alumni" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Alumni
                </button>
            </form>
        </div>

        <!-- Alumni List -->
        <div class="card" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--primary-color); color: white;">
                        <th style="padding: 15px; text-align: left;">Photo</th>
                        <th style="padding: 15px; text-align: left;">Name</th>
                        <th style="padding: 15px; text-align: left;">Father Name</th>
                        <th style="padding: 15px; text-align: left;">Course</th>
                        <th style="padding: 15px; text-align: left;">Year</th>
                        <th style="padding: 15px; text-align: left;">Job</th>
                        <th style="padding: 15px; text-align: left;">Mobile</th>
                        <th style="padding: 15px; text-align: left;">Review</th>
                        <th style="padding: 15px; text-align: left;">Status</th>
                        <th style="padding: 15px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($alumni && mysqli_num_rows($alumni) > 0) {
                        while ($alum = mysqli_fetch_assoc($alumni)) {
                            $status_color = $alum['status'] == 'approved' ? '#28a745' : ($alum['status'] == 'pending' ? '#ffc107' : '#dc3545');
                            echo '<tr style="border-bottom: 1px solid #e0e0e0;">';
                            echo '<td style="padding: 15px;">';
                            if ($alum['photo']) {
                                echo '<img src="../' . $alum['photo'] . '" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">';
                            } else {
                                echo '<i class="fas fa-user-circle" style="font-size: 50px; color: #ccc;"></i>';
                            }
                            echo '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($alum['student_name']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($alum['father_name']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($alum['course']) . '</td>';
                            echo '<td style="padding: 15px;">' . $alum['passing_year'] . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($alum['current_job'] ?: 'N/A') . '<br><small>' . htmlspecialchars($alum['job_city'] ?: '') . '</small></td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars($alum['mobile_number']) . '</td>';
                            echo '<td style="padding: 15px;">' . htmlspecialchars(substr($alum['review'], 0, 50)) . '...</td>';
                            echo '<td style="padding: 15px;"><span style="background: ' . $status_color . '; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">' . ucfirst($alum['status']) . '</span></td>';
                            echo '<td style="padding: 15px;">';
                            if ($alum['status'] == 'pending') {
                                echo '<a href="?action=approve&id=' . $alum['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #28a745; margin-bottom: 5px;"><i class="fas fa-check"></i> Approve</a><br>';
                                echo '<a href="?action=reject&id=' . $alum['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #dc3545;"><i class="fas fa-times"></i> Reject</a>';
                            }
                            echo '<a href="?action=delete&id=' . $alum['id'] . '" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #6c757d; margin-top: 5px;" onclick="return confirm(\'Delete this alumni?\')"><i class="fas fa-trash"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10" style="padding: 30px; text-align: center; color: var(--text-light);">No alumni registrations yet</td></tr>';
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
