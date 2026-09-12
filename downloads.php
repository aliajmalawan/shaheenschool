<?php
require_once 'includes/config.php';
require_once 'includes/settings_helper.php';

// Fetch active downloads
$downloads = mysqli_query($conn, "SELECT * FROM downloads WHERE status = 'active' ORDER BY display_order ASC, date DESC");

$page_title = 'Downloads';
$meta_description = 'Download important documents, homework assignments, and study materials from SHAHEEN PUBLIC HIGH SCHOOL.';
?>
<?php include 'includes/header.php'; ?>

    <!-- Page Header -->
    <section class="hero-cover" style="min-height: 320px; background-image: url('https://images.unsplash.com/photo-1568667256549-094345857637?q=80&w=1200');">
        <div class="container text-center">
            <span class="eyebrow on-dark"><i class="fas fa-download"></i> Resources</span>
            <h1 style="color: #fff; font-size: clamp(30px, 4vw, 44px); font-weight: 800;">Downloads</h1>
            <p style="font-size: 17px; max-width: 650px; margin: 14px auto 0; color: rgba(255,255,255,0.88);">Important documents and files for students</p>
        </div>
    </section>

    <!-- Downloads Section -->
    <section class="bg-light">
        <div class="container">
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white;">
                                <th style="padding: 18px 15px; text-align: left; width: 120px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                                <th style="padding: 18px 15px; text-align: left; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
                                <th style="padding: 18px 15px; text-align: left; width: 150px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">File Type</th>
                                <th style="padding: 18px 15px; text-align: center; width: 180px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($downloads && mysqli_num_rows($downloads) > 0) {
                                while ($download = mysqli_fetch_assoc($downloads)) {
                                    $file_ext = strtolower(pathinfo($download['file_name'], PATHINFO_EXTENSION));

                                    // Icon based on file type
                                    $icon = 'fa-file';
                                    if ($file_ext == 'pdf') $icon = 'fa-file-pdf';
                                    elseif (in_array($file_ext, ['doc', 'docx'])) $icon = 'fa-file-word';
                                    elseif (in_array($file_ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                                    elseif (in_array($file_ext, ['jpg', 'jpeg', 'png'])) $icon = 'fa-file-image';
                                    elseif ($file_ext == 'zip') $icon = 'fa-file-zipper';

                                    echo '<tr class="download-row" style="border-bottom: 1px solid var(--border-color); background: var(--surface); transition: background var(--transition);">';
                                    echo '<td style="padding: 15px; font-weight: 600; color: var(--text-dark);">' . date('d.m.Y', strtotime($download['date'])) . '</td>';
                                    echo '<td style="padding: 15px; color: var(--text-dark);">' . htmlspecialchars($download['description']) . '</td>';
                                    echo '<td style="padding: 15px;"><i class="fas ' . $icon . '" style="color: var(--primary-color); margin-right: 8px;"></i><span style="font-weight: 500;">' . strtoupper($file_ext) . ' File</span></td>';
                                    echo '<td style="padding: 15px; text-align: center;">';
                                    echo '<a href="' . $download['file_path'] . '" download class="btn btn-secondary" style="padding: 10px 22px; font-size: 14px;"><i class="fas fa-download"></i> Download</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" style="padding: 40px; text-align: center; color: var(--text-light);">';
                                echo '<i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i><br>';
                                echo 'No downloads available at the moment';
                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
