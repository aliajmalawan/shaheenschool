<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Image compression function
function compressImage($source, $destination, $quality = 75) {
    $info = getimagesize($source);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            break;
        default:
            return false;
    }

    // Save compressed image
    imagejpeg($image, $destination, $quality);
    imagedestroy($image);

    return file_exists($destination);
}

// Compress image to target size (100KB)
function compressToTargetSize($source, $destination, $maxSizeKB = 100) {
    $maxSizeBytes = $maxSizeKB * 1024;

    // If already under size, just copy
    if (filesize($source) <= $maxSizeBytes) {
        copy($source, $destination);
        return true;
    }

    // Start with quality 75 and reduce until file is small enough
    $quality = 75;
    $attempts = 0;
    $maxAttempts = 10;

    while ($attempts < $maxAttempts) {
        compressImage($source, $destination, $quality);

        if (file_exists($destination) && filesize($destination) <= $maxSizeBytes) {
            return true;
        }

        // Reduce quality for next attempt
        $quality -= 10;
        $attempts++;

        if ($quality < 10) {
            $quality = 10;
        }
    }

    // If still too large, use the last compressed version
    return file_exists($destination);
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete image file
    $img_query = mysqli_query($conn, "SELECT image_path FROM gallery WHERE id = $id");
    if ($img_row = mysqli_fetch_assoc($img_query)) {
        if (file_exists('../' . $img_row['image_path'])) {
            unlink('../' . $img_row['image_path']);
        }
    }

    if (mysqli_query($conn, "DELETE FROM gallery WHERE id = $id")) {
        $message = "Image deleted successfully!";
    }
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $display_order = intval($_POST['display_order']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/gallery/';

        // Create directory if not exists
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = time() . '_' . uniqid() . '.jpg'; // Always save as JPG after compression
            $target_file = $upload_dir . $new_filename;
            $temp_file = $_FILES['image']['tmp_name'];

            // Compress image if larger than 100KB
            if (compressToTargetSize($temp_file, $target_file, 100)) {
                $image_path = 'uploads/gallery/' . $new_filename;

                // Get final file size for info
                $final_size_kb = round(filesize($target_file) / 1024, 2);

                if (isset($_POST['gallery_id']) && !empty($_POST['gallery_id'])) {
                    // Update
                    $id = intval($_POST['gallery_id']);

                    // Delete old image
                    $old_img_query = mysqli_query($conn, "SELECT image_path FROM gallery WHERE id = $id");
                    if ($old_img_row = mysqli_fetch_assoc($old_img_query)) {
                        if (file_exists('../' . $old_img_row['image_path'])) {
                            unlink('../' . $old_img_row['image_path']);
                        }
                    }

                    $query = "UPDATE gallery SET title='$title', image_path='$image_path', category='$category', display_order=$display_order, status='$status' WHERE id=$id";
                } else {
                    // Insert
                    $query = "INSERT INTO gallery (title, image_path, category, display_order, status) VALUES ('$title', '$image_path', '$category', $display_order, '$status')";
                }

                if (mysqli_query($conn, $query)) {
                    $message = "Image saved successfully! (Compressed to {$final_size_kb} KB)";
                } else {
                    $message = "Error saving image.";
                }
            } else {
                $message = "Error compressing and uploading file.";
            }
        } else {
            $message = "Invalid file format. Only JPG, PNG, GIF, WEBP allowed.";
        }
    } else if (isset($_POST['gallery_id']) && !empty($_POST['gallery_id'])) {
        // Update without image
        $id = intval($_POST['gallery_id']);
        $query = "UPDATE gallery SET title='$title', category='$category', display_order=$display_order, status='$status' WHERE id=$id";

        if (mysqli_query($conn, $query)) {
            $message = "Gallery item updated successfully!";
        } else {
            $message = "Error updating gallery item.";
        }
    } else {
        $message = "Please select an image to upload.";
    }
}

// Fetch gallery item for editing
$edit_item = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM gallery WHERE id = $edit_id");
    $edit_item = mysqli_fetch_assoc($result);
}

