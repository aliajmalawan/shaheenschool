<?php
require_once 'includes/config.php';
$page_title = 'Courses & Programs';
$meta_description = 'Explore Matric, Intermediate, and specialized courses offered at SHAHEEN PUBLIC HIGH SCHOOL, including Pre-Engineering, Pre-Medical, Computer Science, and test preparation programs.';
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero-cover" style="min-height: 360px; background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1600');">
    <div class="container text-center">
        <span class="eyebrow on-dark">Programs</span>
        <h1 style="color: #fff; font-size: clamp(32px, 4vw, 48px); font-weight: 800;">Our Courses & Programs</h1>
        <p style="font-size: 18px; max-width: 700px; margin: 16px auto 0; color: rgba(255,255,255,0.88);">Comprehensive educational programs designed to help you achieve your academic goals</p>
    </div>
</section>

<?php
// Fetch courses from database
$courses_query = "SELECT * FROM courses WHERE status = 'active' ORDER BY display_order ASC";
$courses_result = mysqli_query($conn, $courses_query);
$has_db_courses = $courses_result && mysqli_num_rows($courses_result) > 0;

// Renders one course card - shared by the DB-driven and default-content paths
function renderCourseCard($icon, $title, $desc, $duration, $fee, $enroll_link) {
    echo '<div class="card reveal">';
    echo '<div class="card-icon"><i class="fas ' . htmlspecialchars($icon) . '"></i></div>';
    echo '<h3>' . htmlspecialchars($title) . '</h3>';
    echo '<p>' . htmlspecialchars($desc) . '</p>';
    if (!empty($duration) || !empty($fee)) {
        echo '<div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px; padding-top: 18px; border-top: 1px solid var(--border-color);">';
        if (!empty($duration)) {
            echo '<span style="background: var(--primary-soft); color: var(--primary-color); padding: 6px 14px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 600;"><i class="fas fa-clock" style="margin-right: 6px;"></i>' . htmlspecialchars($duration) . '</span>';
        }
        if (!empty($fee)) {
            echo '<span style="background: var(--primary-soft); color: var(--primary-color); padding: 6px 14px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 600;"><i class="fas fa-tag" style="margin-right: 6px;"></i>' . htmlspecialchars($fee) . '</span>';
        }
        echo '</div>';
    }
    echo '<a href="' . htmlspecialchars($enroll_link) . '" class="btn btn-primary mt-30" style="width: 100%; justify-content: center;">Enroll Now</a>';
    echo '</div>';
}
?>

<?php if ($has_db_courses): ?>
<!-- Courses Section (from database) -->
<section class="bg-light">
    <div class="container">
        <div class="card-grid">
            <?php
            while ($course = mysqli_fetch_assoc($courses_result)) {
                $fee_label = !empty($course['fee']) ? 'Rs. ' . number_format((float) $course['fee']) . '/month' : '';
                renderCourseCard(
                    !empty($course['icon']) ? $course['icon'] : 'fa-book',
                    $course['name'],
                    $course['description'],
                    $course['duration'],
                    $fee_label,
                    'admission.php?course=' . intval($course['id'])
                );
            }
            ?>
        </div>
    </div>
