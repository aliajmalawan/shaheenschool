<?php
require_once 'includes/config.php';
$page_title = 'Contact Us';

$success_message = '';
$error_message = '';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert_query = "INSERT INTO contacts (name, email, phone, subject, message, status, created_at)
                     VALUES ('$name', '$email', '$phone', '$subject', '$message', 'unread', NOW())";

    if (mysqli_query($conn, $insert_query)) {
        // Send email notification to admin
        $admin_email = ADMIN_EMAIL;
        $subject_admin = "New Contact Message - SHAHEEN PUBLIC HIGH SCHOOL";

        $message_admin = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #0B4DA2; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; }
                .info-table td { padding: 12px; border-bottom: 1px solid #ddd; }
                .info-table td:first-child { font-weight: bold; width: 150px; background: #f0f0f0; }
                .footer { background: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>New Contact Message Received</h2>
            </div>
            <div class='content'>
                <p>Someone has sent a message through your website contact form:</p>

                <table class='info-table'>
                    <tr>
                        <td>Name:</td>
                        <td>" . htmlspecialchars($name) . "</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>" . htmlspecialchars($email) . "</td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>" . htmlspecialchars($phone) . "</td>
                    </tr>
                    <tr>
                        <td>Subject:</td>
                        <td><strong>" . htmlspecialchars($subject) . "</strong></td>
                    </tr>
                    <tr>
                        <td>Message:</td>
                        <td>" . nl2br(htmlspecialchars($message)) . "</td>
                    </tr>
                    <tr>
                        <td>Date/Time:</td>
                        <td>" . date('d M Y, h:i A') . "</td>
                    </tr>
                </table>

                <p style='background: #d4edda; padding: 15px; border-left: 4px solid #28a745;'>
                    <strong>💡 Quick Action:</strong> Reply to <a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a> or call " . htmlspecialchars($phone) . "
                </p>
            </div>
            <div class='footer'>
                <p>SHAHEEN PUBLIC HIGH SCHOOL - Contact Form Notification</p>
                <p>Check your admin panel for more details.</p>
            </div>
        </body>
        </html>
        ";

        $headers_admin = "MIME-Version: 1.0" . "\r\n";
        $headers_admin .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers_admin .= "From: SHAHEEN PUBLIC HIGH SCHOOL <noreply@shaheenschool.com>" . "\r\n";
        $headers_admin .= "Reply-To: " . $email . "\r\n";

        mail($admin_email, $subject_admin, $message_admin, $headers_admin);

        // Send confirmation email to sender
        $subject_sender = "Thank You for Contacting SHAHEEN PUBLIC HIGH SCHOOL";

        $message_sender = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #0B4DA2; color: white; padding: 30px; text-align: center; }
                .content { padding: 30px; background: #f9f9f9; }
                .highlight { background: #d4edda; padding: 20px; border-left: 4px solid #28a745; margin: 20px 0; }
                .footer { background: #333; color: white; padding: 20px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>SHAHEEN PUBLIC HIGH SCHOOL</h1>
                <p style='font-size: 18px; margin: 10px 0 0 0;'>Lighting the Candle of Knowledge</p>
            </div>
            <div class='content'>
                <h2 style='color: #0B4DA2;'>Dear " . htmlspecialchars($name) . ",</h2>

                <p style='font-size: 16px;'>Thank you for reaching out to us!</p>

                <div class='highlight'>
                    <p style='margin: 0; font-size: 16px;'><strong>✓ We have received your message successfully!</strong></p>
                </div>

                <p>Your message regarding \"<strong>" . htmlspecialchars($subject) . "</strong>\" has been received by our team.</p>

                <p>We appreciate you taking the time to contact SHAHEEN PUBLIC HIGH SCHOOL. Our team will review your message and get back to you within <strong>24-48 hours</strong>.</p>

                <div style='background: white; padding: 20px; margin: 20px 0; border-radius: 5px;'>
                    <h3 style='color: #0B4DA2; margin-top: 0;'>Need Immediate Assistance?</h3>
                    <p style='margin: 5px 0;'><strong>📞 Call us:</strong> 0300-6700956</p>
                    <p style='margin: 5px 0;'><strong>📧 Email:</strong> info@shaheenschool.com</p>
                    <p style='margin: 5px 0;'><strong>📍 Address:</strong> KLP Rd, Arif Town, Sadiqabad</p>
                    <p style='margin: 5px 0;'><strong>⏰ Office Hours:</strong> Monday - Saturday, 8:00 AM - 5:00 PM</p>
                </div>

                <p style='font-size: 16px; margin-top: 30px;'>
                    <strong>Best Regards,</strong><br>
                    SHAHEEN PUBLIC HIGH SCHOOL Team
                </p>
            </div>
            <div class='footer'>
                <p>SHAHEEN PUBLIC HIGH SCHOOL - Quality Education for a Bright Future</p>
                <p style='margin: 10px 0 0 0;'>This is an automated confirmation. Please do not reply to this email.</p>
            </div>
        </body>
        </html>
        ";

        $headers_sender = "MIME-Version: 1.0" . "\r\n";
        $headers_sender .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers_sender .= "From: SHAHEEN PUBLIC HIGH SCHOOL <noreply@shaheenschool.com>" . "\r\n";
        $headers_sender .= "Reply-To: info@shaheenschool.com" . "\r\n";

        mail($email, $subject_sender, $message_sender, $headers_sender);

        $success_message = "Thank you for contacting us! A confirmation email has been sent to your email address. We will get back to you soon.";
    } else {
        $error_message = "Error sending message. Please try again.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero-cover" style="min-height: 360px; background-image: url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1600');">
    <div class="container text-center">
        <span class="eyebrow on-dark">Get In Touch</span>
        <h1 style="color: #fff; font-size: clamp(32px, 4vw, 48px); font-weight: 800;">Contact Us</h1>
        <p style="font-size: 18px; max-width: 700px; margin: 16px auto 0; color: rgba(255,255,255,0.88);">Get in touch with us — we're here to help!</p>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="bg-light">
    <div class="container">
        <div class="card-grid">
            <div class="card" style="text-align: center;">
                <div class="card-icon" style="margin: 0 auto 20px;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <p>SHAHEEN PUBLIC HIGH SCHOOL<br>KLP Rd, Arif Town, Sadiqabad<br>Pakistan</p>
            </div>

            <div class="card" style="text-align: center;">
                <div class="card-icon" style="margin: 0 auto 20px;">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Call Us</h3>
                <p><a href="tel:+923006700956">0300-6700956</a><br>
                Mon - Sat: 8:00 AM - 5:00 PM</p>
            </div>

            <div class="card" style="text-align: center;">
                <div class="card-icon" style="margin: 0 auto 20px;">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <p><a href="mailto:info@shaheenschool.com">info@shaheenschool.com</a><br>
                <a href="mailto:admissions@shaheenschool.com">admissions@shaheenschool.com</a><br>
                We reply within 24 hours</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Map -->
<section>
    <div class="container">
        <div class="grid-2 reveal" style="align-items: start;">
            <!-- Contact Form -->
            <div>
                <span class="eyebrow">Contact Form</span>
                <h2 style="color: var(--ink); margin-bottom: 20px;">Send us a Message</h2>

                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo $success_message; ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?php echo $error_message; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" id="contactForm" onsubmit="return validateForm('contactForm')">
                    <div class="grid-2" style="gap: 20px; align-items: start;">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Enter your name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                        </div>
                    </div>

                    <div class="grid-2" style="gap: 20px; align-items: start;">
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="03001234567">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">-- Select Subject --</option>
                                <option value="Admission Inquiry">Admission Inquiry</option>
                                <option value="Course Information">Course Information</option>
                                <option value="Fee Inquiry">Fee Inquiry</option>
                                <option value="General Question">General Question</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Complaint">Complaint</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" required placeholder="Write your message here..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

            <!-- Google Map & Additional Info -->
            <div>
                <span class="eyebrow">Our Location</span>
                <h2 style="color: var(--ink); margin-bottom: 20px;">Find Us Here</h2>

                <!-- Google Map -->
                <div style="border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 30px; height: 400px; border: 2px solid var(--border-color); box-shadow: var(--shadow-sm);">
                    <iframe src="https://maps.google.com/maps?width=600&height=400&hl=en&q=Shaheen%20Public%20High%20School%20Sadiq%20Abad&t=&z=14&ie=UTF8&iwloc=B&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <!-- Working Hours -->
                <div class="card">
                    <h3 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-clock"></i> Working Hours</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                            <span style="display: flex; align-items: center; gap: 10px; font-weight: 600;"><i class="fas fa-calendar-day" style="color: var(--primary-color); width: 18px; text-align: center;"></i> Monday - Friday</span>
                            <span>8:00 AM - 5:00 PM</span>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                            <span style="display: flex; align-items: center; gap: 10px; font-weight: 600;"><i class="fas fa-calendar-day" style="color: var(--primary-color); width: 18px; text-align: center;"></i> Saturday</span>
                            <span>9:00 AM - 3:00 PM</span>
                        </li>
                        <li style="padding: 10px 0; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                            <span style="display: flex; align-items: center; gap: 10px; font-weight: 600;"><i class="fas fa-calendar-times" style="color: #dc3545; width: 18px; text-align: center;"></i> Sunday</span>
                            <span style="color: #dc3545; font-weight: 600;">Closed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">FAQs</span>
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions</p>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>What are the admission requirements?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Admission requirements vary by program. Generally, you need previous educational certificates, CNIC/B-Form, photographs, and the admission fee. Visit our Courses page for detailed requirements.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>How can I apply for admission?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>You can apply online through our Admission page or visit our campus in person. Fill out the application form, submit required documents, and pay the admission fee to complete the process.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>What is the fee structure?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Our fee structure is transparent and affordable. Fees vary by program, starting from Rs. 3,000/month for short courses to Rs. 8,000/month for entry test preparation. Check our Admission page for complete details.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Do you offer scholarships?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes, we offer merit-based scholarships and financial assistance to deserving students. Contact our admission office for more information about scholarship opportunities.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>How can I contact a specific teacher?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>You can visit our campus during working hours or call our main office. We'll connect you with the appropriate faculty member or department.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
