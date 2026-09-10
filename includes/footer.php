    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About <?php echo getSiteName(); ?></h3>
                    <p><?php echo htmlspecialchars(getFooterContent()['about_text']); ?></p>
                    <div class="social-links">
                        <?php
                        $social = getSocialMedia();
                        if (!empty($social['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($social['facebook']); ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                        <?php endif;
                        if (!empty($social['instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($social['instagram']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif;
                        if (!empty($social['youtube'])): ?>
                            <a href="<?php echo htmlspecialchars($social['youtube']); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php endif;
                        if (!empty($social['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($social['twitter']); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="courses.php">Our Courses</a></li>
                        <li><a href="admission.php">Admission</a></li>
                        <li><a href="faculty.php">Our Faculty</a></li>
                        <li><a href="events.php">Events & News</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Programs</h3>
                    <ul>
                        <li><a href="courses.php">Matric Programs</a></li>
                        <li><a href="courses.php">Intermediate</a></li>
                        <li><a href="courses.php">Entry Test Preparation</a></li>
                        <li><a href="courses.php">Computer Courses</a></li>
                        <li><a href="courses.php">Language Courses</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo nl2br(htmlspecialchars(getSiteAddress())); ?></p>
                    <p><?php
                        $phone = getSitePhone();
                        $phone_numbers = explode(',', $phone);
                        foreach ($phone_numbers as $number): ?>
                            <i class="fas fa-phone"></i> <?php echo htmlspecialchars(trim($number)); ?><br>
                        <?php endforeach; ?>
                    </p>
                    <p><i class="fas fa-envelope"></i> <?php echo getSiteEmail(); ?></p>
                    <p><i class="fas fa-clock"></i> <?php echo htmlspecialchars(getOfficeHours()); ?></p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo getSiteName(); ?>. All rights reserved. | Designed by Computech</p>
            </div>
        </div>
    </footer>

    <!-- Website Analytics Tracker -->
    <?php
    // Track page views for analytics (only on public pages, not admin)
    if (file_exists(__DIR__ . '/analytics_tracker.php')) {
        include __DIR__ . '/analytics_tracker.php';
    }
    ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
</body>
</html>
