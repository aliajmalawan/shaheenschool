<?php
/**
 * Settings Helper Functions
 * Use these functions to fetch dynamic settings from database
 */

// Global settings cache
$_settings_cache = null;

/**
 * Load all settings from database into cache
 */
function loadSettings() {
    global $conn, $_settings_cache;

    if ($_settings_cache !== null) {
        return $_settings_cache;
    }

    $_settings_cache = [];
    $result = mysqli_query($conn, "SELECT setting_key, setting_value FROM settings");

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_settings_cache[$row['setting_key']] = $row['setting_value'];
        }
    }

    return $_settings_cache;
}

/**
 * Get a setting value by key
 * @param string $key Setting key
 * @param string $default Default value if setting not found
 * @return string Setting value
 */
function getSetting($key, $default = '') {
    global $_settings_cache;

    if ($_settings_cache === null) {
        loadSettings();
    }

    return isset($_settings_cache[$key]) ? $_settings_cache[$key] : $default;
}

/**
 * Get site name
 */
function getSiteName() {
    return getSetting('site_name', 'SHAHEEN PUBLIC HIGH SCHOOL');
}

/**
 * Get site email
 */
function getSiteEmail() {
    return getSetting('site_email', 'info@shaheenschool.com');
}

/**
 * Get site phone
 */
function getSitePhone() {
    return getSetting('site_phone', '0306-1345242');
}

/**
 * Get site address
 */
function getSiteAddress() {
    return getSetting('site_address', 'Basti Malook, Multan, Pakistan');
}

/**
 * Get office hours
 */
function getOfficeHours() {
    return getSetting('office_hours', 'Mon - Sat: 8:00 AM - 5:00 PM');
}

/**
 * Get social media URLs
 */
function getSocialMedia() {
    return [
        'facebook' => getSetting('facebook_url'),
        'instagram' => getSetting('instagram_url'),
        'youtube' => getSetting('youtube_url'),
        'twitter' => getSetting('twitter_url')
    ];
}

/**
 * Get hero section content
 */
function getHeroContent() {
    return [
        'title' => getSetting('hero_title', 'Lighting the Candle of Knowledge'),
        'description' => getSetting('hero_description', 'Empowering students with quality education and nurturing their potential to become future leaders.'),
        'button_text' => getSetting('hero_button_text', 'Apply Now'),
        'button_link' => getSetting('hero_button_link', 'admission.php'),
        'image' => getSetting('hero_image', 'images/fortschool.jpg')
    ];
}

/**
 * Get statistics
 */
function getStatistics() {
    return [
        'students' => getSetting('stats_students', '500'),
        'teachers' => getSetting('stats_teachers', '50'),
        'courses' => getSetting('stats_courses', '15'),
        'years' => getSetting('stats_years', '10')
    ];
}

/**
 * Get about page content
 */
function getAboutContent() {
    return [
        'description' => getSetting('about_description', 'SHAHEEN PUBLIC HIGH SCHOOL is a leading educational institution committed to excellence in education...'),
        'mission' => getSetting('mission_statement', 'To provide quality education and empower students to achieve their full potential.'),
        'vision' => getSetting('vision_statement', 'To be a center of educational excellence that nurtures future leaders and innovators.')
    ];
}

/**
 * Get footer content
 */
function getFooterContent() {
    return [
        'about_text' => getSetting('footer_about_text', 'SHAHEEN PUBLIC HIGH SCHOOL is dedicated to providing quality education and nurturing the potential of every student.'),
        'copyright' => getSetting('copyright_text', 'SHAHEEN PUBLIC HIGH SCHOOL. All rights reserved.')
    ];
}

/**
 * Get leadership messages
 */
function getLeadershipMessages() {
    global $conn;

    $query = "SELECT * FROM leadership WHERE status = 'active' ORDER BY display_order ASC";
    $result = mysqli_query($conn, $query);

    $leaders = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $leaders[] = $row;
        }
    }

    return $leaders;
}

/**
 * Get hero carousel slides
 */
function getHeroCarouselSlides() {
    global $conn;

    $query = "SELECT * FROM hero_carousel WHERE status = 'active' ORDER BY display_order ASC";
    $result = mysqli_query($conn, $query);

    $slides = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $slides[] = $row;
        }
    }

    return $slides;
}

/**
 * Get active feature_cards rows for a given section (why_choose_us,
 * digital_features, learner_attributes, assessment_features, core_values,
 * faculty_highlights, admission_requirements, admission_process)
 */
function getFeatureCards($section) {
    global $conn;

    $section_escaped = mysqli_real_escape_string($conn, $section);
    $query = "SELECT * FROM feature_cards WHERE section = '$section_escaped' AND status = 'active' ORDER BY display_order ASC, id ASC";
    $result = mysqli_query($conn, $query);

    $cards = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cards[] = $row;
        }
    }

    return $cards;
}

/**
 * Render a list of feature_cards as standard .card / .card-icon markup
 * (used by "Why Choose Us", "Learner Attributes", "Core Values",
 * "Why Our Faculty Stands Out"). Pass $centered = true to also center
 * the card text (used by grid-4 sections like Learner Attributes).
 */
function renderFeatureCardGrid($section, $centered = false) {
    $cards = getFeatureCards($section);
    $class = 'card reveal' . ($centered ? ' text-center' : '');
    $icon_style = $centered ? ' style="margin: 0 auto 22px;"' : '';

    foreach ($cards as $card) {
        echo '<div class="' . $class . '">';
        echo '<div class="card-icon"' . $icon_style . '><i class="' . htmlspecialchars($card['icon']) . '"></i></div>';
        echo '<h3>' . htmlspecialchars($card['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($card['description']) . '</p>';
        echo '</div>';
    }
}
?>
