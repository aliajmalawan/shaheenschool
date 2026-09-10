<?php
require_once 'includes/config.php';
$page_title = 'Courses & Programs';
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

<!-- Courses Section -->
<section class="bg-light">
    <div class="container">
        <div class="card-grid">
            <?php
            // Fetch courses from database
            $courses_query = "SELECT * FROM courses WHERE status = 'active' ORDER BY display_order ASC";
            $courses_result = mysqli_query($conn, $courses_query);

            if ($courses_result && mysqli_num_rows($courses_result) > 0) {
                while ($course = mysqli_fetch_assoc($courses_result)) {
                    echo '<div class="card">';
                    echo '<div class="card-icon"><i class="fas fa-book"></i></div>';
                    echo '<h3>' . htmlspecialchars($course['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($course['description']) . '</p>';
                    if (!empty($course['duration'])) {
                        echo '<p style="margin-top: 15px;"><strong>Duration:</strong> ' . htmlspecialchars($course['duration']) . '</p>';
                    }
                    if (!empty($course['fee'])) {
                        echo '<p><strong>Fee:</strong> Rs. ' . htmlspecialchars($course['fee']) . '</p>';
                    }
                    echo '<a href="admission.php?course=' . $course['id'] . '" class="btn btn-primary mt-30">Enroll Now</a>';
                    echo '</div>';
                }
            } else {
                // Default courses if database is empty
                $default_courses = [
                    [
                        'icon' => 'fa-graduation-cap',
                        'title' => 'Matric Programs (9th & 10th)',
                        'desc' => 'Complete matriculation preparation in Science, Arts, and Computer Science groups. Our comprehensive program covers all subjects with experienced teachers and modern teaching methods.',
                        'duration' => '2 Years',
                        'fee' => '5,000/month'
                    ],
                    [
                        'icon' => 'fa-book-open',
                        'title' => 'Intermediate - Pre-Engineering',
                        'desc' => 'FSc Pre-Engineering program for students aspiring to pursue engineering careers. Covers Physics, Chemistry, Mathematics with practical lab work and concept-based learning.',
                        'duration' => '2 Years',
                        'fee' => '6,000/month'
                    ],
                    [
                        'icon' => 'fa-flask',
                        'title' => 'Intermediate - Pre-Medical',
                        'desc' => 'FSc Pre-Medical program designed for future medical professionals. Comprehensive coverage of Biology, Chemistry, Physics with focus on MDCAT preparation.',
                        'duration' => '2 Years',
                        'fee' => '6,000/month'
                    ],
                    [
                        'icon' => 'fa-laptop',
                        'title' => 'Intermediate - Computer Science',
                        'desc' => 'ICS program combining mathematics with computer science. Perfect for students interested in IT, software development, and technology fields.',
                        'duration' => '2 Years',
                        'fee' => '6,000/month'
                    ],
                    [
                        'icon' => 'fa-pencil-alt',
                        'title' => 'ECAT Preparation',
                        'desc' => 'Intensive preparation course for Engineering College Admission Test. Covers all test patterns, practice questions, and proven strategies for success.',
                        'duration' => '3-6 Months',
                        'fee' => '8,000/month'
                    ],
                    [
                        'icon' => 'fa-stethoscope',
                        'title' => 'MDCAT Preparation',
                        'desc' => 'Comprehensive Medical and Dental College Admission Test preparation. Expert faculty, extensive practice tests, and personalized guidance.',
                        'duration' => '3-6 Months',
                        'fee' => '8,000/month'
                    ],
                    [
                        'icon' => 'fa-laptop-code',
                        'title' => 'Computer Programming',
                        'desc' => 'Learn modern programming languages including C++, Python, Java, and web development. Hands-on projects and practical coding experience.',
                        'duration' => '6 Months',
                        'fee' => '4,000/month'
                    ],
                    [
                        'icon' => 'fa-globe',
                        'title' => 'Web Development',
                        'desc' => 'Complete web development course covering HTML, CSS, JavaScript, PHP, and MySQL. Build real-world websites and applications.',
                        'duration' => '6 Months',
                        'fee' => '5,000/month'
                    ],
                    [
                        'icon' => 'fa-comments',
                        'title' => 'Spoken English',
                        'desc' => 'Improve your English communication skills with our interactive spoken English course. Focus on fluency, pronunciation, and confidence.',
                        'duration' => '3 Months',
                        'fee' => '3,000/month'
                    ],
                    [
                        'icon' => 'fa-plane',
                        'title' => 'IELTS Preparation',
                        'desc' => 'Comprehensive IELTS test preparation covering all modules: Listening, Reading, Writing, and Speaking. Expert guidance and practice tests.',
                        'duration' => '2-3 Months',
                        'fee' => '7,000/month'
                    ],
                    [
                        'icon' => 'fa-calculator',
                        'title' => 'Advanced Mathematics',
                        'desc' => 'Advanced mathematics courses for competitive exams and higher studies. Covers Calculus, Algebra, Trigonometry, and more.',
                        'duration' => '6 Months',
                        'fee' => '4,000/month'
                    ],
                    [
                        'icon' => 'fa-atom',
                        'title' => 'Physics & Chemistry',
                        'desc' => 'In-depth Physics and Chemistry courses with practical demonstrations and problem-solving techniques for all levels.',
                        'duration' => '6 Months',
                        'fee' => '4,500/month'
                    ]
                ];

                foreach ($default_courses as $course) {
                    echo '<div class="card">';
                    echo '<div class="card-icon"><i class="fas ' . $course['icon'] . '"></i></div>';
                    echo '<h3>' . $course['title'] . '</h3>';
                    echo '<p>' . $course['desc'] . '</p>';
                    echo '<p style="margin-top: 15px;"><strong>Duration:</strong> ' . $course['duration'] . '</p>';
                    echo '<p><strong>Fee:</strong> Rs. ' . $course['fee'] . '</p>';
                    echo '<a href="admission.php" class="btn btn-primary mt-30">Enroll Now</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Admission Requirements -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Requirements</span>
            <h2>Admission Requirements</h2>
            <p>What you need to know before applying</p>
        </div>
        <div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
            <div class="card">
                <h3 style="color: var(--primary-color); margin-bottom: 20px;">For Matric Programs</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Previous class result card</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Birth certificate or B-Form</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ 4 passport size photographs</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Parent/Guardian CNIC copy</li>
                    <li style="padding: 10px 0;">✓ Admission fee</li>
                </ul>
            </div>
            <div class="card">
                <h3 style="color: var(--primary-color); margin-bottom: 20px;">For Intermediate Programs</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Matric certificate & result card</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ CNIC or B-Form</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ 6 passport size photographs</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Migration certificate (if applicable)</li>
                    <li style="padding: 10px 0;">✓ Admission & registration fee</li>
                </ul>
            </div>
            <div class="card">
                <h3 style="color: var(--primary-color); margin-bottom: 20px;">For Short Courses</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Educational certificates (as applicable)</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ CNIC or B-Form copy</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ 2 passport size photographs</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">✓ Course registration form</li>
                    <li style="padding: 10px 0;">✓ Course fee</li>
                </ul>
            </div>
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
