<?php

namespace App\Controllers;

use PDO;

class ThemeSettingsController
{
    private $connexion;

    public function __construct($connexion)
    {
        $this->connexion = $connexion;
    }

    public function getAllSettings()
    {
        $settings = [];
        $query = "SELECT setting_key, setting_value FROM theme_settings";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }

    public function updateSetting($key, $value)
    {
        $query = "UPDATE theme_settings SET setting_value = :value WHERE setting_key = :key";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':key' => $key,
            ':value' => $value
        ]);
    }

    public function updateSettings($settings)
    {
        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->updateSetting($key, $value)) {
                $success = false;
            }
        }
        return $success;
    }

    public function getSetting($key)
    {
        $query = "SELECT setting_value FROM theme_settings WHERE setting_key = :key";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':key' => $key]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['setting_value'] : null;
    }
}
