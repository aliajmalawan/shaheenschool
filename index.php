<?php
require_once 'includes/config.php';
$page_title = 'Home';
$meta_description = 'SHAHEEN PUBLIC HIGH SCHOOL in Sadiqabad offers quality education from Matric to Intermediate, with experienced faculty, modern facilities, and a focus on academic excellence and character building.';
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
                        <?php
                        // Only one <h1> per page for SEO - the first slide gets the
                        // real heading tag, the rest reuse its look via .hero-heading
                        // so the carousel still looks identical as it rotates.
                        $heading_tag = $index === 0 ? 'h1' : 'p';
                        ?>
                        <<?php echo $heading_tag; ?> class="hero-heading" style="color: <?php echo htmlspecialchars($slide['text_color'] ?? '#ffffff'); ?>; animation: fadeInUp 1s;">
                            <?php echo htmlspecialchars($slide['title'] ?: 'Welcome to ' . getSiteName()); ?>
                        </<?php echo $heading_tag; ?>>
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

<!-- Our Campuses -->
<?php $home_campuses = mysqli_query($conn, "SELECT * FROM campuses WHERE status = 'active' ORDER BY display_order ASC, id ASC"); ?>
<?php if ($home_campuses && mysqli_num_rows($home_campuses) > 0): ?>
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Our Network</span>
            <h2>Our Project</h2>
            <p>Beyond our main campus, <?php echo getSiteName(); ?> operates specialized institutes for focused learning</p>
        </div>
        <div class="card-grid">
            <?php while ($c = mysqli_fetch_assoc($home_campuses)): ?>
            <div class="card reveal text-center">
                <?php if (!empty($c['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($c['image_path']); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>" loading="lazy" style="width: 100%; height: 160px; object-fit: cover; border-radius: var(--radius-md); margin-bottom: 20px;">
                <?php else: ?>
                    <div class="card-icon" style="margin: 0 auto 20px;"><i class="fas <?php echo htmlspecialchars($c['icon'] ?: 'fa-school'); ?>"></i></div>
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($c['name']); ?></h3>
                <?php if (!empty($c['tagline'])): ?>
                    <p style="color: var(--primary-color); font-weight: 600; margin-bottom: 10px;"><?php echo htmlspecialchars($c['tagline']); ?></p>
                <?php endif; ?>
                <?php if (!empty($c['description'])): ?>
                    <p><?php echo htmlspecialchars($c['description']); ?></p>
                <?php else: ?>
                    <p style="font-style: italic; color: var(--text-light);">More details about this campus are coming soon.</p>
                <?php endif; ?>
                <?php if (!empty($c['address']) || !empty($c['phone'])): ?>
                <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border-color); text-align: left; font-size: 14px; color: var(--text-light);">
                    <?php if (!empty($c['address'])): ?>
                        <p style="margin-bottom: 6px;"><i class="fas fa-map-marker-alt" style="color: var(--primary-color); width: 16px;"></i> <?php echo htmlspecialchars($c['address']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($c['phone'])): ?>
                        <p><i class="fas fa-phone" style="color: var(--primary-color); width: 16px;"></i> <?php echo htmlspecialchars($c['phone']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <a href="campuses.php" class="btn btn-outline-dark" style="margin-top: 20px;">Learn More</a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Learning Philosophy Intro -->
<section>
    <div class="container text-center">
        <div class="reveal" style="max-width: 800px; margin: 0 auto;">
            <span class="eyebrow">Our Philosophy</span>
            <h2 style="font-size: clamp(28px, 3.4vw, 40px); font-weight: 800; margin-bottom: 20px;">Where Learning is a Personal Journey</h2>
            <p style="font-size: 18px; line-height: 1.9; margin-bottom: 30px;">
                At <?php echo getSiteName(); ?>, we believe every child learns differently. Our teachers take the time to understand each student's strengths, curiosities, and pace — building a supportive environment where confidence grows alongside knowledge, and every learner is guided toward their own version of success.
            </p>
            <div class="btn-group" style="justify-content: center;">
                <a href="about.php" class="btn btn-secondary">Learn More</a>
                <a href="contact.php" class="btn btn-outline-dark">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Our Approach to Assessment -->
<section class="bg-light">
    <div class="container">
        <div class="grid-2 reveal">
            <div>
                <span class="eyebrow">Assessment Philosophy</span>
                <h2 style="margin-bottom: 20px;">Our Approach to Assessment</h2>
                <p style="margin-bottom: 15px; line-height: 1.8;"><?php echo nl2br(htmlspecialchars(getSetting('assessment_paragraph_1'))); ?></p>
                <p style="margin-bottom: 25px; line-height: 1.8;"><?php echo nl2br(htmlspecialchars(getSetting('assessment_paragraph_2'))); ?></p>
                <a href="about.php" class="btn btn-secondary">Learn More</a>
            </div>
            <div style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 40px;">
                <div style="display: flex; flex-direction: column; gap: 28px;">
                    <?php
                    $assessment_features = mysqli_query($conn, "SELECT * FROM feature_cards WHERE section = 'assessment_features' AND status = 'active' ORDER BY display_order ASC, id ASC");
                    if ($assessment_features) {
                        while ($f = mysqli_fetch_assoc($assessment_features)) {
                            echo '<div style="display: flex; align-items: center; gap: 18px;">';
                            echo '<div style="width: 54px; height: 54px; border-radius: var(--radius-md); background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 22px; color: #fff; flex-shrink: 0;"><i class="' . htmlspecialchars($f['icon']) . '"></i></div>';
                            echo '<div>';
                            echo '<strong style="display: block; color: #fff; font-size: 17px; margin-bottom: 4px;">' . htmlspecialchars($f['title']) . '</strong>';
                            echo '<span style="color: rgba(255,255,255,0.75); font-size: 14px;">' . htmlspecialchars($f['description']) . '</span>';
                            echo '</div></div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Learner Attributes -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">What We Nurture</span>
            <h2>Learner Attributes We Build</h2>
            <p>Qualities every student develops throughout their journey with us</p>
        </div>
        <div class="grid-4">
            <?php renderFeatureCardGrid('learner_attributes', true); ?>
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
            <?php foreach (getFeatureCards('digital_features') as $f): ?>
                <div class="feature-row reveal">
                    <div class="feature-icon"><i class="<?php echo htmlspecialchars($f['icon']); ?>"></i></div>
                    <div>
                        <h4><?php echo htmlspecialchars($f['title']); ?></h4>
                        <p><?php echo htmlspecialchars($f['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
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
                    <?php echo nl2br(htmlspecialchars(getSetting('cambridge_paragraph_1'))); ?>
                </p>

                <p style="font-size: 16px; line-height: 1.9; color: var(--text-dark); margin-bottom: 22px;">
                    <i class="fas fa-chalkboard-teacher" style="color: var(--primary-color); margin-right: 10px;"></i>
                    <?php echo nl2br(htmlspecialchars(getSetting('cambridge_paragraph_2'))); ?>
                </p>

                <p style="font-size: 16px; line-height: 1.9; color: var(--text-dark); margin-bottom: 22px;">
                    <i class="fas fa-laptop-code" style="color: var(--primary-color); margin-right: 10px;"></i>
                    <?php echo nl2br(htmlspecialchars(getSetting('cambridge_paragraph_3'))); ?>
                </p>

                <div style="background: var(--primary-soft); padding: 22px; border-radius: var(--radius-md);">
                    <p style="font-size: 16px; line-height: 1.9; color: var(--text-dark); margin: 0; font-weight: 500;">
                        <i class="fas fa-rocket" style="color: var(--accent-color); margin-right: 10px; font-size: 18px;"></i>
                        <?php echo nl2br(htmlspecialchars(getSetting('cambridge_highlight'))); ?>
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
                        <img src="images/digital_two.jpg" alt="Cambridge EdTech - Interactive Learning" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_three.jpg" alt="Cambridge EdTech - Digital Content" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_four.jpeg" alt="Cambridge EdTech - Modern Teaching" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="cambridge-slide" style="position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        <img src="images/digital_five.jpg" alt="Cambridge EdTech - Smart Education" style="width: 100%; height: 100%; object-fit: cover;">
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
            <?php renderFeatureCardGrid('why_choose_us'); ?>
        </div>
    </div>
</section>

<!-- Campus Gallery -->
<?php $home_gallery = mysqli_query($conn, "SELECT * FROM gallery WHERE status = 'active' ORDER BY created_at DESC LIMIT 4"); ?>
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Campus Life</span>
            <h2>Campus Gallery</h2>
            <p>A glimpse into the spaces where our students learn, grow, and thrive</p>
        </div>
        <?php if ($home_gallery && mysqli_num_rows($home_gallery) > 0): ?>
        <div class="grid-auto reveal">
            <?php while ($photo = mysqli_fetch_assoc($home_gallery)): ?>
                <img src="<?php echo htmlspecialchars($photo['image_path']); ?>" alt="<?php echo htmlspecialchars($photo['title'] ?: 'Campus photo'); ?>" loading="lazy" style="width: 100%; height: 220px; object-fit: cover; border-radius: var(--radius-lg); box-shadow: var(--shadow-xs);">
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="text-center reveal" style="padding: 20px;">
            <i class="fas fa-images" style="font-size: 60px; color: var(--border-color); margin-bottom: 20px;"></i>
            <p style="color: var(--text-light); font-size: 18px;">Campus photos are on their way — check back soon!</p>
        </div>
        <?php endif; ?>
        <div class="text-center mt-30">
            <a href="gallery.php" class="btn btn-secondary">View Full Gallery</a>
        </div>
    </div>
</section>

<!-- Parent & Alumni Testimonials -->
<?php $home_reviews = mysqli_query($conn, "SELECT * FROM alumni_reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT 6"); ?>
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Testimonials</span>
            <h2>What Parents & Alumni Say</h2>
            <p>Real experiences from our school community</p>
        </div>
        <?php if ($home_reviews && mysqli_num_rows($home_reviews) > 0): ?>
        <div class="testimonial-carousel reveal">
            <div class="testimonial-track">
                <?php while ($rev = mysqli_fetch_assoc($home_reviews)): ?>
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <?php for ($i = 0; $i < $rev['rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
                    </div>
                    <p class="testimonial-quote">"<?php echo htmlspecialchars($rev['review']); ?>"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        <div>
                            <strong><?php echo htmlspecialchars($rev['name']); ?></strong>
                            <?php if ($rev['passing_year']): ?><span>Batch <?php echo htmlspecialchars($rev['passing_year']); ?></span><?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <button type="button" class="testimonial-nav prev" aria-label="Previous review"><i class="fas fa-chevron-left"></i></button>
            <button type="button" class="testimonial-nav next" aria-label="Next review"><i class="fas fa-chevron-right"></i></button>
        </div>
        <?php else: ?>
        <p class="text-center" style="color: var(--text-light);">We're gathering feedback from our school community — check back soon, or <a href="alumni.php#review" style="color: var(--primary-color); font-weight: 600;">share your experience</a>.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Blogs / Latest News -->
<?php $home_news = mysqli_query($conn, "SELECT * FROM news WHERE status = 'active' ORDER BY created_at DESC LIMIT 3"); ?>
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">From Our Blog</span>
            <h2>Latest News & Insights</h2>
            <p>Stories, updates, and announcements from <?php echo getSiteName(); ?></p>
        </div>
        <?php if ($home_news && mysqli_num_rows($home_news) > 0): ?>
        <div class="card-grid">
            <?php while ($post = mysqli_fetch_assoc($home_news)): ?>
            <div class="card reveal" style="padding: 0; overflow: hidden;">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="width: 100%; height: 180px; object-fit: cover;">
                <?php endif; ?>
                <div style="padding: 26px;">
                    <span class="eyebrow" style="margin-bottom: 12px;">Blog</span>
                    <h3 style="margin-bottom: 10px;"><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 110)) . '...'; ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-30">
            <a href="events.php" class="btn btn-secondary">View All News</a>
        </div>
        <?php else: ?>
        <div class="text-center reveal" style="padding: 20px;">
            <i class="fas fa-newspaper" style="font-size: 60px; color: var(--border-color); margin-bottom: 20px;"></i>
            <p style="color: var(--text-light); font-size: 18px;">New stories are on their way — check back soon!</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- FAQs -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Got Questions?</span>
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers for prospective families</p>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>What programs does <?php echo getSiteName(); ?> offer?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>We offer Matric and Intermediate programs (Pre-Engineering, Pre-Medical, Computer Science), entry test preparation for ECAT/MDCAT, and short courses in programming, web development, spoken English, and IELTS. Visit our Courses page for full details.</p>
                </div>
            </div>
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>How can I apply for admission?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>You can apply online through our Admission page or visit our campus in person with the required documents and admission fee.</p>
                </div>
            </div>
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Is the school Cambridge-aligned?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes — we are the first school in Sadiqabad to adopt a complete Cambridge-aligned EdTech solution, combining smart classrooms with structured, concept-based teaching.</p>
                </div>
            </div>
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Do you offer scholarships?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes, we offer merit-based scholarships and financial assistance to deserving students. Contact our admission office for details.</p>
                </div>
            </div>
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>What is the fee structure?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Our fees are transparent and affordable, ranging from Rs. 3,000/month for short courses to Rs. 8,000/month for entry test preparation. See the Admission page for the complete breakdown.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Us -->
<section>
    <div class="container">
        <div class="grid-2 reveal" style="align-items: center;">
            <div>
                <span class="eyebrow">Get In Touch</span>
                <h2 style="margin-bottom: 18px;">Have a Question? Send Us a Message</h2>
                <p style="margin-bottom: 25px; line-height: 1.8;">Our admission team typically responds within 24-48 hours. For urgent queries, feel free to call or visit our campus directly.</p>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="info-icon" style="width: 44px; height: 44px;"><i class="fas fa-map-marker-alt"></i></div>
                        <span><?php echo nl2br(htmlspecialchars(getSiteAddress())); ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="info-icon" style="width: 44px; height: 44px;"><i class="fas fa-phone"></i></div>
                        <span><?php echo htmlspecialchars(getSitePhone()); ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="info-icon" style="width: 44px; height: 44px;"><i class="fas fa-envelope"></i></div>
                        <span><?php echo htmlspecialchars(getSiteEmail()); ?></span>
                    </div>
                </div>
            </div>
            <div class="card" style="padding: 36px;">
                <form method="POST" action="contact.php">
                    <div class="form-group">
                        <label for="home_name">Your Name *</label>
                        <input type="text" id="home_name" name="name" required placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="home_email">Email Address *</label>
                        <input type="email" id="home_email" name="email" required placeholder="your.email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="home_phone">Phone Number *</label>
                        <input type="tel" id="home_phone" name="phone" required placeholder="03001234567">
                    </div>
                    <input type="hidden" name="subject" value="General Question">
                    <div class="form-group">
                        <label for="home_message">Your Message *</label>
                        <textarea id="home_message" name="message" required placeholder="Write your message here..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
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
