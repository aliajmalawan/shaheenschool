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

$page_title = 'Alumni';
?>
<?php include 'includes/header.php'; ?>

    <!-- Page Header -->
    <section class="hero-cover" style="min-height: 320px; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1200');">
        <div class="container text-center">
            <span class="eyebrow on-dark"><i class="fas fa-user-graduate"></i> Alumni Network</span>
            <h1 style="color: #fff; font-size: clamp(30px, 4vw, 44px); font-weight: 800;">Our Alumni</h1>
            <p style="font-size: 17px; max-width: 650px; margin: 14px auto 0; color: rgba(255,255,255,0.88);">Join our alumni community and share your success story</p>
        </div>
    </section>

    <?php if ($message): ?>
        <div class="container" style="margin-top: 30px;">
            <div style="background: #d4edda; color: #155724; padding: 16px 20px; border-radius: var(--radius-sm); text-align: center; font-weight: 600;">
                <i class="fas fa-check-circle"></i> <?php echo $message; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="container" style="margin-top: 30px;">
            <div style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: var(--radius-sm); text-align: center; font-weight: 600;">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Alumni Grid -->
    <section>
        <div class="container">
            <div class="section-header reveal">
                <span class="eyebrow">Success Stories</span>
                <h2>Our Alumni</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                <?php
                if ($alumni && mysqli_num_rows($alumni) > 0) {
                    while ($alum = mysqli_fetch_assoc($alumni)) {
                        echo '<div class="card" style="text-align: center;">';
                        if ($alum['photo']) {
                            echo '<img src="' . $alum['photo'] . '" loading="lazy" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 15px;">';
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
    <section class="bg-light">
        <div class="container">
            <div class="section-header reveal">
                <span class="eyebrow">Testimonials</span>
                <h2>Alumni Reviews</h2>
            </div>
            <?php if ($reviews && mysqli_num_rows($reviews) > 0): ?>
            <div class="testimonial-carousel reveal">
                <div class="testimonial-track">
                    <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
                        <div class="testimonial-card">
                            <div class="testimonial-stars">
                                <?php
                                for ($i = 0; $i < $review['rating']; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }
                                ?>
                            </div>
                            <p class="testimonial-quote">"<?php echo htmlspecialchars($review['review']); ?>"</p>
                            <div class="testimonial-author">
                                <div class="testimonial-avatar"><i class="fas fa-user-graduate"></i></div>
                                <div>
                                    <strong><?php echo htmlspecialchars($review['name']); ?></strong>
                                    <?php if ($review['passing_year']): ?>
                                        <span>Batch <?php echo htmlspecialchars($review['passing_year']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <button type="button" class="testimonial-nav prev" aria-label="Previous review"><i class="fas fa-chevron-left"></i></button>
                <button type="button" class="testimonial-nav next" aria-label="Next review"><i class="fas fa-chevron-right"></i></button>
            </div>
            <?php else: ?>
            <p style="text-align: center; color: var(--text-light); padding: 20px;">No reviews yet - be the first to share your experience!</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Registration Form -->
    <section id="registration">
        <div class="container">
            <div class="card" style="max-width: 800px; margin: 0 auto;">
                <div class="text-center mb-30">
                    <span class="eyebrow">Get Involved</span>
                    <h2 style="color: var(--ink);">Alumni Registration Form</h2>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Student Name *</label>
                            <input type="text" name="student_name" required style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Father Name *</label>
                            <input type="text" name="father_name" required style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Course Passed *</label>
                            <input type="text" name="course" required placeholder="e.g., Matric, Intermediate" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Passing Year *</label>
                            <input type="number" name="passing_year" required min="1990" max="2030" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Current Job</label>
                            <input type="text" name="current_job" placeholder="Job title" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Department</label>
                            <input type="text" name="job_department" placeholder="Department" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">City</label>
                            <input type="text" name="job_city" placeholder="City" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Mobile Number *</label>
                            <input type="text" name="mobile_number" required placeholder="03001234567" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" placeholder="03001234567" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Photo (JPG, PNG)</label>
                        <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Your Review/Feedback * (Compulsory)</label>
                        <textarea name="review" required rows="5" placeholder="Share your experience with SHAHEEN PUBLIC HIGH SCHOOL..." style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);"></textarea>
                    </div>

                    <button type="submit" name="submit_alumni" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                        <i class="fas fa-paper-plane"></i> Submit Registration
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Submit Review Separately -->
    <section class="bg-light" id="review">
        <div class="container">
            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <div class="text-center mb-30">
                    <span class="eyebrow">Share Feedback</span>
                    <h2 style="color: var(--ink);">Submit Your Review</h2>
                </div>
                <form method="POST">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Your Name *</label>
                        <input type="text" name="name" required style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Passing Year</label>
                        <input type="number" name="passing_year" min="1990" max="2030" style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Rating *</label>
                        <select name="rating" required style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★ (4 Stars)</option>
                            <option value="3">★★★ (3 Stars)</option>
                            <option value="2">★★ (2 Stars)</option>
                            <option value="1">★ (1 Star)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-dark);">Your Review *</label>
                        <textarea name="review" required rows="4" placeholder="Share your thoughts..." style="width: 100%; padding: 13px 16px; border: 2px solid var(--border-color); border-radius: var(--radius-sm);"></textarea>
                    </div>

                    <button type="submit" name="submit_review" class="btn btn-primary" style="width: 100%; padding: 15px;">
                        <i class="fas fa-star"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
