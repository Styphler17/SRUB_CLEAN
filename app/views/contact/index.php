<?php
// This file is intentionally left empty. The ContactController fetches data from the models and renders the contact component, passing all required variables.

// Fetch data if not already set (fallback, not recommended if using controller)
if (!isset($contactInfo) || !isset($businessHours)) {
    $contactModel = new \App\Models\ContactInfo();
    $contactInfo = $contactModel->getInfo();
    $hoursModel = new \App\Models\BusinessHours();
    $businessHours = $hoursModel->getAll();
}
include __DIR__ . '/../components/_contact.php';
