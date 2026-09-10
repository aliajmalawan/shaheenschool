<?php
require_once 'includes/config.php';
$page_title = 'Home';
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Carousel Section -->
<?php $carousel_slides = getHeroCarouselSlides(); ?>
<section class="hero-carousel" style="position: relative; min-height: 620px; overflow: hidden; padding: 0;">
    <?php if (!empty($carousel_slides)): ?>
        <?php foreach ($carousel_slides as $index => $slide): ?>
            <div class="carousel-slide hero-cover <?php echo $index === 0 ? 'active' : ''; ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo htmlspecialchars($slide['image_path']); ?>'); opacity: <?php echo $index === 0 ? '1' : '0'; ?>; transition: opacity 1.5s ease-in-out;">
                <div class="container" style="text-align: center;">
                    <div class="hero-content" style="max-width: 900px; margin: 0 auto;">
                        <span class="eyebrow on-dark">Welcome to <?php echo getSiteName(); ?></span>
                        <h1 style="color: <?php echo htmlspecialchars($slide['text_color'] ?? '#ffffff'); ?>; animation: fadeInUp 1s;">
                            <?php echo htmlspecialchars($slide['title'] ?: 'Welcome to ' . getSiteName()); ?>
                        </h1>
                        <?php if (!empty($slide['subtitle'])): ?>
                            <p class="tagline" style="color: <?php echo htmlspecialchars($slide['text_color'] ?? '#ffffff'); ?>; animation: fadeInUp 1.2s;">
                                <?php echo htmlspecialchars($slide['subtitle']); ?>
                            </p>
                        <?php endif; ?>
                        <div class="btn-group" style="justify-content: center; animation: fadeInUp 1.4s;">
                            <a href="admission.php" class="btn btn-primary">Apply Now</a>
                            <a href="about.php" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Carousel Navigation Dots -->
        <div class="carousel-indicators" style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 10; display: flex; gap: 12px;">
            <?php foreach ($carousel_slides as $index => $slide): ?>
                <button class="carousel-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>" style="width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; background: <?php echo $index === 0 ? 'white' : 'transparent'; ?>; cursor: pointer; transition: all 0.3s;"></button>
            <?php endforeach; ?>
        </div>

        <!-- Carousel Navigation Arrows -->
        <button class="carousel-prev" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border: none; color: white; width: 48px; height: 48px; border-radius: 50%; font-size: 22px; cursor: pointer; transition: all 0.3s;">&lt;</button>
        <button class="carousel-next" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border: none; color: white; width: 48px; height: 48px; border-radius: 50%; font-size: 22px; cursor: pointer; transition: all 0.3s;">&gt;</button>
    <?php else: ?>
        <!-- Fallback to static hero if no carousel slides -->
        <?php $hero = getHeroContent(); ?>
        <div class="hero-cover" style="background-image: url('<?php echo htmlspecialchars($hero['image']); ?>');">
            <div class="container" style="text-align: center;">
                <div class="hero-content" style="max-width: 900px; margin: 0 auto;">
                    <span class="eyebrow on-dark">Welcome to <?php echo getSiteName(); ?></span>
                    <h1>Welcome to <?php echo getSiteName(); ?></h1>
                    <p class="tagline"><?php echo htmlspecialchars($hero['title']); ?></p>
                    <p><?php echo htmlspecialchars($hero['description']); ?></p>
                    <div class="btn-group" style="justify-content: center;">
                        <a href="<?php echo htmlspecialchars($hero['button_link']); ?>" class="btn btn-primary"><?php echo htmlspecialchars($hero['button_text']); ?></a>
                        <a href="about.php" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- Carousel JavaScript -->
<style>
.carousel-prev:hover, .carousel-next:hover {
    background: rgba(255,255,255,0.35) !important;
}

