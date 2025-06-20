<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

    // Check individual keys safely
    $name     = isset($_POST["name"]) ? $_POST["name"] : '';
    $email    = isset($_POST["email"]) ? $_POST["email"] : '';
    $phone    = isset($_POST["phone"]) ? $_POST["phone"] : '';
    $address  = isset($_POST["address"]) ? $_POST["address"] : '';
    $service  = isset($_POST["service"]) ? $_POST["service"] : '';
    $location = isset($_POST["location"]) ? $_POST["location"] : '';
    $date     = isset($_POST["date"]) ? $_POST["date"] : '';
    $time     = isset($_POST["time"]) ? $_POST["time"] : '';
    $package  = isset($_POST["package"]) ? $_POST["package"] : '';

    // Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email Address";
        exit;
    }

    $adminEmail = "vaman0404@gmail.com";
    $subject = "New Booking Appointment - $name";

    $body = "
    <h2>New Booking Appointment</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Address:</strong> $address</p>
    <p><strong>Service Type:</strong> $service</p>
    <p><strong>Location:</strong> $location</p>
    <p><strong>Date:</strong> $date</p>
    <p><strong>Time:</strong> $time</p>
    <p><strong>Photography Package:</strong> $package</p>
    ";

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vaman0404@gmail.com'; // your Gmail
        $mail->Password   = 'ytat cdnt lvly uspi'; // your App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Admin Email
        $mail->setFrom('vaman0404@gmail.com', 'Vaman Studio');
        $mail->addAddress($adminEmail);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->send();

        // Send confirmation to user
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = "Booking Confirmation - Vaman Studio";
        $mail->Body = "
            <h2>Dear $name,</h2>
            <p>Thank you for booking with Vaman Studio. Here are your booking details:</p>
            $body
            <br><p>We’ll connect with you soon!</p>
        ";
        $mail->send();

        // ✅ Redirect to index.html after successful booking
        header("Location: index.html");
        exit();

    } catch (Exception $e) {
        echo "Booking failed. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    // If form was not submitted
    echo "Form not submitted properly.";
}
?>
