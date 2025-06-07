<?php
session_start();
require_once '../app/config/params.php';
require_once 'includes/functions.php';
$pdo = $connexion;
require_once __DIR__ . '/../app/controllers/SettingsController.php';

use App\Controllers\SettingsController;

global $themeColors;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settingsController = new SettingsController($connexion);

    // Handle social media links as JSON
    if (isset($_POST['social-media-links'])) {
        $_POST['social-media-links'] = json_encode($_POST['social-media-links']);
    }

    // Update each setting
    foreach ($_POST as $key => $value) {
        $settingsController->updateSetting($key, $value);
    }

    // Redirect to prevent form resubmission
    header('Location: settings.php');
    exit;
}

$settingsController = new SettingsController($connexion);
$settings = $settingsController->getAllSettings();

$content = '
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">General Settings</h1>
            <button type="submit" form="settingsForm" class="px-6 py-3 bg-[var(--color-primary)] text-white rounded-lg hover:bg-[var(--color-primary)]/90 transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i>
                Save Changes
            </button>
        </div>

        <form id="settingsForm" action="settings.php" method="POST" class="space-y-6">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button type="button" onclick="showTab(\'branding\')" class="tab-button active border-[var(--color-primary)] text-[var(--color-primary)] whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-paint-brush mr-2"></i>Branding
                    </button>
                    <button type="button" onclick="showTab(\'content\')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-file-alt mr-2"></i>Content
                    </button>
                    <button type="button" onclick="showTab(\'social\')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-share-alt mr-2"></i>Social Media
                    </button>
                    <button type="button" onclick="showTab(\'legal\')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-gavel mr-2"></i>Legal
                    </button>
                </nav>
            </div>

            <!-- Branding Tab -->
            <div id="branding" class="tab-content space-y-6">
                <!-- Logo -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[var(--color-primary)]/10 flex items-center justify-center">
                            <i class="fas fa-image text-[var(--color-primary)]"></i>
                        </div>
                        <div>
                            <label class="block text-lg font-semibold">Logo</label>
                            <p class="text-sm text-gray-500">Your company logo</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="' . ($settings['cleanesta-logo'] ?? '../assets/images/logo/cleanesta-logo.png') . '" 
                             alt="Logo" 
                             class="w-20 h-20 object-contain">
                        <div class="flex-1">
                            <input type="text" 
                                   name="cleanesta-logo" 
                                   value="' . ($settings['cleanesta-logo'] ?? '../assets/images/logo/cleanesta-logo.png') . '" 
                                   class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-sm text-gray-600 mt-2">Path to your logo image</p>
                        </div>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[var(--color-primary)]/10 flex items-center justify-center">
                            <i class="fas fa-window-maximize text-[var(--color-primary)]"></i>
                        </div>
                        <div>
                            <label class="block text-lg font-semibold">Favicon</label>
                            <p class="text-sm text-gray-500">Browser tab icon</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="' . ($settings['favicon'] ?? '../assets/images/logo/cleanesta-logo.png') . '" 
                             alt="Favicon" 
                             class="w-8 h-8 object-contain">
                        <div class="flex-1">
                            <input type="text" 
                                   name="favicon" 
                                   value="' . ($settings['favicon'] ?? '../assets/images/logo/cleanesta-logo.png') . '" 
                                   class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-sm text-gray-600 mt-2">Path to your favicon image</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Tab -->
            <div id="content" class="tab-content hidden space-y-6">
                <!-- Description -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[var(--color-primary)]/10 flex items-center justify-center">
                            <i class="fas fa-align-left text-[var(--color-primary)]"></i>
                        </div>
                        <div>
                            <label class="block text-lg font-semibold">Site Description</label>
                            <p class="text-sm text-gray-500">Brief description of your service</p>
                        </div>
                    </div>
                    <textarea name="cleanesta-description" 
                              rows="3" 
                              class="w-full px-4 py-2 border rounded-lg">' . ($settings['cleanesta-description'] ?? '') . '</textarea>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div id="social" class="tab-content hidden space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[var(--color-primary)]/10 flex items-center justify-center">
                            <i class="fas fa-share-alt text-[var(--color-primary)]"></i>
                        </div>
                        <div>
                            <label class="block text-lg font-semibold">Social Media Links</label>
                            <p class="text-sm text-gray-500">Your social media profiles</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                            <div class="flex items-center gap-2">
                                <i class="fab fa-facebook text-blue-600"></i>
                                <input type="url" 
                                       name="social-media-links[facebook]" 
                                       value="' . (json_decode($settings['social-media-links'] ?? '{}', true)['facebook'] ?? '') . '" 
                                       class="flex-1 px-4 py-2 border rounded-lg"
                                       placeholder="https://facebook.com/your-page">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Twitter</label>
                            <div class="flex items-center gap-2">
                                <i class="fab fa-twitter text-blue-400"></i>
                                <input type="url" 
                                       name="social-media-links[twitter]" 
                                       value="' . (json_decode($settings['social-media-links'] ?? '{}', true)['twitter'] ?? '') . '" 
                                       class="flex-1 px-4 py-2 border rounded-lg"
                                       placeholder="https://twitter.com/your-handle">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                            <div class="flex items-center gap-2">
                                <i class="fab fa-instagram text-pink-600"></i>
                                <input type="url" 
                                       name="social-media-links[instagram]" 
                                       value="' . (json_decode($settings['social-media-links'] ?? '{}', true)['instagram'] ?? '') . '" 
                                       class="flex-1 px-4 py-2 border rounded-lg"
                                       placeholder="https://instagram.com/your-profile">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legal Tab -->
            <div id="legal" class="tab-content hidden space-y-6">
                <!-- Terms of Service -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[var(--color-primary)]/10 flex items-center justify-center">
                            <i class="fas fa-file-contract text-[var(--color-primary)]"></i>
                        </div>
                        <div>
                            <label class="block text-lg font-semibold">Terms of Service</label>
                            <p class="text-sm text-gray-500">Your terms and conditions</p>
                        </div>
                    </div>
                    <textarea name="terms-of-service" 
                              rows="5" 
                              class="w-full px-4 py-2 border rounded-lg">' . ($settings['terms-of-service'] ?? '') . '</textarea>
                </div>

                <!-- Privacy Policy -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[var(--color-primary)]/10 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-[var(--color-primary)]"></i>
                        </div>
                        <div>
                            <label class="block text-lg font-semibold">Privacy Policy</label>
                            <p class="text-sm text-gray-500">Your privacy policy</p>
                        </div>
                    </div>
                    <textarea name="privacy-policy" 
                              rows="5" 
                              class="w-full px-4 py-2 border rounded-lg">' . ($settings['privacy-policy'] ?? '') . '</textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll(".tab-content").forEach(content => {
        content.classList.add("hidden");
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll(".tab-button").forEach(button => {
        button.classList.remove("active", "border-[var(--color-primary)]", "text-[var(--color-primary)]");
        button.classList.add("border-transparent", "text-gray-500");
    });
    
    // Show selected tab content
    document.getElementById(tabId).classList.remove("hidden");
    
    // Add active class to selected tab button
    const activeButton = document.querySelector(`[onclick="showTab(\'${tabId}\')"]`);
    activeButton.classList.add("active", "border-[var(--color-primary)]", "text-[var(--color-primary)]");
    activeButton.classList.remove("border-transparent", "text-gray-500");
}
</script>';

// After general settings are updated
log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated general settings');

require_once 'layout.php';
