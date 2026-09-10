<?php
require_once 'includes/config.php';
$page_title = 'Home';
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Carousel Section -->
<?php $carousel_slides = getHeroCarouselSlides(); ?>
<section class="hero-carousel" style="position: relative; min-height: 600px; overflow: hidden;">
    <?php if (!empty($carousel_slides)): ?>
        <?php foreach ($carousel_slides as $index => $slide): ?>
            <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(11, 77, 162, 0.5), rgba(10, 58, 122, 0.6)), url('<?php echo htmlspecialchars($slide['image_path']); ?>') center/cover no-repeat; min-height: 600px; display: flex; align-items: center; opacity: <?php echo $index === 0 ? '1' : '0'; ?>; transition: opacity 1.5s ease-in-out;">
                <div class="container" style="position: relative; z-index: 2; text-align: center;">
                    <div class="hero-content" style="max-width: 900px; margin: 0 auto;">
                        <h1 style="font-size: 56px; font-weight: bold; margin-bottom: 20px; color: <?php echo htmlspecialchars($slide['text_color'] ?? '#ffffff'); ?>; text-shadow: 2px 2px 12px rgba(0,0,0,0.7); animation: fadeInUp 1s;">
                            <?php echo htmlspecialchars($slide['title'] ?: 'Welcome to ' . getSiteName()); ?>
                        </h1>
                        <?php if (!empty($slide['subtitle'])): ?>
                            <p class="tagline" style="font-size: 28px; margin-bottom: 25px; color: <?php echo htmlspecialchars($slide['text_color'] ?? '#ffffff'); ?>; text-shadow: 2px 2px 10px rgba(0,0,0,0.7); animation: fadeInUp 1.2s;">
                                <?php echo htmlspecialchars($slide['subtitle']); ?>
                            </p>
                        <?php endif; ?>
                        <div class="btn-group" style="justify-content: center; gap: 20px; animation: fadeInUp 1.4s;">
                            <a href="admission.php" class="btn btn-primary" style="padding: 15px 40px; font-size: 18px;">Apply Now</a>
                            <a href="about.php" class="btn btn-outline" style="padding: 15px 40px; font-size: 18px;">Learn More</a>
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
        <button class="carousel-prev" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.3); border: none; color: white; width: 50px; height: 50px; border-radius: 50%; font-size: 24px; cursor: pointer; transition: all 0.3s;">&lt;</button>
        <button class="carousel-next" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.3); border: none; color: white; width: 50px; height: 50px; border-radius: 50%; font-size: 24px; cursor: pointer; transition: all 0.3s;">&gt;</button>
    <?php else: ?>
        <!-- Fallback to static hero if no carousel slides -->
        <?php $hero = getHeroContent(); ?>
        <div style="background: linear-gradient(rgba(11, 77, 162, 0.5), rgba(10, 58, 122, 0.6)), url('<?php echo htmlspecialchars($hero['image']); ?>') center/cover no-repeat; min-height: 600px; display: flex; align-items: center;">
            <div class="container" style="position: relative; z-index: 2; text-align: center;">
                <div class="hero-content" style="max-width: 900px; margin: 0 auto;">
                    <h1 style="font-size: 56px; font-weight: bold; margin-bottom: 20px; text-shadow: 2px 2px 12px rgba(0,0,0,0.7);">Welcome to <?php echo getSiteName(); ?></h1>
                    <p class="tagline" style="font-size: 28px; margin-bottom: 25px; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);"><?php echo htmlspecialchars($hero['title']); ?></p>
                    <p style="font-size: 20px; margin-bottom: 40px; line-height: 1.8; text-shadow: 2px 2px 8px rgba(0,0,0,0.7);"><?php echo htmlspecialchars($hero['description']); ?></p>
                    <div class="btn-group" style="justify-content: center; gap: 20px;">
                        <a href="<?php echo htmlspecialchars($hero['button_link']); ?>" class="btn btn-primary" style="padding: 15px 40px; font-size: 18px;"><?php echo htmlspecialchars($hero['button_text']); ?></a>
                        <a href="about.php" class="btn btn-outline" style="padding: 15px 40px; font-size: 18px;">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- Carousel JavaScript -->
