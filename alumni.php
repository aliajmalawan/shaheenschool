<?php
require_once 'includes/config.php';
require_once 'includes/settings_helper.php';

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_alumni'])) {
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

    // Photo upload
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png');
        $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed)) {
            $photo_name = time() . '_' . $_FILES['photo']['name'];
            $photo_path = 'uploads/alumni/' . $photo_name;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        }
    }

    $sql = "INSERT INTO alumni (student_name, father_name, current_job, job_department, job_city, course, passing_year, photo, mobile_number, whatsapp_number, review)
            VALUES ('$student_name', '$father_name', '$current_job', '$job_department', '$job_city', '$course', $passing_year, '$photo_path', '$mobile_number', '$whatsapp_number', '$review')";

    if (mysqli_query($conn, $sql)) {
        $message = 'Thank you! Your alumni registration has been submitted and is pending approval.';
    } else {
        $error = 'Error: ' . mysqli_error($conn);
    }
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $passing_year = intval($_POST['passing_year']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);
    $rating = intval($_POST['rating']);

    $sql = "INSERT INTO alumni_reviews (name, passing_year, review, rating) VALUES ('$name', $passing_year, '$review', $rating)";

    if (mysqli_query($conn, $sql)) {
        $message = 'Thank you for your review! It will be displayed after approval.';
    } else {
        $error = 'Error: ' . mysqli_error($conn);
    }
}

// Fetch approved alumni
$alumni = mysqli_query($conn, "SELECT * FROM alumni WHERE status = 'approved' ORDER BY passing_year DESC LIMIT 12");

// Fetch approved reviews
$reviews = mysqli_query($conn, "SELECT * FROM alumni_reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni - <?php echo getSiteName(); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Page Header with Background Image -->
    <section class="page-header" style="background-image: linear-gradient(rgba(11, 77, 162, 0.85), rgba(10, 58, 122, 0.85)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1200'); background-size: cover; background-position: center; background-repeat: no-repeat; padding: 50px 0 60px; text-align: center; color: white; position: relative;">
        <div class="container" style="position: relative; z-index: 2;">
            <div style="display: inline-block; background: rgba(255,255,255,0.1); padding: 15px 35px; border-radius: 10px; backdrop-filter: blur(10px);">
                <i class="fas fa-user-graduate" style="font-size: 2.5rem; margin-bottom: 12px; opacity: 0.9;"></i>
                <h1 style="font-size: 2.2rem; margin-bottom: 8px; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Alumni</h1>
                <p style="font-size: 1rem; opacity: 0.95;">Join our alumni community and share your success story</p>
            </div>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to bottom, transparent, white);"></div>
    </section>

    <?php if ($message): ?>
        <div class="container" style="margin-top: 30px;">
            <div style="background: #28a745; color: white; padding: 15px; border-radius: 5px; text-align: center;">
                <?php echo $message; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="container" style="margin-top: 30px;">
            <div style="background: #dc3545; color: white; padding: 15px; border-radius: 5px; text-align: center;">
                <?php echo $error; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Alumni Grid -->
    <section style="padding: 60px 0;">
        <div class="container">
            <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 40px;">Our Alumni</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                <?php
                if ($alumni && mysqli_num_rows($alumni) > 0) {
                    while ($alum = mysqli_fetch_assoc($alumni)) {
                        echo '<div class="card" style="text-align: center;">';
                        if ($alum['photo']) {
                            echo '<img src="' . $alum['photo'] . '" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 15px;">';
                        } else {
                            echo '<i class="fas fa-user-circle" style="font-size: 120px; color: var(--primary-color); opacity: 0.3; margin-bottom: 15px;"></i>';
                        }
                        echo '<h3 style="color: var(--primary-color); margin-bottom: 5px;">' . htmlspecialchars($alum['student_name']) . '</h3>';
                        echo '<p style="color: var(--text-light); margin-bottom: 10px;">' . htmlspecialchars($alum['course']) . ' - ' . $alum['passing_year'] . '</p>';
                        if ($alum['current_job']) {
                            echo '<p style="margin-bottom: 10px;"><strong>' . htmlspecialchars($alum['current_job']) . '</strong></p>';
                            if ($alum['job_city']) {
                                echo '<p style="color: var(--text-light); font-size: 0.9rem;"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($alum['job_city']) . '</p>';
                            }
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p style="text-align: center; color: var(--text-light); grid-column: 1 / -1;">No alumni to display yet</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Alumni Reviews -->
    <section style="padding: 60px 0; background: var(--bg-light);">
        <div class="container">
            <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 40px;">Alumni Reviews</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
                <?php
                if ($reviews && mysqli_num_rows($reviews) > 0) {
                    while ($review = mysqli_fetch_assoc($reviews)) {
                        echo '<div class="card">';
                        echo '<div style="margin-bottom: 15px;">';
                        for ($i = 0; $i < $review['rating']; $i++) {
                            echo '<i class="fas fa-star" style="color: #F9C900;"></i>';
                        }
                        echo '</div>';
                        echo '<p style="font-style: italic; margin-bottom: 15px; color: var(--text-dark);">"' . htmlspecialchars($review['review']) . '"</p>';
                        echo '<p style="font-weight: bold; color: var(--primary-color);">- ' . htmlspecialchars($review['name']);
                        if ($review['passing_year']) {
                            echo ' (' . $review['passing_year'] . ')';
                        }
                        echo '</p>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Registration Form -->
    <section style="padding: 60px 0;" id="registration">
        <div class="container">
            <div class="card" style="max-width: 800px; margin: 0 auto;">
                <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 30px;">Alumni Registration Form</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Student Name *</label>
                            <input type="text" name="student_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Father Name *</label>
                            <input type="text" name="father_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Course Passed *</label>
                            <input type="text" name="course" required placeholder="e.g., Matric, Intermediate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Passing Year *</label>
                            <input type="number" name="passing_year" required min="1990" max="2030" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Current Job</label>
                            <input type="text" name="current_job" placeholder="Job title" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Department</label>
                            <input type="text" name="job_department" placeholder="Department" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">City</label>
                            <input type="text" name="job_city" placeholder="City" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mobile Number *</label>
                            <input type="text" name="mobile_number" required placeholder="03001234567" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" placeholder="03001234567" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Photo (JPG, PNG)</label>
                        <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Your Review/Feedback * (Compulsory)</label>
                        <textarea name="review" required rows="5" placeholder="Share your experience with SHAHEEN PUBLIC HIGH SCHOOL..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                    </div>

                    <button type="submit" name="submit_alumni" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                        <i class="fas fa-paper-plane"></i> Submit Registration
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Submit Review Separately -->
    <section style="padding: 60px 0; background: var(--bg-light);" id="review">
        <div class="container">
            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 30px;">Submit Your Review</h2>
                <form method="POST">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Your Name *</label>
                        <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Passing Year</label>
                        <input type="number" name="passing_year" min="1990" max="2030" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Rating *</label>
                        <select name="rating" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★ (4 Stars)</option>
                            <option value="3">★★★ (3 Stars)</option>
                            <option value="2">★★ (2 Stars)</option>
                            <option value="1">★ (1 Star)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Your Review *</label>
                        <textarea name="review" required rows="4" placeholder="Share your thoughts..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                    </div>

                    <button type="submit" name="submit_review" class="btn btn-primary" style="width: 100%; padding: 15px;">
                        <i class="fas fa-star"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
