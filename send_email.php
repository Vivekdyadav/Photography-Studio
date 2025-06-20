<?php

// Include the email and database functions
require 'book.php';
require 'save_to_database.php';

// ✅ Booking Form Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Save booking data to the database
    if (!saveBookingToDatabase($name, $email, $phone, $address, $service, $location, $date, $time, $package)) {
        echo "<script>alert('Database Error!'); window.history.back();</script>";
        exit;
    }

    // Send confirmation email to user and admin
    if (!sendBookingEmail($name, $email, $phone, $address, $service, $location, $date, $time, $package)) {
        echo "<script>alert('Email Error!'); window.history.back();</script>";
        exit;
    }

    // Success message and redirect
    echo "<script>alert('Booking successful! Confirmation sent.'); window.location.href='indexx.html';</script>";
    exit;
}

?>
