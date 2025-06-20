<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if (isset($_POST['subscribe'])) {
    $userEmail = $_POST['email'];

    // Validate email
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address'); window.history.back();</script>";
        exit;
    }

    $adminEmail = "vaman0404@gmail.com";  // 👉 Your email here

    $mail = new PHPMailer(true);

    try {
        // SMTP setup
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vaman0404@gmail.com';      // Your Gmail
        $mail->Password   = 'ytat cdnt lvly uspi';  // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Send to Admin
        $mail->setFrom('vaman0404@gmail.com', 'Subscription Notification');
        $mail->addAddress($adminEmail);
        $mail->Subject = 'New Subscription';
        $mail->Body    = "A new user has subscribed with email: $userEmail";
        $mail->send();

        // Send confirmation to user
        $mail->clearAddresses();
        $mail->addAddress($userEmail);
        $mail->Subject = 'Thanks for Subscribing!';
        $mail->Body    = "Hello,\n\nThanks for subscribing to Vaman Studio. Stay tuned for updates!\n\nRegards,\nVaman Studio";
        $mail->send();

        echo "<script>alert('Subscribed Successfully!'); window.location.href='indexx.html';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Something went wrong!'); window.history.back();</script>";
    }
}
?>
