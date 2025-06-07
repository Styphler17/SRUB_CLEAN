<?php

// Initialisation des zones dynamiques
$content = "";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'u611723798_scrubhub_2025');
define('DB_USER', 'u611723798_scrubhub');
define('DB_PASS', 'Cle@n3stA9002');

// Application configuration
define('SITE_NAME', 'Cleanesta Services');
define('SITE_URL', '');
define('BASE_URL', '/');

// Error reporting (PRODUCTION: hide errors)
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// To debug, temporarily set display_errors and display_startup_errors to 1 and error_reporting(E_ALL);

global $connexion;
try {
    $connexion = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch (PDOException $e) {
    // In production, do not show the error details to the user
    // Optionally, log the error to a file:
    // error_log($e->getMessage(), 3, __DIR__ . '/pdo_errors.log');
    die('A database connection error occurred. Please try again later.');
}
