<?php

function saveBookingToDatabase($name, $email, $phone, $address, $service, $location, $date, $time, $package) {
    // ✅ Database Connection
    $servername = "localhost";
    $username   = "booking";
    $password   = "";  // Empty password
    $dbname     = "vaman_db";

    $conn = new mysqli("localhost", "root", "", "vaman_db")
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, address, service, location, date, time, package) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $email, $phone, $address, $service, $location, $date, $time, $package);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true; // Return true if data is inserted successfully
    } else {
        $stmt->close();
        $conn->close();
        return false; // Return false if there's an error in insertion
    }
}
?>
