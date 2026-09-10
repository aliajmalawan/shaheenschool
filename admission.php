<?php
require_once 'includes/config.php';
$page_title = 'Admission';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
    $cnic_bform = mysqli_real_escape_string($conn, $_POST['cnic_bform']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $previous_education = mysqli_real_escape_string($conn, $_POST['previous_education']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Handle file upload
    $document_path = '';
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == 0) {
        $file_name = time() . '_' . $_FILES['documents']['name'];
        $target_dir = "uploads/documents/";
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['documents']['tmp_name'], $target_file)) {
            $document_path = $target_file;
        }
    }

    $insert_query = "INSERT INTO admissions (student_name, father_name, cnic_bform, phone, email, address, course_id, previous_education, documents, message, status, created_at)
                     VALUES ('$student_name', '$father_name', '$cnic_bform', '$phone', '$email', '$address', '$course_id', '$previous_education', '$document_path', '$message', 'pending', NOW())";

    if (mysqli_query($conn, $insert_query)) {
        // Send email notification to admin
        $admin_email = ADMIN_EMAIL;
        $subject_admin = "New Admission Application - SHAHEEN PUBLIC HIGH SCHOOL";

        $message_admin = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #0B4DA2; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .info-table td { padding: 10px; border-bottom: 1px solid #ddd; }
                .info-table td:first-child { font-weight: bold; width: 200px; background: #f0f0f0; }
                .footer { background: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>New Admission Application Received</h2>
            </div>
            <div class='content'>
                <p>A new admission application has been submitted on your website. Details below:</p>

                <table class='info-table'>
                    <tr>
                        <td>Student Name:</td>
                        <td>" . htmlspecialchars($student_name) . "</td>
                    </tr>
                    <tr>
                        <td>Father/Guardian Name:</td>
                        <td>" . htmlspecialchars($father_name) . "</td>
                    </tr>
                    <tr>
                        <td>CNIC/B-Form:</td>
                        <td>" . htmlspecialchars($cnic_bform) . "</td>
                    </tr>
                    <tr>
                        <td>Phone Number:</td>
                        <td>" . htmlspecialchars($phone) . "</td>
                    </tr>
                    <tr>
                        <td>Email Address:</td>
                        <td>" . htmlspecialchars($email) . "</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>" . htmlspecialchars($address) . "</td>
                    </tr>
                    <tr>
                        <td>Program/Course:</td>
                        <td>" . htmlspecialchars($course_id) . "</td>
                    </tr>
                    <tr>
                        <td>Previous Education:</td>
                        <td>" . htmlspecialchars($previous_education) . "</td>
                    </tr>
                    <tr>
                        <td>Additional Information:</td>
                        <td>" . htmlspecialchars($message) . "</td>
                    </tr>
                    <tr>
                        <td>Application Date:</td>
                        <td>" . date('d M Y, h:i A') . "</td>
                    </tr>
                </table>

                <p style='background: #fff3cd; padding: 15px; border-left: 4px solid #F9C900;'>
                    <strong>Action Required:</strong> Please review this application in your admin panel and contact the student for further process.
                </p>
            </div>
            <div class='footer'>
                <p>SHAHEEN PUBLIC HIGH SCHOOL - Lighting the Candle of Knowledge</p>
                <p>This is an automated email from your website admission form.</p>
            </div>
        </body>
        </html>
        ";

        $headers_admin = "MIME-Version: 1.0" . "\r\n";
        $headers_admin .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers_admin .= "From: SHAHEEN PUBLIC HIGH SCHOOL <noreply@shaheenschool.com>" . "\r\n";
        $headers_admin .= "Reply-To: " . $email . "\r\n";

        mail($admin_email, $subject_admin, $message_admin, $headers_admin);

        // Send confirmation email to student (if email provided)
        if (!empty($email)) {
            $subject_student = "Application Received - SHAHEEN PUBLIC HIGH SCHOOL";

            $message_student = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background: #0B4DA2; color: white; padding: 30px; text-align: center; }
                    .content { padding: 30px; background: #f9f9f9; }
                    .highlight { background: #fff3cd; padding: 20px; border-left: 4px solid #F9C900; margin: 20px 0; }
                    .footer { background: #333; color: white; padding: 20px; text-align: center; font-size: 12px; }
                    .contact-info { background: white; padding: 15px; margin: 20px 0; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h1>🎓 SHAHEEN PUBLIC HIGH SCHOOL</h1>
                    <p style='font-size: 18px; margin: 10px 0 0 0;'>Lighting the Candle of Knowledge</p>
                </div>
                <div class='content'>
                    <h2 style='color: #0B4DA2;'>Dear " . htmlspecialchars($student_name) . ",</h2>

                    <p style='font-size: 16px;'>Thank you for applying to <strong>SHAHEEN PUBLIC HIGH SCHOOL</strong>!</p>

                    <div class='highlight'>
                        <p style='margin: 0; font-size: 16px;'><strong>✓ Your application has been received successfully!</strong></p>
                    </div>

                    <p>We have received your admission application for <strong>" . htmlspecialchars($course_id) . "</strong>.</p>

                    <h3 style='color: #0B4DA2;'>Next Steps:</h3>
                    <ol style='font-size: 15px; line-height: 1.8;'>
                        <li>Our admission team will review your application</li>
                        <li>We will verify your documents and information</li>
                        <li>You will receive a call/email within 2-3 working days</li>
                        <li>Please keep your phone accessible for our call</li>
                    </ol>

                    <div class='contact-info'>
                        <h3 style='color: #0B4DA2; margin-top: 0;'>Contact Information:</h3>
                        <p style='margin: 5px 0;'><strong>📞 Phone:</strong> 0306-1345242, 0302-7480077, 0300-6346980</p>
                        <p style='margin: 5px 0;'><strong>📧 Email:</strong> info@shaheenschool.com</p>
                        <p style='margin: 5px 0;'><strong>🌐 Website:</strong> www.shaheenschool.com</p>
                        <p style='margin: 5px 0;'><strong>📍 Address:</strong> Basti Malook, Multan</p>
                    </div>

                    <p style='font-size: 14px; color: #666; margin-top: 30px;'>
                        If you have any questions, feel free to contact us at the above details.
                    </p>

                    <p style='font-size: 16px; margin-top: 30px;'>
                        <strong>Best Regards,</strong><br>
                        Admission Team<br>
                        SHAHEEN PUBLIC HIGH SCHOOL
                    </p>
                </div>
                <div class='footer'>
                    <p>SHAHEEN PUBLIC HIGH SCHOOL - Quality Education for a Bright Future</p>
                    <p style='margin: 10px 0 0 0;'>This is an automated confirmation email. Please do not reply to this email.</p>
                </div>
            </body>
            </html>
            ";

            $headers_student = "MIME-Version: 1.0" . "\r\n";
            $headers_student .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers_student .= "From: SHAHEEN PUBLIC HIGH SCHOOL <noreply@shaheenschool.com>" . "\r\n";
            $headers_student .= "Reply-To: info@shaheenschool.com" . "\r\n";

            mail($email, $subject_student, $message_student, $headers_student);
        }

        $success_message = "Your admission application has been submitted successfully! A confirmation email has been sent to your email address. We will contact you soon.";
    } else {
        $error_message = "Error submitting application. Please try again.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="hero" style="background: linear-gradient(rgba(11, 77, 162, 0.7), rgba(10, 58, 122, 0.7)), url('https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=1600') center/cover no-repeat; padding: 100px 0; min-height: 400px; display: flex; align-items: center;">
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">Admission Application</h1>
        <p style="font-size: 20px; max-width: 700px; margin: 20px auto 0; color: white; text-shadow: 1px 1px 5px rgba(0,0,0,0.7);">Start your educational journey with SHAHEEN PUBLIC HIGH SCHOOL</p>
    </div>
</section>

<!-- Admission Form -->
<section class="bg-light">
    <div class="container">
        <?php if ($success_message): ?>
            <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 10px; margin-bottom: 30px; text-align: center; border: 1px solid #c3e6cb;">
                <i class="fas fa-check-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 10px; margin-bottom: 30px; text-align: center; border: 1px solid #f5c6cb;">
                <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-right: 10px;"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div style="max-width: 800px; margin: 0 auto;">
            <div class="card" style="padding: 40px;">
                <h2 style="color: var(--primary-color); text-align: center; margin-bottom: 30px;">Admission Form</h2>

                <form method="POST" enctype="multipart/form-data" id="admissionForm" onsubmit="return validateForm('admissionForm')">
                    <div class="form-group">
                        <label for="student_name">Student Name *</label>
                        <input type="text" id="student_name" name="student_name" required placeholder="Enter student's full name">
                    </div>

                    <div class="form-group">
                        <label for="father_name">Father/Guardian Name *</label>
                        <input type="text" id="father_name" name="father_name" required placeholder="Enter father or guardian name">
                    </div>

                    <div class="form-group">
                        <label for="cnic_bform">CNIC / B-Form Number *</label>
                        <input type="text" id="cnic_bform" name="cnic_bform" required placeholder="e.g., 12345-1234567-1">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="03001234567">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="your.email@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Residential Address *</label>
                        <textarea id="address" name="address" required placeholder="Enter complete address"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="course_id">Select Program/Course *</label>
                        <select id="course_id" name="course_id" required>
                            <option value="">-- Choose a Program --</option>
                            <?php
                            $courses_query = "SELECT id, name FROM courses WHERE status = 'active' ORDER BY name ASC";
                            $courses_result = mysqli_query($conn, $courses_query);

                            if ($courses_result && mysqli_num_rows($courses_result) > 0) {
                                while ($course = mysqli_fetch_assoc($courses_result)) {
                                    $selected = (isset($_GET['course']) && $_GET['course'] == $course['id']) ? 'selected' : '';
                                    echo '<option value="' . $course['id'] . '" ' . $selected . '>' . htmlspecialchars($course['name']) . '</option>';
                                }
                            } else {
                                // Default options
                                $default_programs = [
                                    'Matric - Science',
                                    'Matric - Arts',
                                    'Intermediate - Pre-Engineering',
                                    'Intermediate - Pre-Medical',
                                    'Intermediate - Computer Science',
                                    'ECAT Preparation',
                                    'MDCAT Preparation',
                                    'Computer Programming',
                                    'Web Development',
                                    'Spoken English',
                                    'IELTS Preparation'
                                ];
                                foreach ($default_programs as $program) {
                                    echo '<option value="' . $program . '">' . $program . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="previous_education">Previous Education *</label>
                        <input type="text" id="previous_education" name="previous_education" required placeholder="e.g., Matric from XYZ School, 85%">
                    </div>

                    <div class="form-group">
                        <label for="documents">Upload Documents (Optional)</label>
                        <input type="file" id="documents" name="documents" accept=".pdf,.jpg,.jpeg,.png" style="padding: 10px;">
                        <small style="color: var(--text-light); display: block; margin-top: 5px;">Supported formats: PDF, JPG, PNG (Max 5MB)</small>
                    </div>

                    <div class="form-group">
                        <label for="message">Additional Information</label>
                        <textarea id="message" name="message" placeholder="Any additional information you'd like to share..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 18px; padding: 15px;">
                        <i class="fas fa-paper-plane"></i> Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Admission Process -->
<section>
    <div class="container">
        <div class="section-header">
            <h2>Admission Process</h2>
            <p>Simple steps to join SHAHEEN PUBLIC HIGH SCHOOL</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px; font-weight: bold;">1</div>
                <h3 style="color: var(--primary-color); margin-bottom: 15px;">Fill Application</h3>
                <p>Complete the online admission form with accurate information</p>
            </div>

            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px; font-weight: bold;">2</div>
                <h3 style="color: var(--primary-color); margin-bottom: 15px;">Submit Documents</h3>
                <p>Upload or submit required documents at our office</p>
            </div>

            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px; font-weight: bold;">3</div>
                <h3 style="color: var(--primary-color); margin-bottom: 15px;">Verification</h3>
                <p>Our team will review and verify your application</p>
            </div>

            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px; font-weight: bold;">4</div>
                <h3 style="color: var(--primary-color); margin-bottom: 15px;">Confirmation</h3>
                <p>Receive confirmation and start your classes</p>
            </div>
        </div>
    </div>
</section>

<!-- Fee Information -->
<section class="bg-light">
    <div class="container">
        <div class="section-header">
            <h2>Fee Information</h2>
            <p>Transparent and affordable fee structure</p>
        </div>

        <div class="card" style="max-width: 700px; margin: 0 auto; padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <i class="fas fa-money-bill-wave" style="font-size: 60px; color: var(--accent-color);"></i>
            </div>

            <ul style="list-style: none; padding: 0;">
                <li style="padding: 15px 0; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                    <strong>Admission Fee (One Time)</strong>
                    <span>Rs. 2,000</span>
                </li>
                <li style="padding: 15px 0; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                    <strong>Matric Programs (Monthly)</strong>
                    <span>Rs. 5,000</span>
                </li>
                <li style="padding: 15px 0; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                    <strong>Intermediate Programs (Monthly)</strong>
                    <span>Rs. 6,000</span>
                </li>
                <li style="padding: 15px 0; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                    <strong>Entry Test Preparation (Monthly)</strong>
                    <span>Rs. 8,000</span>
                </li>
                <li style="padding: 15px 0; display: flex; justify-content: space-between;">
                    <strong>Short Courses (Monthly)</strong>
                    <span>Rs. 3,000 - 7,000</span>
                </li>
            </ul>

            <div style="background: var(--bg-light); padding: 20px; border-radius: 10px; margin-top: 30px; text-align: center;">
                <p style="margin: 0;"><strong>Note:</strong> Flexible payment options available. Scholarships for deserving students.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info -->
<section style="background: linear-gradient(135deg, var(--primary-color) 0%, #0a3a7a 100%); color: white; padding: 60px 0;">
    <div class="container text-center">
        <h2 style="font-size: 36px; margin-bottom: 20px;">Need Help with Admission?</h2>
        <p style="font-size: 18px; margin-bottom: 30px;">Our admission team is here to assist you</p>
        <div class="btn-group" style="justify-content: center;">
            <a href="contact.php" class="btn btn-primary">Contact Us</a>
            <a href="tel:+923061345242" class="btn btn-outline"><i class="fas fa-phone"></i> Call Now</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
