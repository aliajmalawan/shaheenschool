<?php
require_once 'includes/config.php';
$page_title = 'About Us';
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero-cover" style="min-height: 360px; background-image: url('https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1600');">
    <div class="container text-center">
        <span class="eyebrow on-dark">About Us</span>
        <h1 style="color: #fff; font-size: clamp(32px, 4vw, 48px); font-weight: 800;">About <?php echo getSiteName(); ?></h1>
        <p style="font-size: 18px; max-width: 700px; margin: 16px auto 0; color: rgba(255,255,255,0.88);">Learn about our mission, vision, and commitment to educational excellence</p>
    </div>
</section>

<!-- About Content -->
<section class="bg-light">
    <div class="container">
        <div class="grid-2 reveal" style="align-items: stretch;">
            <div>
                <?php $about = getAboutContent(); ?>
                <span class="eyebrow">Who We Are</span>
                <h2 style="color: var(--ink); font-size: 32px; margin-bottom: 20px;">Our Story</h2>
                <p style="margin-bottom: 15px; line-height: 1.8;"><?php echo nl2br(htmlspecialchars($about['description'])); ?></p>
                <p style="margin-bottom: 15px; line-height: 1.8;">Our institution stands as a beacon of knowledge, symbolized by our candle logo - representing the light of learning that illuminates the path to success. We believe in holistic education that develops not just academic excellence but also character, values, and life skills.</p>
                <p style="line-height: 1.8;">With experienced faculty, modern facilities, and a student-centered approach, we create an environment where every student can thrive and reach their full potential.</p>
            </div>
            <div style="min-height: 320px;">
                <img src="images/about_us.jpg" alt="SHAHEEN PUBLIC HIGH SCHOOL Students" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section>
    <div class="container">
        <div class="card-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Our Mission</h3>
                <p><?php echo nl2br(htmlspecialchars($about['mission'])); ?></p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Our Vision</h3>
                <p><?php echo nl2br(htmlspecialchars($about['vision'])); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Candle Logo Meaning -->
<section class="bg-light">
    <div class="container text-center">
        <div class="section-header reveal">
            <span class="eyebrow">Our Symbol</span>
            <h2>The Candle: Our Symbol of Knowledge</h2>
        </div>
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="font-size: 80px; color: var(--accent-color); margin-bottom: 30px;">🕯️</div>
            <p style="font-size: 18px; line-height: 1.8; margin-bottom: 20px;">Our logo features a candle - a timeless symbol of enlightenment and knowledge. Just as a single candle lights up the darkness, education illuminates minds and dispels ignorance.</p>
            <p style="font-size: 18px; line-height: 1.8; margin-bottom: 20px;">The candle represents our commitment to being a guiding light in our students' educational journey. It symbolizes hope, wisdom, and the continuous pursuit of knowledge that burns bright within every learner.</p>
            <p style="font-size: 18px; line-height: 1.8;">At SHAHEEN PUBLIC HIGH SCHOOL, we don't just teach - we ignite the flame of curiosity and passion for learning that will continue to burn throughout our students' lives.</p>
        </div>
    </div>
</section>

<!-- Our Values -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Our Values</span>
            <h2>Our Core Values</h2>
            <p>The principles that guide everything we do</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Excellence</h3>
                <p>We strive for the highest standards in teaching, learning, and all our educational programs.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Integrity</h3>
                <p>We uphold honesty, transparency, and ethical conduct in all our interactions and decisions.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Innovation</h3>
                <p>We embrace new ideas, modern teaching methods, and continuous improvement in education.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Respect</h3>
                <p>We value diversity, dignity, and mutual respect among students, teachers, and staff.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Community</h3>
                <p>We foster a supportive learning environment and positive relationships within our educational family.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3>Social Responsibility</h3>
                <p>We prepare students to be responsible citizens who contribute positively to society.</p>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Message -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Leadership</span>
            <h2>Message from Our Leadership</h2>
        </div>
        <div class="card reveal" style="max-width: 900px; margin: 0 auto; padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 60px;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3 style="color: var(--primary-color); margin-bottom: 5px;">Principal's Message</h3>
                <p style="color: var(--text-light);">SHAHEEN PUBLIC HIGH SCHOOL</p>
            </div>
            <p style="font-size: 18px; line-height: 1.8; font-style: italic; margin-bottom: 20px;">"Education is not just about acquiring knowledge; it's about transforming lives and shaping futures. At SHAHEEN PUBLIC HIGH SCHOOL, we are committed to providing an educational experience that goes beyond textbooks and examinations."</p>
            <p style="line-height: 1.8; margin-bottom: 15px;">We believe that every student has unique potential waiting to be discovered and nurtured. Our dedicated faculty works tirelessly to create an environment where students feel valued, challenged, and inspired to achieve their dreams.</p>
            <p style="line-height: 1.8;">I invite you to join our educational family and experience the difference that passionate teaching and personalized attention can make in your academic journey. Together, let us light the candle of knowledge and illuminate the path to success.</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section>
    <div class="container">
        <div class="cta-banner reveal">
            <h2>Join Our Educational Community</h2>
            <p>Discover how <?php echo getSiteName(); ?> can help you achieve your academic goals</p>
            <div class="btn-group" style="justify-content: center;">
                <a href="admission.php" class="btn btn-primary">Apply for Admission</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
