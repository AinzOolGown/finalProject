<?php
session_start(); // Start a new session
include 'database_login.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a statement for getting the user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct
		$_SESSION['user_email'] = $user['email'];
        header("Location: dashboard.html");
        exit;
    } else {
        // Handle error - wrong username/password
        echo "Invalid username or password!";
    }
}
?>