.carousel-dot:hover {
    background: rgba(255,255,255,0.7) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    let currentSlide = 0;
    const totalSlides = slides.length;

    if (totalSlides <= 1) return; // No need for carousel if only one slide

    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => {
            slide.style.opacity = '0';
            slide.classList.remove('active');
        });

        // Remove active from all dots
        dots.forEach(dot => {
            dot.style.background = 'transparent';
            dot.classList.remove('active');
        });

        // Show current slide
        slides[index].style.opacity = '1';
        slides[index].classList.add('active');
        dots[index].style.background = 'white';
        dots[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    // Auto advance carousel every 5 seconds
    let autoPlay = setInterval(nextSlide, 5000);

    // Next button
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            nextSlide();
            clearInterval(autoPlay);
            autoPlay = setInterval(nextSlide, 5000);
        });
    }

    // Previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            clearInterval(autoPlay);
            autoPlay = setInterval(nextSlide, 5000);
        });
    }

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            currentSlide = index;
            showSlide(currentSlide);
            clearInterval(autoPlay);
            autoPlay = setInterval(nextSlide, 5000);
        });
    });

    // Pause on hover
    const carouselSection = document.querySelector('.hero-carousel');
    if (carouselSection) {
        carouselSection.addEventListener('mouseenter', () => {
            clearInterval(autoPlay);
        });

        carouselSection.addEventListener('mouseleave', () => {
            autoPlay = setInterval(nextSlide, 5000);
        });
    }
});
</script>