<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.carousel-prev:hover, .carousel-next:hover {
    background: rgba(255,255,255,0.5) !important;
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
<div style="background: var(--accent-color); color: var(--text-dark); padding: 12px 0; overflow: hidden; position: relative;">
    <div style="display: flex; align-items: center;">
        <div style="background: var(--primary-color); color: white; padding: 12px 25px; font-weight: bold; position: absolute; left: 0; z-index: 2;">
            <i class="fas fa-bullhorn"></i> NOTIFICATIONS
        </div>
        <div style="margin-left: 200px; overflow: hidden; width: 100%;">
            <div class="notification-ticker" style="display: flex; animation: scroll 30s linear infinite; white-space: nowrap;">
                <?php
                while ($notif = mysqli_fetch_assoc($notifications)) {
                    if ($notif['link']) {
                        echo '<a href="' . htmlspecialchars($notif['link']) . '" style="color: var(--text-dark); text-decoration: none; font-weight: 600; padding: 0 50px; display: inline-flex; align-items: center;">';
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
                        echo '<a href="' . htmlspecialchars($notif['link']) . '" style="color: var(--text-dark); text-decoration: none; font-weight: 600; padding: 0 50px; display: inline-flex; align-items: center;">';
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
        <div class="section-header">
            <h2>
                <i class="fas fa-laptop-code" style="color: var(--accent-color); margin-right: 15px;"></i>
                Complete Digital School Management System
            </h2>
            <p style="font-size: 18px; max-width: 800px; margin: 0 auto;">SHAHEEN PUBLIC HIGH SCHOOL is fully digitized - Experience modern education management with cutting-edge technology</p>
        </div>

        <!-- Features Grid - Compact Style -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 40px;">
            <!-- Exam Results -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #0B4DA2;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(11,77,162,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #0B4DA2, #1976D2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-chart-line" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">Online Exam Results</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Instant results & analysis</p>
                </div>
            </div>

            <!-- Attendance -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #28a745;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(40,167,69,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user-check" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">Digital Attendance</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Real-time tracking</p>
                </div>
            </div>

            <!-- WhatsApp/SMS -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #25D366;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(37,211,102,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fab fa-whatsapp" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">WhatsApp & SMS</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Auto alerts to parents</p>
                </div>
            </div>

            <!-- Parent Complaints -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #f39c12;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(243,156,18,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #f39c12, #e67e22); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-comments" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">Parent Complaints</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Quick resolution system</p>
                </div>
            </div>

            <!-- Fee History -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #9b59b6;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(155,89,182,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #9b59b6, #8e44ad); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-wallet" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">Fee History</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Online fee management</p>
                </div>
            </div>

            <!-- Digital Diaries -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #e74c3c;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(231,76,60,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #e74c3c, #c0392b); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book-open" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">Digital Diaries</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Online homework</p>
                </div>
            </div>

            <!-- Timetable -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #00bcd4;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(0,188,212,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #00bcd4, #0097a7); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-calendar-alt" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">Smart Timetable</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Dynamic schedules</p>
                </div>
            </div>

            <!-- PTM Notes -->
            <div style="display: flex; align-items: center; gap: 15px; background: white; padding: 18px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border-left: 4px solid #ff9800;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 20px rgba(255,152,0,0.2)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                <div style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #ff9800, #f57c00); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clipboard-list" style="font-size: 22px; color: white;"></i>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin: 0 0 5px 0; font-size: 16px; font-weight: 600;">PTM Notes</h4>
                    <p style="color: var(--text-light); font-size: 13px; margin: 0; line-height: 1.3;">Meeting & feedback</p>
                </div>
            </div>
        </div>

        <!-- Mobile App CTA - Compact Horizontal -->
        <div style="background: linear-gradient(135deg, #0B4DA2 0%, #1976D2 100%); border-radius: 20px; padding: 35px; box-shadow: 0 15px 40px rgba(11, 77, 162, 0.3); display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
            <div style="flex: 0 0 auto;">
                <i class="fas fa-mobile-alt" style="font-size: 70px; color: var(--accent-color);"></i>
            </div>
            <div style="flex: 1 1 300px;">
                <h3 style="color: white; font-size: 26px; margin: 0 0 10px 0; font-weight: 700;">Download Our Mobile App</h3>
                <p style="color: rgba(255,255,255,0.9); font-size: 15px; margin: 0; line-height: 1.6;">
                    Access all school features on your smartphone! Stay connected anytime, anywhere.
                </p>
            </div>
            <div style="flex: 0 0 auto; display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="https://play.google.com/store/apps/details?id=com.forteducationsystem" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; background: #000; color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fab fa-google-play" style="font-size: 26px;"></i>
                    <div style="text-align: left;">
                        <div style="font-size: 9px; font-weight: 400; opacity: 0.8;">GET IT ON</div>
                        <div style="font-size: 15px;">Google Play</div>
                    </div>
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.forteducationsystem" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; background: #000; color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: transform 0.3s ease; opacity: 0.5; cursor: not-allowed;" title="Coming Soon">
                    <i class="fab fa-apple" style="font-size: 30px;"></i>
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
<section style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <!-- Decorative Background Elements -->
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: linear-gradient(135deg, rgba(11, 77, 162, 0.1), rgba(255, 193, 7, 0.1)); border-radius: 50%; filter: blur(60px);"></div>
    <div style="position: absolute; bottom: -80px; left: -80px; width: 400px; height: 400px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(11, 77, 162, 0.1)); border-radius: 50%; filter: blur(80px);"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <!-- Section Header -->
        <div style="text-align: center; margin-bottom: 50px;">
            <div style="display: inline-flex; align-items: center; background: linear-gradient(135deg, #0B4DA2, #1976D2); color: white; padding: 12px 30px; border-radius: 50px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(11, 77, 162, 0.3);">
                <i class="fas fa-graduation-cap" style="font-size: 24px; margin-right: 12px;"></i>
                <span style="font-size: 16px; font-weight: 600; letter-spacing: 1px;">PIONEERING CAMBRIDGE EDUCATION</span>
            </div>
            <h2 style="font-size: 42px; color: var(--primary-color); margin-bottom: 15px; font-weight: 800; line-height: 1.2;">
                First in Sadiqabad to Embrace<br>
                <span style="color: var(--accent-color);">Cambridge-Aligned EdTech</span>
            </h2>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; margin-bottom: 40px;">
            <!-- Content Side -->
            <div style="padding: 30px;">
                <div style="background: white; padding: 40px; border-radius: 25px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border-left: 6px solid var(--accent-color);">
                    <p style="font-size: 18px; line-height: 1.9; color: var(--text-dark); margin-bottom: 25px; font-weight: 500;">
                        <i class="fas fa-star" style="color: var(--accent-color); margin-right: 10px;"></i>
                        Shaheen Public School, Sadiqabad <strong style="color: var(--primary-color);">proudly becomes the first school in the city</strong> to adopt a complete Cambridge-aligned EdTech solution, setting a new benchmark in modern education.
                    </p>

                    <p style="font-size: 17px; line-height: 1.9; color: var(--text-dark); margin-bottom: 25px;">
                        <i class="fas fa-chalkboard-teacher" style="color: #28a745; margin-right: 10px;"></i>
                        Our classrooms are transforming into <strong style="color: var(--primary-color);">fully smart, technology-enabled learning spaces</strong>, where teachers deliver lessons through visual, interactive, and concept-based teaching methods.
                    </p>

                    <p style="font-size: 17px; line-height: 1.9; color: var(--text-dark); margin-bottom: 25px;">
                        <i class="fas fa-laptop-code" style="color: #9b59b6; margin-right: 10px;"></i>
                        By integrating digital screens, smart content, and structured Cambridge-style pedagogy, we move <strong style="color: var(--primary-color);">beyond rote learning toward critical thinking</strong> and real understanding.
                    </p>

                    <div style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(11, 77, 162, 0.1)); padding: 25px; border-radius: 15px; border-left: 4px solid var(--primary-color);">
                        <p style="font-size: 17px; line-height: 1.9; color: var(--text-dark); margin: 0; font-weight: 500;">
                            <i class="fas fa-rocket" style="color: var(--accent-color); margin-right: 10px; font-size: 20px;"></i>
                            This innovative approach empowers students to learn the way the <strong style="color: var(--primary-color);">21st century demands</strong>—with clarity, engagement, and confidence—preparing them not just for exams, but for the future.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Image Carousel Side -->
            <div style="position: relative;">
                <div class="cambridge-carousel" style="border-radius: 25px; overflow: hidden; box-shadow: 0 25px 70px rgba(0,0,0,0.15); position: relative; aspect-ratio: 4/3; background: white;">
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
                    <button class="cambridge-prev" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(11, 77, 162, 0.9); border: none; color: white; width: 50px; height: 50px; border-radius: 50%; font-size: 20px; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="cambridge-next" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(11, 77, 162, 0.9); border: none; color: white; width: 50px; height: 50px; border-radius: 50%; font-size: 20px; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Carousel Indicators -->
                    <div class="cambridge-indicators" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 10; display: flex; gap: 10px;">
                        <button class="cambridge-dot active" data-slide="0" style="width: 40px; height: 6px; border-radius: 3px; border: none; background: var(--accent-color); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="1" style="width: 40px; height: 6px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="2" style="width: 40px; height: 6px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="3" style="width: 40px; height: 6px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                        <button class="cambridge-dot" data-slide="4" style="width: 40px; height: 6px; border-radius: 3px; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s;"></button>
                    </div>
                </div>

                <!-- Decorative Badge -->
                <div style="position: absolute; top: -20px; right: -20px; background: linear-gradient(135deg, var(--accent-color), #ff9800); color: var(--primary-color); padding: 15px 25px; border-radius: 50px; font-weight: 800; font-size: 14px; box-shadow: 0 10px 30px rgba(255, 193, 7, 0.4); z-index: 5;">
                    <i class="fas fa-trophy"></i> FIRST IN CITY
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cambridge Carousel JavaScript -->
<style>
.cambridge-prev:hover, .cambridge-next:hover {
    background: rgba(11, 77, 162, 1) !important;
    transform: translateY(-50%) scale(1.1);
}

.cambridge-dot:hover {
    background: rgba(255, 193, 7, 0.8) !important;
}

@media (max-width: 968px) {
    section > div > div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
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
        <div class="section-header">
            <h2>Why Choose SHAHEEN PUBLIC HIGH SCHOOL?</h2>
            <p>Excellence in education with a student-centered approach</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Expert Faculty</h3>
                <p>Learn from highly qualified and experienced teachers dedicated to student success.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Modern Facilities</h3>
                <p>State-of-the-art classrooms and learning resources for an enhanced educational experience.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Small Class Sizes</h3>
                <p>Personalized attention with optimal student-teacher ratios for better learning outcomes.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Quality Education</h3>
                <p>Curriculum designed to meet modern educational standards and prepare students for the future.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Proven Results</h3>
                <p>Track record of excellent exam results and successful student placements.</p>
            </div>
            <div class="card">
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
<section style="background: linear-gradient(135deg, var(--primary-color) 0%, #0a3a7a 100%); color: white; padding: 60px 0;">
    <div class="container text-center">
        <h2 style="font-size: 36px; margin-bottom: 20px;">Ready to Start Your Educational Journey?</h2>
        <p style="font-size: 18px; margin-bottom: 30px;">Join SHAHEEN PUBLIC HIGH SCHOOL today and unlock your potential</p>
        <div class="btn-group" style="justify-content: center;">
            <a href="admission.php" class="btn btn-primary">Apply for Admission</a>
            <a href="contact.php" class="btn btn-outline">Contact Us</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
