<?php

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Application URL
define('BASE_URL', 'http://localhost/it34a');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'it34a');
define('DB_USER', 'root');
define('DB_PASS', '');

try {

    // Create PDO connection
    $pdo = new PDO(
        "mysql:host=" . DB_HOST .
        ";dbname=" . DB_NAME .
        ";charset=utf8mb4",

        DB_USER,
        DB_PASS,

        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());

}

// Load activity logger
require_once __DIR__ . '/../includes/activity-logger.php';

?>