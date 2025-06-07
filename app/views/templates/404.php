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
    <title>404 - Page Not Found | <?= SITE_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body style="background: linear-gradient(135deg, <?php echo $themeColors['neutral'] ?? '#f8fafc'; ?> 0%, #fff 100%);">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl font-bold mb-4" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">404</h1>
            <p class="text-xl mb-8" style="color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;">Page Not Found</p>
            <a href="<?= SITE_URL ?>" class="px-6 py-2 rounded-full transition-colors" style="background: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>; color: #fff; font-weight: 600;" onmouseover="this.style.background='<?php echo $themeColors['primary'] ?? '#f34d26'; ?>'" onmouseout="this.style.background='<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>'">
                Go Back Home
            </a>
        </div>
    </div>
</body>

</html>