<!-- Moving Notifications -->
<?php
$notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE status = 'active' ORDER BY display_order ASC LIMIT 10");
if ($notifications && mysqli_num_rows($notifications) > 0):
?>
<div style="background: var(--accent-color); color: var(--ink); padding: 12px 0; overflow: hidden; position: relative;">
    <div style="display: flex; align-items: center;">
        <div style="background: var(--ink); color: white; padding: 12px 25px; font-weight: 700; font-size: 13px; letter-spacing: .04em; position: absolute; left: 0; z-index: 2;">
            <i class="fas fa-bullhorn"></i> NOTIFICATIONS
        </div>
        <div style="margin-left: 200px; overflow: hidden; width: 100%;">
            <div class="notification-ticker" style="display: flex; animation: scroll 30s linear infinite; white-space: nowrap;">
                <?php
                while ($notif = mysqli_fetch_assoc($notifications)) {
                    if ($notif['link']) {
                        echo '<a href="' . htmlspecialchars($notif['link']) . '" style="color: var(--ink); text-decoration: none; font-weight: 600; padding: 0 50px; display: inline-flex; align-items: center;">';
                        echo '<i class="fas fa-circle" style="font-size: 8px; margin-right: 12px;"></i>';
                        echo htmlspecialchars($notif['title']);
                        echo '</a>';
                    } else {
                        echo '<span style="font-weight: 600; padding: 0 50px; display: inline-flex; align-items: center;">';
                        echo '<i class="fas fa-circle" style="font-size: 8px; margin-right: 12px;"></i>';
                        echo htmlspecialchars($notif['title']);
                        echo '</span>';
                    }
                }
                // Repeat for continuous scroll
                mysqli_data_seek($notifications, 0);
                while ($notif = mysqli_fetch_assoc($notifications)) {
                    if ($notif['link']) {
                        echo '<a href="' . htmlspecialchars($notif['link']) . '" style="color: var(--ink); text-decoration: none; font-weight: 600; padding: 0 50px; display: inline-flex; align-items: center;">';
                        echo '<i class="fas fa-circle" style="font-size: 8px; margin-right: 12px;"></i>';
                        echo htmlspecialchars($notif['title']);
                        echo '</a>';
                    } else {
                        echo '<span style="font-weight: 600; padding: 0 50px; display: inline-flex; align-items: center;">';
                        echo '<i class="fas fa-circle" style="font-size: 8px; margin-right: 12px;"></i>';
                        echo htmlspecialchars($notif['title']);
                        echo '</span>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<style>
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.notification-ticker:hover {
    animation-play-state: paused;
}
</style>
<?php endif; ?>

<!-- Stats Section -->
<?php $stats = getStatistics(); ?>
<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h3><?php echo htmlspecialchars($stats['students']); ?>+</h3>
                <p>Active Students</p>
            </div>
            <div class="stat-item">
                <h3><?php echo htmlspecialchars($stats['teachers']); ?>+</h3>
                <p>Expert Teachers</p>
            </div>
            <div class="stat-item">
                <h3><?php echo htmlspecialchars($stats['courses']); ?>+</h3>
                <p>Courses Offered</p>
            </div>
            <div class="stat-item">
                <h3><?php echo htmlspecialchars($stats['years']); ?>+</h3>
                <p>Years of Excellence</p>
            </div>
        </div>
    </div>
</section>

<!-- Digital School Management System -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow"><i class="fas fa-laptop-code"></i> Digitized Campus</span>
            <h2>Complete Digital School Management System</h2>
            <p><?php echo getSiteName(); ?> is fully digitized — experience modern education management with cutting-edge technology.</p>
        </div>

        <div class="grid-auto mb-30">
            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <div>
                    <h4>Online Exam Results</h4>
                    <p>Instant results & analysis</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-user-check"></i></div>
                <div>
                    <h4>Digital Attendance</h4>
                    <p>Real-time tracking</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <h4>WhatsApp & SMS</h4>
                    <p>Auto alerts to parents</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-comments"></i></div>
                <div>
                    <h4>Parent Complaints</h4>
                    <p>Quick resolution system</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-wallet"></i></div>
                <div>
                    <h4>Fee History</h4>
                    <p>Online fee management</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <h4>Digital Diaries</h4>
                    <p>Online homework</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-calendar-alt"></i></div>
                <div>
                    <h4>Smart Timetable</h4>
                    <p>Dynamic schedules</p>
                </div>
            </div>

            <div class="feature-row reveal">
                <div class="feature-icon"><i class="fas fa-clipboard-list"></i></div>
                <div>
                    <h4>PTM Notes</h4>
                    <p>Meeting & feedback</p>
                </div>
            </div>
        </div>

        <!-- Mobile App CTA -->
        <div class="reveal" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: var(--radius-lg); padding: 40px; box-shadow: var(--shadow-md); display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
            <div style="flex: 0 0 auto;">
                <i class="fas fa-mobile-alt" style="font-size: 60px; color: var(--accent-color);"></i>
            </div>
            <div style="flex: 1 1 300px;">
                <h3 style="color: white; font-size: 24px; margin: 0 0 8px 0; font-weight: 700;">Download Our Mobile App</h3>
                <p style="color: rgba(255,255,255,0.85); font-size: 15px; margin: 0; line-height: 1.6;">
                    Access all school features on your smartphone! Stay connected anytime, anywhere.
                </p>
            </div>
            <div style="flex: 0 0 auto; display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="https://play.google.com/store/apps/details?id=com.forteducationsystem" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.4); color: white; padding: 12px 24px; border-radius: var(--radius-sm); text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(0,0,0,0.6)'" onmouseout="this.style.background='rgba(0,0,0,0.4)'">
                    <i class="fab fa-google-play" style="font-size: 24px;"></i>
                    <div style="text-align: left;">
                        <div style="font-size: 9px; font-weight: 400; opacity: 0.8;">GET IT ON</div>
                        <div style="font-size: 15px;">Google Play</div>
                    </div>
                </a>
                <a href="#" style="display: inline-flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.4); color: white; padding: 12px 24px; border-radius: var(--radius-sm); text-decoration: none; font-size: 14px; font-weight: 600; opacity: 0.5; cursor: not-allowed;" title="Coming Soon">
                    <i class="fab fa-apple" style="font-size: 28px;"></i>
                    <div style="text-align: left;">
                        <div style="font-size: 9px; font-weight: 400; opacity: 0.8;">Download on the</div>
                        <div style="font-size: 15px;">App Store</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Cambridge EdTech Innovation Section -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow"><i class="fas fa-graduation-cap"></i> Pioneering Cambridge Education</span>
            <h2>First in Sadiqabad to Embrace<br>Cambridge-Aligned EdTech</h2>
        </div>

        <div class="grid-2 reveal">
            <!-- Content Side -->
            <div class="card" style="border-left: 4px solid var(--accent-color); padding: 40px;">
                <p style="font-size: 17px; line-height: 1.9; color: var(--text-dark); margin-bottom: 22px; font-weight: 500;">
                    <i class="fas fa-star" style="color: var(--accent-color); margin-right: 10px;"></i>
                    <?php echo getSiteName(); ?> <strong style="color: var(--primary-color);">proudly becomes the first school in the city</strong> to adopt a complete Cambridge-aligned EdTech solution, setting a new benchmark in modern education.
                </p>

                <p style="font-size: 16px; line-height: 1.9; color: var(--text-dark); margin-bottom: 22px;">
                    <i class="fas fa-chalkboard-teacher" style="color: var(--primary-color); margin-right: 10px;"></i>
                    Our classrooms are transforming into <strong style="color: var(--primary-color);">fully smart, technology-enabled learning spaces</strong>, where teachers deliver lessons through visual, interactive, and concept-based teaching methods.
                </p>

                <p style="font-size: 16px; line-height: 1.9; color: var(--text-dark); margin-bottom: 22px;">
                    <i class="fas fa-laptop-code" style="color: var(--primary-color); margin-right: 10px;"></i>
                    By integrating digital screens, smart content, and structured Cambridge-style pedagogy, we move <strong style="color: var(--primary-color);">beyond rote learning toward critical thinking</strong> and real understanding.
                </p>

                <div style="background: var(--primary-soft); padding: 22px; border-radius: var(--radius-md);">
                    <p style="font-size: 16px; line-height: 1.9; color: var(--text-dark); margin: 0; font-weight: 500;">
                        <i class="fas fa-rocket" style="color: var(--accent-color); margin-right: 10px; font-size: 18px;"></i>
                        This innovative approach empowers students to learn the way the <strong style="color: var(--primary-color);">21st century demands</strong> — with clarity, engagement, and confidence — preparing them not just for exams, but for the future.
                    </p>
                </div>
            </div>

            <!-- Image Carousel Side -->
            <div style="position: relative;">
                <div class="cambridge-carousel" style="border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); position: relative; aspect-ratio: 4/3; background: var(--surface);">
                    <!-- Carousel Images -->
                    <div class="cambridge-slide active" style="position: absolute; width: 100%; height: 100%; opacity: 1; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_one.jpeg" alt="Cambridge EdTech - Smart Classroom" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_two.png" alt="Cambridge EdTech - Interactive Learning" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_three.png" alt="Cambridge EdTech - Digital Content" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_four.jpeg" alt="Cambridge EdTech - Modern Teaching" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_five.png" alt="Cambridge EdTech - Smart Education" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <!-- Navigation Arrows -->
                    <button class="cambridge-prev" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(11,17,31,0.55); backdrop-filter: blur(4px); border: none; color: white; width: 46px; height: 46px; border-radius: 50%; font-size: 18px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="cambridge-next" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(11,17,31,0.55); backdrop-filter: blur(4px); border: none; color: white; width: 46px; height: 46px; border-radius: 50%; font-size: 18px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Carousel Indicators -->
                    <div class="cambridge-indicators" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 10; display: flex; gap: 8px;">
                        <button class="cambridge-dot active" data-slide="0" style="width: 32px; height: 5px; border-radius: 3px; border: none; background: var(--accent-color); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="1" style="width: 32px; height: 5px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="2" style="width: 32px; height: 5px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="3" style="width: 32px; height: 5px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="4" style="width: 32px; height: 5px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                    </div>
                </div>

                <!-- Decorative Badge -->
                <div style="position: absolute; top: -18px; right: -14px; background: var(--accent-color); color: var(--ink); padding: 13px 22px; border-radius: var(--radius-pill); font-weight: 800; font-size: 13px; box-shadow: var(--shadow-md); z-index: 5;">
                    <i class="fas fa-trophy"></i> FIRST IN CITY
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cambridge Carousel JavaScript -->
<style>
.cambridge-prev:hover, .cambridge-next:hover {
    background: rgba(11,17,31,0.8) !important;
    transform: translateY(-50%) scale(1.08);
}

.cambridge-dot:hover {
    background: rgba(255, 255, 255, 0.8) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.cambridge-slide');
    const dots = document.querySelectorAll('.cambridge-dot');
    const prevBtn = document.querySelector('.cambridge-prev');
    const nextBtn = document.querySelector('.cambridge-next');
    let currentSlide = 0;
    const totalSlides = slides.length;

    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => {
            slide.style.opacity = '0';
            slide.classList.remove('active');
        });

        // Remove active from all dots
        dots.forEach(dot => {
            dot.style.background = 'rgba(255,255,255,0.5)';
            dot.classList.remove('active');
        });

        // Show current slide
        slides[index].style.opacity = '1';
        slides[index].classList.add('active');
        dots[index].style.background = 'var(--accent-color)';
        dots[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    // Auto advance carousel every 4 seconds
    let autoPlay = setInterval(nextSlide, 4000);

    // Next button
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            nextSlide();
            clearInterval(autoPlay);
            autoPlay = setInterval(nextSlide, 4000);
        });
    }

    // Previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            clearInterval(autoPlay);
            autoPlay = setInterval(nextSlide, 4000);
        });
    }

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            currentSlide = index;
            showSlide(currentSlide);
            clearInterval(autoPlay);
            autoPlay = setInterval(nextSlide, 4000);
        });
    });

    // Pause on hover
    const carouselSection = document.querySelector('.cambridge-carousel');
    if (carouselSection) {
        carouselSection.addEventListener('mouseenter', () => {
            clearInterval(autoPlay);
        });

        carouselSection.addEventListener('mouseleave', () => {
            autoPlay = setInterval(nextSlide, 4000);
        });
    }
});
</script>