</section>
<?php else: ?>
<!-- Default course catalogue, grouped by program level -->
<?php
$course_catalogue = [
    [
        'eyebrow' => 'Academic Programs',
        'group' => 'Matric & Intermediate Programs',
        'tagline' => 'Board-recognized full-time academic programs',
        'courses' => [
            ['icon' => 'fa-graduation-cap', 'title' => 'Matric Programs (9th & 10th)', 'desc' => 'Complete matriculation preparation in Science, Arts, and Computer Science groups. Our comprehensive program covers all subjects with experienced teachers and modern teaching methods.', 'duration' => '2 Years', 'fee' => 'Rs. 5,000/month'],
            ['icon' => 'fa-book-open', 'title' => 'Intermediate - Pre-Engineering', 'desc' => 'FSc Pre-Engineering program for students aspiring to pursue engineering careers. Covers Physics, Chemistry, Mathematics with practical lab work and concept-based learning.', 'duration' => '2 Years', 'fee' => 'Rs. 6,000/month'],
            ['icon' => 'fa-flask', 'title' => 'Intermediate - Pre-Medical', 'desc' => 'FSc Pre-Medical program designed for future medical professionals. Comprehensive coverage of Biology, Chemistry, Physics with focus on MDCAT preparation.', 'duration' => '2 Years', 'fee' => 'Rs. 6,000/month'],
            ['icon' => 'fa-laptop', 'title' => 'Intermediate - Computer Science', 'desc' => 'ICS program combining mathematics with computer science. Perfect for students interested in IT, software development, and technology fields.', 'duration' => '2 Years', 'fee' => 'Rs. 6,000/month'],
        ],
    ],
    [
        'eyebrow' => 'Test Prep',
        'group' => 'Entry Test Preparation',
        'tagline' => 'Focused coaching for university admission tests',
        'courses' => [
            ['icon' => 'fa-pencil-alt', 'title' => 'ECAT Preparation', 'desc' => 'Intensive preparation course for Engineering College Admission Test. Covers all test patterns, practice questions, and proven strategies for success.', 'duration' => '3-6 Months', 'fee' => 'Rs. 8,000/month'],
            ['icon' => 'fa-stethoscope', 'title' => 'MDCAT Preparation', 'desc' => 'Comprehensive Medical and Dental College Admission Test preparation. Expert faculty, extensive practice tests, and personalized guidance.', 'duration' => '3-6 Months', 'fee' => 'Rs. 8,000/month'],
        ],
    ],
    [
        'eyebrow' => 'Skill Development',
        'group' => 'Short Courses & Skill Development',
        'tagline' => 'Practical, career-focused skills you can build fast',
        'courses' => [
            ['icon' => 'fa-laptop-code', 'title' => 'Computer Programming', 'desc' => 'Learn modern programming languages including C++, Python, Java, and web development. Hands-on projects and practical coding experience.', 'duration' => '6 Months', 'fee' => 'Rs. 4,000/month'],
            ['icon' => 'fa-globe', 'title' => 'Web Development', 'desc' => 'Complete web development course covering HTML, CSS, JavaScript, PHP, and MySQL. Build real-world websites and applications.', 'duration' => '6 Months', 'fee' => 'Rs. 5,000/month'],
            ['icon' => 'fa-comments', 'title' => 'Spoken English', 'desc' => 'Improve your English communication skills with our interactive spoken English course. Focus on fluency, pronunciation, and confidence.', 'duration' => '3 Months', 'fee' => 'Rs. 3,000/month'],
            ['icon' => 'fa-plane', 'title' => 'IELTS Preparation', 'desc' => 'Comprehensive IELTS test preparation covering all modules: Listening, Reading, Writing, and Speaking. Expert guidance and practice tests.', 'duration' => '2-3 Months', 'fee' => 'Rs. 7,000/month'],
            ['icon' => 'fa-calculator', 'title' => 'Advanced Mathematics', 'desc' => 'Advanced mathematics courses for competitive exams and higher studies. Covers Calculus, Algebra, Trigonometry, and more.', 'duration' => '6 Months', 'fee' => 'Rs. 4,000/month'],
            ['icon' => 'fa-atom', 'title' => 'Physics & Chemistry', 'desc' => 'In-depth Physics and Chemistry courses with practical demonstrations and problem-solving techniques for all levels.', 'duration' => '6 Months', 'fee' => 'Rs. 4,500/month'],
        ],
    ],
];

foreach ($course_catalogue as $index => $group):
?>
<section class="<?php echo $index % 2 === 0 ? 'bg-light' : ''; ?>">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow"><?php echo htmlspecialchars($group['eyebrow']); ?></span>
            <h2><?php echo htmlspecialchars($group['group']); ?></h2>
            <p><?php echo htmlspecialchars($group['tagline']); ?></p>
        </div>
        <div class="card-grid">
            <?php foreach ($group['courses'] as $course): ?>
                <?php renderCourseCard($course['icon'], $course['title'], $course['desc'], $course['duration'], $course['fee'], 'admission.php'); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>
<?php endif; ?>

<!-- Admission Requirements -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Requirements</span>
            <h2>Admission Requirements</h2>
            <p>What you need to know before applying</p>
        </div>
        <?php $requirement_groups = getFeatureCards('admission_requirements'); ?>
        <div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
            <?php foreach ($requirement_groups as $req): ?>
            <?php $items = array_filter(explode("\n", $req['description'])); ?>
            <div class="card reveal">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 20px;">
                    <div class="card-icon" style="margin: 0; width: 50px; height: 50px; font-size: 20px;"><i class="<?php echo htmlspecialchars($req['icon']); ?>"></i></div>
                    <h3 style="margin: 0;"><?php echo htmlspecialchars($req['title']); ?></h3>
                </div>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach (array_values($items) as $i => $item): ?>
                        <li style="display: flex; align-items: center; gap: 10px; padding: 10px 0; <?php echo $i < count($items) - 1 ? 'border-bottom: 1px solid var(--border-color);' : ''; ?>">
                            <i class="fas fa-check-circle" style="color: var(--accent-dark);"></i> <?php echo htmlspecialchars(trim($item)); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section>
    <div class="container">
        <div class="cta-banner reveal">
            <h2>Ready to Enroll?</h2>
            <p>Start your learning journey with <?php echo getSiteName(); ?> today</p>
            <div class="btn-group" style="justify-content: center;">
                <a href="admission.php" class="btn btn-primary">Apply Now</a>
                <a href="contact.php" class="btn btn-outline">Have Questions?</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
