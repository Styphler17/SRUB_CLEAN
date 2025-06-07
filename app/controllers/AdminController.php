<?php

namespace App\Controllers;

use App\Controllers\ThemeSettingsController;

class AdminController
{
    private $connexion;

    public function __construct($connexion)
    {
        $this->connexion = $connexion;
    }

    public function updateTheme()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/ThemeSettingsController.php';
            $themeSettingsController = new ThemeSettingsController($this->connexion);

            $colors = [
                'color_primary',
                'color_secondary',
                'color_accent',
                'color_neutral'
            ];

            foreach ($colors as $color) {
                if (isset($_POST[$color])) {
                    $themeSettingsController->updateSetting($color, $_POST[$color]);
                }
            }

            // Redirect back to theme settings page
            header('Location: ./index.php?page=admin&section=theme-settings');
            exit;
        }
    }
}
