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
    <title>Server Error</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, <?php echo $themeColors['neutral'] ?? '#f8fafc'; ?> 0%, #fff 100%);
            color: #333;
            text-align: center;
            padding: 50px;
        }

        .error-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px <?php echo $themeColors['primary'] ?? '#f34d26'; ?>22;
            display: inline-block;
            padding: 48px 72px;
            border: 2px solid <?php echo $themeColors['primary'] ?? '#f34d26'; ?>33;
        }

        h1 {
            color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .icon {
            font-size: 3rem;
            color: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="error-box">
        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h1>500 - Server Error</h1>
        <p>Sorry, something went wrong.<br>Please try again later.</p>
        <a href="index.php?page=home" style="display:inline-block;margin-top:2rem;padding:0.75rem 2rem;background:<?php echo $themeColors['primary'] ?? '#f34d26'; ?>;color:#fff;border-radius:9999px;text-decoration:none;font-weight:600;transition:background 0.2s;" onmouseover="this.style.background='<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>'" onmouseout="this.style.background='<?php echo $themeColors['primary'] ?? '#f34d26'; ?>'">
            <i class="fas fa-home mr-2"></i>Back to Home
        </a>
    </div>
</body>

</html>