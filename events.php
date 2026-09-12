<?php
require_once 'includes/config.php';
$page_title = 'Events & News';
$meta_description = 'Stay updated with the latest events, news, and announcements from SHAHEEN PUBLIC HIGH SCHOOL, including upcoming school activities and achievements.';
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero-cover" style="min-height: 360px; background-image: url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1600');">
    <div class="container text-center">
        <span class="eyebrow on-dark">What's Happening</span>
        <h1 style="color: #fff; font-size: clamp(32px, 4vw, 48px); font-weight: 800;">Events & News</h1>
        <p style="font-size: 18px; max-width: 700px; margin: 16px auto 0; color: rgba(255,255,255,0.88);">Stay updated with latest happenings at <?php echo getSiteName(); ?></p>
    </div>
</section>

<!-- Upcoming Events -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Calendar</span>
            <h2>Upcoming Events</h2>
            <p>Mark your calendar for these exciting events</p>
        </div>

        <div class="card-grid">
            <?php
            $events_query = "SELECT * FROM events WHERE event_date >= CURDATE() AND status = 'active' ORDER BY event_date ASC LIMIT 6";
            $events_result = mysqli_query($conn, $events_query);

            if ($events_result && mysqli_num_rows($events_result) > 0) {
                while ($event = mysqli_fetch_assoc($events_result)) {
                    echo '<div class="card" style="position: relative; overflow: hidden;">';
                    if (!empty($event['image'])) {
                        echo '<img src="' . htmlspecialchars($event['image']) . '" alt="' . htmlspecialchars($event['title']) . '" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 20px;">';
                    }
                    echo '<div style="background: var(--primary-color); color: white; display: inline-block; padding: 5px 15px; border-radius: 20px; margin-bottom: 15px; font-size: 14px;">';
                    echo date('M d, Y', strtotime($event['event_date']));
                    echo '</div>';
                    echo '<h3>' . htmlspecialchars($event['title']) . '</h3>';
                    echo '<p>' . nl2br(htmlspecialchars($event['description'])) . '</p>';
                    if (!empty($event['location'])) {
                        echo '<p style="margin-top: 15px;"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($event['location']) . '</p>';
                    }
                    if (!empty($event['time'])) {
                        echo '<p><i class="fas fa-clock"></i> ' . htmlspecialchars($event['time']) . '</p>';
                    }
                    echo '</div>';
                }
            } else {
                // No upcoming events message
                echo '<div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">';
                echo '<i class="fas fa-calendar-times" style="font-size: 80px; color: var(--text-light); margin-bottom: 20px;"></i>';
                echo '<h3 style="color: var(--text-dark); margin-bottom: 10px;">No Upcoming Events</h3>';
                echo '<p style="color: var(--text-light);">Check back soon for exciting events and activities!</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Latest News -->
<section>
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Newsroom</span>
            <h2>Latest News & Announcements</h2>
            <p>Recent updates from <?php echo getSiteName(); ?></p>
        </div>

        <div style="max-width: 900px; margin: 0 auto;">
            <?php
            $news_query = "SELECT * FROM news WHERE status = 'active' ORDER BY created_at DESC LIMIT 5";
            $news_result = mysqli_query($conn, $news_query);

            if ($news_result && mysqli_num_rows($news_result) > 0) {
                while ($news = mysqli_fetch_assoc($news_result)) {
                    echo '<div class="card" style="margin-bottom: 30px; padding: 0; overflow: hidden;">';

                    // Display image if exists
                    if (!empty($news['image'])) {
                        echo '<img src="' . htmlspecialchars($news['image']) . '" alt="' . htmlspecialchars($news['title']) . '" style="width: 100%; height: 300px; object-fit: cover;">';
                    }

                    echo '<div style="padding: 30px;">';
                    echo '<div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">';
                    echo '<h3 style="flex: 1; margin: 0; color: var(--primary-color);">' . htmlspecialchars($news['title']) . '</h3>';
                    echo '<div style="display: flex; align-items: center; gap: 15px;">';

                    // Date badge
                    echo '<span style="background: var(--accent-color); color: var(--primary-color); padding: 5px 15px; border-radius: 20px; font-size: 13px; font-weight: 600;">';
                    echo '<i class="fas fa-calendar"></i> ' . date('M d, Y', strtotime($news['created_at']));
                    echo '</span>';

                    echo '</div>';
                    echo '</div>';

                    // Content
                    echo '<p style="line-height: 1.8; color: var(--text-dark); margin-bottom: 15px;">' . nl2br(htmlspecialchars($news['content'])) . '</p>';

                    // Author
                    if (!empty($news['author'])) {
                        echo '<div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid var(--bg-light);">';
                        echo '<p style="font-size: 14px; color: var(--text-light); font-style: italic;">';
                        echo '<i class="fas fa-user-circle"></i> Published by <strong>' . htmlspecialchars($news['author']) . '</strong>';
                        echo '</p>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // No news message
                echo '<div style="text-align: center; padding: 80px 20px; background: white; border-radius: 15px; box-shadow: var(--shadow);">';
                echo '<i class="fas fa-newspaper" style="font-size: 100px; color: var(--text-light); margin-bottom: 30px; opacity: 0.3;"></i>';
                echo '<h3 style="color: var(--text-dark); margin-bottom: 15px; font-size: 28px;">No News Available</h3>';
                echo '<p style="color: var(--text-light); font-size: 18px; max-width: 500px; margin: 0 auto;">Check back soon for latest updates and announcements from SHAHEEN PUBLIC HIGH SCHOOL!</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section>
    <div class="container">
        <div class="cta-banner reveal">
            <h2>Stay Connected!</h2>
            <p>Follow us on social media to never miss an update</p>
            <div class="social-links" style="justify-content: center;">
                <a href="https://www.facebook.com/forteducationsystem/" target="_blank" style="width: 50px; height: 50px; font-size: 20px;"><i class="fab fa-facebook"></i></a>
                <a href="#" target="_blank" style="width: 50px; height: 50px; font-size: 20px;"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank" style="width: 50px; height: 50px; font-size: 20px;"><i class="fab fa-youtube"></i></a>
                <a href="#" target="_blank" style="width: 50px; height: 50px; font-size: 20px;"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
