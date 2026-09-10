<?php
require_once 'includes/config.php';
$page_title = 'Our Faculty';
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero-cover" style="min-height: 360px; background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1600');">
    <div class="container text-center">
        <span class="eyebrow on-dark">Our Team</span>
        <h1 style="color: #fff; font-size: clamp(32px, 4vw, 48px); font-weight: 800;">Our Expert Faculty</h1>
        <p style="font-size: 18px; max-width: 700px; margin: 16px auto 0; color: rgba(255,255,255,0.88);">Meet our dedicated and experienced teachers committed to your success</p>
    </div>
</section>

<!-- Faculty Section -->
<section class="bg-light">
    <div class="container">
        <div class="card-grid">
            <?php
            // Fetch faculty from database
            $faculty_query = "SELECT * FROM faculty WHERE status = 'active' ORDER BY display_order ASC";
            $faculty_result = mysqli_query($conn, $faculty_query);

            if ($faculty_result && mysqli_num_rows($faculty_result) > 0) {
                while ($teacher = mysqli_fetch_assoc($faculty_result)) {
                    echo '<div class="card" style="text-align: center;">';
                    if (!empty($teacher['photo'])) {
                        echo '<img src="' . htmlspecialchars($teacher['photo']) . '" alt="' . htmlspecialchars($teacher['name']) . '" style="width: 150px; height: 150px; border-radius: 50%; margin: 0 auto 20px; object-fit: cover;">';
                    } else {
                        echo '<div style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 50px;"><i class="fas fa-user"></i></div>';
                    }
                    echo '<h3>' . htmlspecialchars($teacher['name']) . '</h3>';
                    echo '<p style="color: var(--accent-color); font-weight: 600; margin-bottom: 15px;">' . htmlspecialchars($teacher['designation']) . '</p>';
                    if (!empty($teacher['subjects'])) {
                        echo '<p style="margin-bottom: 10px;"><strong>Subjects:</strong> ' . htmlspecialchars($teacher['subjects']) . '</p>';
                    }
                    if (!empty($teacher['qualification'])) {
                        echo '<p style="margin-bottom: 10px;"><strong>Qualification:</strong> ' . htmlspecialchars($teacher['qualification']) . '</p>';
                    }
                    if (!empty($teacher['experience'])) {
                        echo '<p><strong>Experience:</strong> ' . htmlspecialchars($teacher['experience']) . ' years</p>';
                    }
                    echo '</div>';
                }
            } else {
                // Default faculty members
                $default_faculty = [
                    [
                        'name' => 'Prof. Muhammad Ahmed',
                        'designation' => 'Head of Science Department',
                        'subjects' => 'Physics, Mathematics',
                        'qualification' => 'MSc Physics',
                        'experience' => '15'
                    ],
                    [
                        'name' => 'Dr. Fatima Khan',
                        'designation' => 'Senior Biology Teacher',
                        'subjects' => 'Biology, Chemistry',
                        'qualification' => 'PhD Biology',
                        'experience' => '12'
                    ],
                    [
                        'name' => 'Sir Usman Ali',
                        'designation' => 'Mathematics Expert',
                        'subjects' => 'Mathematics, Statistics',
                        'qualification' => 'MSc Mathematics',
                        'experience' => '10'
                    ],
                    [
                        'name' => 'Miss Ayesha Malik',
                        'designation' => 'English Language Instructor',
                        'subjects' => 'English, IELTS',
                        'qualification' => 'MA English',
                        'experience' => '8'
                    ],
                    [
                        'name' => 'Sir Hassan Raza',
                        'designation' => 'Computer Science Teacher',
                        'subjects' => 'Programming, Web Development',
                        'qualification' => 'BS Computer Science',
                        'experience' => '7'
                    ],
                    [
                        'name' => 'Sir Bilal Iqbal',
                        'designation' => 'Chemistry Specialist',
                        'subjects' => 'Chemistry',
                        'qualification' => 'MSc Chemistry',
                        'experience' => '11'
                    ],
                    [
                        'name' => 'Miss Zainab Shah',
                        'designation' => 'Urdu & Islamiat Teacher',
                        'subjects' => 'Urdu, Islamiat, Pakistan Studies',
                        'qualification' => 'MA Urdu, MA Islamiat',
                        'experience' => '9'
                    ],
                    [
                        'name' => 'Sir Kamran Abbas',
                        'designation' => 'Entry Test Coordinator',
                        'subjects' => 'ECAT, MDCAT Preparation',
                        'qualification' => 'MSc Physics',
                        'experience' => '13'
                    ]
                ];

                foreach ($default_faculty as $teacher) {
                    echo '<div class="card" style="text-align: center;">';
                    echo '<div style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 50px;"><i class="fas fa-chalkboard-teacher"></i></div>';
                    echo '<h3>' . $teacher['name'] . '</h3>';
                    echo '<p style="color: var(--accent-color); font-weight: 600; margin-bottom: 15px;">' . $teacher['designation'] . '</p>';
                    echo '<p style="margin-bottom: 10px;"><strong>Subjects:</strong> ' . $teacher['subjects'] . '</p>';
                    echo '<p style="margin-bottom: 10px;"><strong>Qualification:</strong> ' . $teacher['qualification'] . '</p>';
                    echo '<p><strong>Experience:</strong> ' . $teacher['experience'] . ' years</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Why Our Faculty is Best -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">What Sets Us Apart</span>
            <h2>Why Our Faculty Stands Out</h2>
            <p>Qualities that make our teachers exceptional</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Highly Qualified</h3>
                <p>All our teachers hold advanced degrees and professional certifications in their respective fields.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3>Experienced Professionals</h3>
                <p>Years of teaching experience with proven track records of student success and achievement.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Student-Centered Approach</h3>
                <p>Dedicated to understanding individual student needs and adapting teaching methods accordingly.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3>Continuous Learning</h3>
                <p>Regularly update their knowledge and skills through professional development and training.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Excellent Communication</h3>
                <p>Clear and effective communicators who make complex concepts easy to understand.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3>Supportive Mentors</h3>
                <p>Go beyond teaching to provide guidance, support, and encouragement to every student.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section>
    <div class="container">
        <div class="cta-banner reveal">
            <h2>Learn from the Best!</h2>
            <p>Join <?php echo getSiteName(); ?> and experience quality teaching</p>
            <div class="btn-group" style="justify-content: center;">
                <a href="admission.php" class="btn btn-primary">Apply for Admission</a>
                <a href="courses.php" class="btn btn-outline">View Courses</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
