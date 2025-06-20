<?php

// ✅ PHPMailer include
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

// ✅ Booking Form Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizing inputs
    $name     = htmlspecialchars($_POST["name"] ?? '');
    $email    = htmlspecialchars($_POST["email"] ?? '');
    $phone    = htmlspecialchars($_POST["phone"] ?? '');
    $address  = htmlspecialchars($_POST["address"] ?? '');
    $service  = htmlspecialchars($_POST["service"] ?? '');
    $location = htmlspecialchars($_POST["location"] ?? '');
    $date     = htmlspecialchars($_POST["date"] ?? '');
    $time     = htmlspecialchars($_POST["time"] ?? '');
    $package  = htmlspecialchars($_POST["package"] ?? '');

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email'); window.history.back();</script>";
        exit;
    }

    // Email Body Template
    $body = "
        <h2>New Booking Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Address:</strong> $address</p>
        <p><strong>Service:</strong> $service</p>
        <p><strong>Location:</strong> $location</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>Time:</strong> $time</p>
        <p><strong>Package:</strong> $package</p>
    ";

    // ✅ Sending Email to Admin and User
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vaman0404@gmail.com';  // Your Gmail address
        $mail->Password   = 'ytat cdnt lvly uspi'; // Your Gmail App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Enable debugging to get detailed SMTP logs (optional)
        $mail->SMTPDebug = 2;

        // Send to Admin
        $mail->setFrom('vaman0404@gmail.com', 'Vaman Studio');
        $mail->addAddress('vaman0404@gmail.com');  // Admin's email
        $mail->isHTML(true);
        $mail->Subject = "New Booking from $name";
        $mail->Body    = $body;
        $mail->send();

        // ✅ Send Confirmation Email to User
        $mail->clearAddresses();  // Clear previous addresses
        $mail->addAddress($email);  // Send to the user's email
        $mail->Subject = "Booking Confirmation - Vaman Studio";
        $mail->Body = "<h2>Dear $name,</h2><p>Thank you for booking with us. Here's your booking detail:</p>" . $body;
        $mail->send();

        // Success message and redirect
        echo "<script>alert('Booking successful! Confirmation sent.'); window.location.href='indexx.html';</script>";
        exit;

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;  // Output detailed error if any
    }
}
?>
