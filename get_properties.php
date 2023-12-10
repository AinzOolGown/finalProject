<?php
session_start();

include 'database_config.php'; // Your database connection file

$user_email = $_SESSION['user_email']; // Get the logged-in user's email

try {
    $stmt = $pdo->prepare("SELECT * FROM properties WHERE email = ?");
    $stmt->execute([$user_email]);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($properties);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

$pdo = null;
?>
