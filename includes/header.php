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
    <header>
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-left">
                    <?php
                    $phone = getSitePhone();
                    $phone_numbers = explode(',', $phone);
                    $first_phone = trim($phone_numbers[0]);
                    ?>
                    <a href="tel:<?php echo str_replace([' ', '-'], '', $first_phone); ?>"><i class="fas fa-phone"></i> <?php echo $first_phone; ?></a>
                    <a href="mailto:<?php echo getSiteEmail(); ?>"><i class="fas fa-envelope"></i> <?php echo getSiteEmail(); ?></a>
                </div>
                <div class="top-bar-right">
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
        </div>

        <!-- Main Navigation -->
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">
                        <img src="<?php echo getLogoPath(); ?>" alt="<?php echo getSiteName(); ?> Logo" onerror="this.style.display='none'">
                    </a>
                    <h1><?php echo getSiteName(); ?></h1>
                </div>

                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

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
                    <li><a href="admission.php" class="nav-cta">Admissions Open</a></li>
                </ul>
            </div>
        </nav>
    </header>