// Fetch all gallery items
$gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/admin.css">
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .gallery-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gallery-item-info {
            padding: 15px;
        }
        .gallery-item-actions {
            padding: 10px 15px;
            background: var(--bg-light);
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body style="background: var(--bg-light);">
<div class="admin-shell">
<?php $active_page = 'manage_gallery.php'; include 'includes/sidebar.php'; ?>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="main-content">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
            <div class="admin-topbar-left">
                <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu" aria-expanded="false" aria-controls="adminSidebar"><i class="fas fa-bars"></i></button>
                <h1 style="color: var(--primary-color); margin:0;"><i class="fas fa-images"></i> Manage Gallery</h1>
            </div>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <?php if ($message): ?>
            <div style="background: <?php echo strpos($message, 'Error') !== false || strpos($message, 'Invalid') !== false ? '#f8d7da' : '#d4edda'; ?>; color: <?php echo strpos($message, 'Error') !== false || strpos($message, 'Invalid') !== false ? '#721c24' : '#155724'; ?>; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <div class="card" style="margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_item ? 'Edit Gallery Item' : 'Add New Image'; ?></h2>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($edit_item): ?>
                    <input type="hidden" name="gallery_id" value="<?php echo $edit_item['id']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Image Title *</label>
                    <input type="text" name="title" required value="<?php echo $edit_item ? htmlspecialchars($edit_item['title']) : ''; ?>" placeholder="e.g., Annual Sports Day 2024">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Category *</label>
                        <select name="category" required>
                            <option value="events" <?php echo ($edit_item && $edit_item['category'] == 'events') ? 'selected' : ''; ?>>Events</option>
                            <option value="classes" <?php echo ($edit_item && $edit_item['category'] == 'classes') ? 'selected' : ''; ?>>Classes</option>
                            <option value="activities" <?php echo ($edit_item && $edit_item['category'] == 'activities') ? 'selected' : ''; ?>>Activities</option>
                            <option value="achievements" <?php echo ($edit_item && $edit_item['category'] == 'achievements') ? 'selected' : ''; ?>>Achievements</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="<?php echo $edit_item ? $edit_item['display_order'] : '0'; ?>" placeholder="0">
                        <small style="color: var(--text-light); font-size: 12px;">Lower numbers appear first</small>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($edit_item && $edit_item['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_item && $edit_item['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Image <?php echo $edit_item ? '(optional - leave empty to keep current)' : '*'; ?></label>
                    <input type="file" name="image" accept="image/*" <?php echo !$edit_item ? 'required' : ''; ?>>
                    <?php if ($edit_item && !empty($edit_item['image_path'])): ?>
                        <div style="margin-top: 15px;">
                            <img src="../<?php echo htmlspecialchars($edit_item['image_path']); ?>" alt="Current Image" style="max-width: 300px; border-radius: 8px; box-shadow: var(--shadow);">
                            <p style="margin-top: 5px; font-size: 13px; color: var(--text-light);">Current image</p>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $edit_item ? 'Update Image' : 'Add Image'; ?>
                </button>
                <?php if ($edit_item): ?>
                    <a href="manage_gallery.php" class="btn btn-primary" style="background: var(--text-light); margin-left: 10px;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Gallery Grid -->
        <div class="card">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">All Gallery Images</h2>

            <?php if ($gallery && mysqli_num_rows($gallery) > 0): ?>
                <div class="gallery-grid">
                    <?php
                    while ($item = mysqli_fetch_assoc($gallery)) {
                        echo '<div class="gallery-item">';
                        echo '<img src="../' . htmlspecialchars($item['image_path']) . '" alt="' . htmlspecialchars($item['title']) . '">';
                        echo '<div class="gallery-item-info">';
                        echo '<h4 style="margin: 0 0 5px 0; color: var(--primary-color);">' . htmlspecialchars($item['title']) . '</h4>';
                        echo '<p style="margin: 0; font-size: 13px; color: var(--text-light);"><i class="fas fa-tag"></i> ' . ucfirst($item['category']) . '</p>';
                        echo '<p style="margin: 5px 0 0 0; font-size: 13px; color: var(--text-light);"><i class="fas fa-sort"></i> Order: ' . $item['display_order'] . '</p>';
                        echo '<span style="background: ' . ($item['status'] == 'active' ? '#28a745' : '#dc3545') . '; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; display: inline-block; margin-top: 5px;">' . ucfirst($item['status']) . '</span>';
                        echo '</div>';
                        echo '<div class="gallery-item-actions">';
                        echo '<a href="?edit=' . $item['id'] . '" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px; flex: 1; text-align: center;"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<a href="?action=delete&id=' . $item['id'] . '" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px; background: #dc3545; flex: 1; text-align: center;" onclick="return confirm(\'Delete this image?\')"><i class="fas fa-trash"></i> Delete</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: var(--text-light);">
                    <i class="fas fa-images" style="font-size: 80px; margin-bottom: 20px; opacity: 0.3;"></i>
                    <h3 style="margin-bottom: 10px;">No Images Yet</h3>
                    <p>Upload your first image to get started!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>
</div>
<script src="assets/admin.js"></script>
</body>
</html>
