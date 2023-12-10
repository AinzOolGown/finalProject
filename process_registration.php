<?php
include 'database_login.php'; // Include your database connection script

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and validate/sanitize form data
    $username = $_POST['username'];
    $email = $_POST['email-address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $user_type = $_POST['user-type']; // Assuming this is part of your form
    $buyer_seller_status = 'buyer'; // Set this based on your form or logic

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        // Handle error
        echo "Passwords do not match!";
        exit;
    }

    // Further validation and sanitation can be added here

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use the prepared statement from database_login.php to insert the data
	$stmt->execute([$username, $email, $hashed_password, $user_type, $buyer_seller_status]);
	header('Location: login.html');
	exit;
}
?>
