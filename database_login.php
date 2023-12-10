<?php
$host = '127.0.0.1'; // or 'localhost'
$db   = 'login_database';
$user = 'root';
$pass = '';
$charset = 'utf8mb4'; // The character set you wish to use

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // highly recommended to enable the PDO exception mode
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->prepare("INSERT INTO users (username, email, password, usertype, buyer_seller_status) VALUES (?, ?, ?, ?, ?)");

?>
