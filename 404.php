<?php
require_once 'includes/config.php';
$page_title = 'Page Not Found';
http_response_code(404);
?>
<?php include 'includes/header.php'; ?>

<section class="hero" style="min-height: 420px; display: flex; align-items: center;">
    <div class="container" style="justify-content: center; text-align: center;">
        <div class="hero-content" style="max-width: 700px; flex: 0 1 auto; margin: 0 auto;">
            <span class="eyebrow on-dark">Error 404</span>
            <h1>Page Not Found</h1>
            <p class="tagline">The page you're looking for doesn't exist or may have been moved.</p>
        </div>
    </div>
</section>

<section>
    <div class="container text-center">
        <div style="max-width: 600px; margin: 0 auto;">
            <p style="font-size: 18px; color: var(--text-light); margin-bottom: 34px; line-height: 1.8;">
                Double-check the address, or use the links below to get back on track.
            </p>
            <div class="btn-group" style="justify-content: center;">
                <a href="index.php" class="btn btn-primary">Back to Home</a>
                <a href="contact.php" class="btn btn-outline-dark">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
