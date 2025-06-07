<?php
require_once __DIR__ . '/../config/params.php';
require_once __DIR__ . '/../controllers/SettingsController.php';

use App\Controllers\SettingsController;

$settingsController = new SettingsController($connexion);
$settings = $settingsController->getAllSettings();
$themeColors = $settingsController->getThemeColors();

$content = '
<div class="min-h-screen w-full flex items-center justify-center" style="background: linear-gradient(135deg, ' . ($themeColors['neutral'] ?? '#f8fafc') . ' 0%, #fff 100%);">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8" style="color: ' . ($themeColors['primary'] ?? '#f34d26') . ';">Privacy Policy</h1>
            <div class="prose max-w-none">
                ' . ($settings['privacy-policy'] ?? 'No privacy policy available.') . '
            </div>
        </div>
    </div>
</div>';

require_once __DIR__ . '/templates/index.php';
