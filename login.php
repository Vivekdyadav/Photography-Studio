<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vaman_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['email'] = $email;

            // Redirect to book.html
            header("Location: book.html");
            exit;
        } else {
            echo "<h3 style='color:red;'>❌ Incorrect password</h3>";
        }
    } else {
        echo "<h3 style='color:red;'>❌ Email not found</h3>";
    }
}
?>

<!-- Simple Login Form -->
<form method="POST" action="login.php">
    <input type="email" name="email" required placeholder="Email"><br><br>
    <input type="password" name="password" required placeholder="Password"><br><br>
    <button type="submit">Login</button>
</form>
