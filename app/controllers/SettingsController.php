<?php

namespace App\Controllers;

use PDO;

class SettingsController
{
    private $connexion;

    public function __construct($connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * Get a specific setting by key
     */
    public function getSetting($key)
    {
        $query = "SELECT setting_value FROM settings WHERE setting_key = :key";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':key' => $key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['setting_value'] : null;
    }

    /**
     * Get all settings
     */
    public function getAllSettings()
    {
        $settings = [];
        $query = "SELECT setting_key, setting_value FROM settings";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }

    /**
     * Update a setting
     */
    public function updateSetting($key, $value)
    {
        $query = "UPDATE settings SET setting_value = :value WHERE setting_key = :key";
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

    /**
     * Get Terms of Service
     */
    public function getTermsOfService()
    {
        return $this->getSetting('terms-of-service');
    }

    /**
     * Get Privacy Policy
     */
    public function getPrivacyPolicy()
    {
        return $this->getSetting('privacy-policy');
    }

    /**
     * Get Logo
     */
    public function getLogo()
    {
        return $this->getSetting('cleanesta-logo');
    }

    /**
     * Get Favicon
     */
    public function getFavicon()
    {
        return $this->getSetting('favicon');
    }

    /**
     * Get Description
     */
    public function getDescription()
    {
        return $this->getSetting('cleanesta-description');
    }

    /**
     * Get Social Media Links
     */
    public function getSocialMediaLinks()
    {
        $links = $this->getSetting('social-media-links');
        return $links ? json_decode($links, true) : [];
    }

    /**
     * Get Theme Colors
     */
    public function getThemeColors()
    {
        $query = "SELECT setting_key, setting_value FROM theme_settings";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();

        $colors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Convert color_primary to primary, color_secondary to secondary, etc.
            $key = str_replace('color_', '', $row['setting_key']);
            $colors[$key] = $row['setting_value'];
        }

        return $colors;
    }
}
