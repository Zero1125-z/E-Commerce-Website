<?php
try {
    $dsn = "mysql:host=localhost;dbname=shop";
    $username = "root";
    $password = ""; // XAMPP default for root is an empty string
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $conn = new PDO($dsn, $username, $password, $options);
    // echo "Connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
