<?php
require_once 'includes/config.php';
$page_title = 'Courses & Programs';
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero" style="background: linear-gradient(rgba(11, 77, 162, 0.7), rgba(10, 58, 122, 0.7)), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1600') center/cover no-repeat; padding: 100px 0; min-height: 400px; display: flex; align-items: center;">
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Our Courses & Programs</h1>
        <p style="font-size: 20px; max-width: 700px; margin: 20px auto 0; color: white; text-shadow: 1px 1px 5px rgba(0,0,0,0.7);">Comprehensive educational programs designed to help you achieve your academic goals</p>
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
        <div class="section-header">
            <h2>Admission Requirements</h2>
            <p>What you need to know before applying</p>
        </div>
        <div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
            <div class="card">
                <h3 style="color: var(--primary-color); margin-bottom: 20px;">For Matric Programs</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Previous class result card</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Birth certificate or B-Form</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ 4 passport size photographs</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Parent/Guardian CNIC copy</li>
                    <li style="padding: 10px 0;">✓ Admission fee</li>
                </ul>
            </div>
            <div class="card">
                <h3 style="color: var(--primary-color); margin-bottom: 20px;">For Intermediate Programs</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Matric certificate & result card</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ CNIC or B-Form</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ 6 passport size photographs</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Migration certificate (if applicable)</li>
                    <li style="padding: 10px 0;">✓ Admission & registration fee</li>
                </ul>
            </div>
            <div class="card">
                <h3 style="color: var(--primary-color); margin-bottom: 20px;">For Short Courses</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Educational certificates (as applicable)</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ CNIC or B-Form copy</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ 2 passport size photographs</li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">✓ Course registration form</li>
                    <li style="padding: 10px 0;">✓ Course fee</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, var(--primary-color) 0%, #0a3a7a 100%); color: white; padding: 60px 0;">
    <div class="container text-center">
        <h2 style="font-size: 36px; margin-bottom: 20px;">Ready to Enroll?</h2>
        <p style="font-size: 18px; margin-bottom: 30px;">Start your learning journey with SHAHEEN PUBLIC HIGH SCHOOL today</p>
        <div class="btn-group" style="justify-content: center;">
            <a href="admission.php" class="btn btn-primary">Apply Now</a>
            <a href="contact.php" class="btn btn-outline">Have Questions?</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
