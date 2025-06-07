<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// PRODUCTION: Disable error reporting
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
// To debug, temporarily set the above to 1 and E_ALL

// Set the base path
define('BASE_PATH', dirname(__DIR__));

// Include the initialization file
require_once __DIR__ . '/core/init.php';

// If accessing the root directory, set the page to home
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/') {
    $_GET['page'] = 'home';
}

// Include the router
require_once __DIR__ . '/app/routers/index.php';

// Do NOT include the main template here unconditionally!

global $pdo;

global $themeColors;
require_once __DIR__ . '/app/controllers/SettingsController.php';
$settingsController = new \App\Controllers\SettingsController($connexion);
$themeColors = $settingsController->getThemeColors();
