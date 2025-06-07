<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/params.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/ThemeSettingsController.php';

use App\Controllers\ThemeSettingsController;

$settings = [];
try {
    if (isset($connexion)) {
        $themeSettingsController = new ThemeSettingsController($connexion);
        $settings = $themeSettingsController->getAllSettings();
    }
} catch (Exception $e) {
    // If there's an error, use default colors
    $settings = [
        'color_primary' => '#f34d26',
        'color_secondary' => '#00bda4',
        'color_accent' => '#7d2ea8',
        'color_neutral' => '#ffffff',
        'color_dark' => '#1f1f1f'
    ];
}

global $themeColors;
?>
<style>
    :root {
        --color-primary: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;
        /* Vibrant Orange-Red (SCRUB) */
        --color-secondary: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;
        /* Teal-Turquoise (CLEANING) */
        --color-accent: <?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>;
        /* Deep Purple (Mop handle) */
        --color-neutral: <?php echo $themeColors['neutral'] ?? '#ffffff'; ?>;
        /* White (Background) */
        --color-dark: <?php echo $themeColors['dark'] ?? '#1f1f1f'; ?>;
        /* Dark for text or shadow */
    }
</style> 