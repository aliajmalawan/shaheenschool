<?php
require_once 'includes/config.php';
$page_title = 'Gallery';
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero" style="background: linear-gradient(rgba(11, 77, 162, 0.7), rgba(10, 58, 122, 0.7)), url('https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?w=1600') center/cover no-repeat; padding: 100px 0; min-height: 400px; display: flex; align-items: center;">
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Photo Gallery</h1>
        <p style="font-size: 20px; max-width: 700px; margin: 20px auto 0; color: white; text-shadow: 1px 1px 5px rgba(0,0,0,0.7);">Explore moments captured at SHAHEEN PUBLIC HIGH SCHOOL</p>
    </div>
</section>

<!-- Gallery Categories -->
<section class="bg-light">
    <div class="container">
        <div style="text-align: center; margin-bottom: 40px;">
            <button class="btn btn-primary" style="margin: 5px;" onclick="filterGallery('all')">All</button>
            <button class="btn btn-primary" style="margin: 5px; background: var(--secondary-color); color: var(--primary-color); border: 2px solid var(--primary-color);" onclick="filterGallery('events')">Events</button>
            <button class="btn btn-primary" style="margin: 5px; background: var(--secondary-color); color: var(--primary-color); border: 2px solid var(--primary-color);" onclick="filterGallery('classes')">Classes</button>
            <button class="btn btn-primary" style="margin: 5px; background: var(--secondary-color); color: var(--primary-color); border: 2px solid var(--primary-color);" onclick="filterGallery('activities')">Activities</button>
            <button class="btn btn-primary" style="margin: 5px; background: var(--secondary-color); color: var(--primary-color); border: 2px solid var(--primary-color);" onclick="filterGallery('achievements')">Achievements</button>
        </div>

        <div id="galleryGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            <?php
            $gallery_query = "SELECT * FROM gallery WHERE status = 'active' ORDER BY created_at DESC";
            $gallery_result = mysqli_query($conn, $gallery_query);

            if ($gallery_result && mysqli_num_rows($gallery_result) > 0) {
                while ($image = mysqli_fetch_assoc($gallery_result)) {
                    echo '<div class="gallery-item" data-category="' . htmlspecialchars($image['category']) . '" style="position: relative; overflow: hidden; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">';
                    echo '<img src="' . htmlspecialchars($image['image_path']) . '" alt="' . htmlspecialchars($image['title']) . '" style="width: 100%; height: 250px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;" onmouseover="this.style.transform=\'scale(1.1)\'" onmouseout="this.style.transform=\'scale(1)\'">';
                    if (!empty($image['title'])) {
                        echo '<div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 15px 10px 10px; color: white;">';
                        echo '<p style="text-align: center; margin: 0; font-weight: 600; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">' . htmlspecialchars($image['title']) . '</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            } else {
                // No gallery items message
                echo '<div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">';
                echo '<i class="fas fa-images" style="font-size: 100px; color: var(--text-light); margin-bottom: 30px; opacity: 0.3;"></i>';
                echo '<h3 style="color: var(--text-dark); margin-bottom: 15px; font-size: 28px;">Gallery Coming Soon</h3>';
                echo '<p style="color: var(--text-light); font-size: 18px; max-width: 500px; margin: 0 auto;">We are working on adding amazing photos of our events, classes, and achievements. Check back soon!</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<script>
function filterGallery(category) {
    const items = document.querySelectorAll('.gallery-item');
    const buttons = document.querySelectorAll('button[onclick^="filterGallery"]');

    // Update button styles
    buttons.forEach(btn => {
        btn.style.background = 'var(--secondary-color)';
        btn.style.color = 'var(--primary-color)';
        btn.style.border = '2px solid var(--primary-color)';
    });

    event.target.style.background = 'var(--accent-color)';
    event.target.style.color = 'var(--primary-color)';
    event.target.style.border = 'none';

    // Filter items
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>