<?php include 'includes/leadership_section.php'; ?>

<!-- Why Choose Us Section -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Why Choose Us</span>
            <h2>Why Choose <?php echo getSiteName(); ?>?</h2>
            <p>Excellence in education with a student-centered approach</p>
        </div>
        <div class="card-grid">
            <div class="card reveal">
                <div class="card-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Expert Faculty</h3>
                <p>Learn from highly qualified and experienced teachers dedicated to student success.</p>
            </div>
            <div class="card reveal">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Modern Facilities</h3>
                <p>State-of-the-art classrooms and learning resources for an enhanced educational experience.</p>
            </div>
            <div class="card reveal">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Small Class Sizes</h3>
                <p>Personalized attention with optimal student-teacher ratios for better learning outcomes.</p>
            </div>
            <div class="card reveal">
                <div class="card-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Quality Education</h3>
                <p>Curriculum designed to meet modern educational standards and prepare students for the future.</p>
            </div>
            <div class="card reveal">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Proven Results</h3>
                <p>Track record of excellent exam results and successful student placements.</p>
            </div>
            <div class="card reveal">
                <div class="card-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h3>Affordable Fees</h3>
                <p>Quality education at competitive rates with flexible payment options available.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section>
    <div class="container">
        <div class="cta-banner reveal">
            <h2>Ready to Start Your Educational Journey?</h2>
            <p>Join <?php echo getSiteName(); ?> today and unlock your potential</p>
            <div class="btn-group" style="justify-content: center;">
                <a href="admission.php" class="btn btn-primary">Apply for Admission</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
