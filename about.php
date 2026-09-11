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
                <p style="margin-bottom: 15px; line-height: 1.8;"><?php echo nl2br(htmlspecialchars(getSetting('about_paragraph_2'))); ?></p>
                <p style="line-height: 1.8;"><?php echo nl2br(htmlspecialchars(getSetting('about_paragraph_3'))); ?></p>
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
            <p style="font-size: 18px; line-height: 1.8; margin-bottom: 20px;"><?php echo nl2br(htmlspecialchars(getSetting('candle_paragraph_1'))); ?></p>
            <p style="font-size: 18px; line-height: 1.8; margin-bottom: 20px;"><?php echo nl2br(htmlspecialchars(getSetting('candle_paragraph_2'))); ?></p>
            <p style="font-size: 18px; line-height: 1.8;"><?php echo nl2br(htmlspecialchars(getSetting('candle_paragraph_3'))); ?></p>
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
            <?php renderFeatureCardGrid('core_values'); ?>
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
        <?php $principal_photo = getSetting('principal_photo'); ?>
        <div class="card reveal" style="max-width: 900px; margin: 0 auto; padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <?php if (!empty($principal_photo)): ?>
                    <img src="<?php echo htmlspecialchars($principal_photo); ?>" alt="Principal" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin: 0 auto 20px; box-shadow: var(--shadow-sm); border: 4px solid var(--surface); outline: 1px solid var(--border-color);">
                <?php else: ?>
                    <div style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 60px;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                <?php endif; ?>
                <h3 style="color: var(--primary-color); margin-bottom: 5px;">Principal's Message</h3>
                <p style="color: var(--text-light);"><?php echo getSiteName(); ?></p>
            </div>
            <p style="font-size: 18px; line-height: 1.8; font-style: italic; margin-bottom: 20px;">"<?php echo nl2br(htmlspecialchars(getSetting('principal_message_quote'))); ?>"</p>
            <p style="line-height: 1.8; margin-bottom: 15px;"><?php echo nl2br(htmlspecialchars(getSetting('principal_message_para_1'))); ?></p>
            <p style="line-height: 1.8;"><?php echo nl2br(htmlspecialchars(getSetting('principal_message_para_2'))); ?></p>
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
