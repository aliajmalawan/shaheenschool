<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SHAHEEN PUBLIC HIGH SCHOOL - Quality Education for a Bright Future">
    <meta name="keywords" content="education, school, learning, fort education">
    <meta name="author" content="SHAHEEN PUBLIC HIGH SCHOOL">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo getSiteName(); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Dynamic Theme Colors -->
    <style>
        <?php echo getThemeCSS(); ?>
    </style>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo getLogoPath(); ?>">
</head>
<body>
    <!-- Header -->
    <header id="site-header">
        <!-- Top Bar: brand, contact info, social, apply -->
        <div class="topbar">
            <div class="container topbar-inner">
                <a href="index.php" class="brand">
                    <img src="<?php echo getLogoPath(); ?>" alt="<?php echo getSiteName(); ?> Logo" class="brand-logo" onerror="this.style.display='none'">
                    <span class="brand-text">
                        <strong><?php echo getSiteName(); ?></strong>
                        <small>Lighting the Candle of Knowledge</small>
                    </span>
                </a>

                <div class="topbar-info">
                    <?php
                    $phone = getSitePhone();
                    $phone_numbers = explode(',', $phone);
                    $first_phone = trim($phone_numbers[0]);
                    ?>
                    <a href="tel:<?php echo str_replace([' ', '-'], '', $first_phone); ?>" class="info-item">
                        <span class="info-icon"><i class="fas fa-phone"></i></span>
                        <span class="info-text"><small>Call Us</small><strong><?php echo htmlspecialchars($first_phone); ?></strong></span>
                    </a>
                    <a href="mailto:<?php echo getSiteEmail(); ?>" class="info-item">
                        <span class="info-icon"><i class="fas fa-envelope"></i></span>
                        <span class="info-text"><small>Email Us</small><strong><?php echo htmlspecialchars(getSiteEmail()); ?></strong></span>
                    </a>
                </div>

                <div class="topbar-actions">
                    <nav class="topbar-social" aria-label="Social media">
                        <?php
                        $social = getSocialMedia();
                        if (!empty($social['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($social['facebook']); ?>" target="_blank" rel="noopener" class="soc soc-fb" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif;
                        if (!empty($social['instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($social['instagram']); ?>" target="_blank" rel="noopener" class="soc soc-ig" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif;
                        if (!empty($social['youtube'])): ?>
                            <a href="<?php echo htmlspecialchars($social['youtube']); ?>" target="_blank" rel="noopener" class="soc soc-yt" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <?php endif;
                        if (!empty($social['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($social['twitter']); ?>" target="_blank" rel="noopener" class="soc soc-tw" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                    </nav>

                    <button type="button" id="search-toggle" class="icon-btn" aria-label="Search the website" aria-expanded="false" aria-controls="search-panel">
                        <i class="fas fa-search"></i>
                    </button>

                    <a href="admission.php" class="apply-btn"><i class="fas fa-pen"></i> <span class="btn-label">Apply Now</span></a>

                    <div class="menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Panel -->
        <div id="search-panel" class="search-panel" hidden>
            <form action="https://www.google.com/search" method="get" target="_blank" class="container search-panel-inner">
                <input type="hidden" name="q" id="search-query-prefix" value="">
                <input type="search" id="search-input" placeholder="Search this website…" autocomplete="off" aria-label="Search this website">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>

        <!-- Main Navigation -->
        <nav>
            <div class="container">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="admission.php">Admission</a></li>
                    <li><a href="faculty.php">Faculty</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Resources <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="downloads.php"><i class="fas fa-download"></i> Downloads</a></li>
                            <li><a href="alumni.php"><i class="fas fa-user-graduate"></i> Alumni</a></li>
                            <li><a href="examination.php"><i class="fas fa-file-alt"></i> Examination</a></li>
                            <li><a href="events.php"><i class="fas fa-calendar-alt"></i> Events</a></li>
                        </ul>
                    </li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>
