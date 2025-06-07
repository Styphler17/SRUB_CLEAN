<?php
// Get theme colors
global $connexion;
require_once __DIR__ . '/../controllers/SettingsController.php';
$settingsController = new \App\Controllers\SettingsController($connexion);
$themeColors = $settingsController->getThemeColors();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Cleanesta Cleaning</title>
    <link href="css/dist/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, <?php echo $themeColors['neutral'] ?? '#f8fafc'; ?> 0%, #fff 100%);">
    <div class="container mx-auto px-4">
        <div class="text-center py-8">
            <div class="text-6xl mb-4" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">
                <i class="fas fa-broom animate-bounce"></i>
            </div>
            <div class="text-8xl font-bold mb-4 drop-shadow-md" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">404</div>
            <div class="text-2xl mb-4" style="color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;">Oops! Looks like this page needs a good cleaning.</div>
            <p class="mb-8 text-gray-500">The page you're looking for might have been moved, deleted, or never existed.</p>
            <a href="index.php?page=home" class="inline-block px-8 py-4 text-lg text-white rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300" style="background-color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</body>

</html>