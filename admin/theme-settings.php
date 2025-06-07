<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../app/config/params.php';
require_once 'includes/functions.php';
$pdo = $connexion;
require_once __DIR__ . '/../app/controllers/ThemeSettingsController.php';

use App\Controllers\ThemeSettingsController;

global $themeColors;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $themeSettingsController = new ThemeSettingsController($connexion);
    $colors = ['color_primary', 'color_secondary', 'color_accent', 'color_neutral', 'color_dark'];

    foreach ($colors as $color) {
        if (isset($_POST[$color])) {
            $themeSettingsController->updateSetting($color, $_POST[$color]);
        }
    }

    // Redirect to prevent form resubmission
    header('Location: theme-settings.php');
    exit;
}

$themeSettingsController = new ThemeSettingsController($connexion);
$settings = $themeSettingsController->getAllSettings();

$content = '
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">Theme Settings</h1>
            <button type="submit" form="themeForm" class="px-6 py-3 bg-[var(--color-primary)] text-white rounded-lg hover:bg-[var(--color-primary)]/90 transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i>
                Save Changes
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Color Settings -->
            <div class="space-y-6">
                <form id="themeForm" action="theme-settings.php" method="POST" class="space-y-6">
                    <!-- Primary Color -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg" id="primary-preview" style="background-color: ' . ($settings['color_primary'] ?? '#f34d26') . '"></div>
                            <div>
                                <label class="block text-lg font-semibold">Primary Color</label>
                                <p class="text-sm text-gray-500">Main brand color (SCRUB)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="color" 
                                   name="color_primary" 
                                   value="' . ($settings['color_primary'] ?? '#f34d26') . '" 
                                   class="w-12 h-12 rounded-lg cursor-pointer"
                                   onchange="updateColorPreview(this, \'primary-preview\')">
                            <input type="text" 
                                   value="' . ($settings['color_primary'] ?? '#f34d26') . '" 
                                   class="flex-1 px-4 py-2 border rounded-lg font-mono text-sm"
                                   onchange="updateColorInput(this, \'color_primary\')">
                        </div>
                    </div>

                    <!-- Secondary Color -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg" id="secondary-preview" style="background-color: ' . ($settings['color_secondary'] ?? '#00bda4') . '"></div>
                            <div>
                                <label class="block text-lg font-semibold">Secondary Color</label>
                                <p class="text-sm text-gray-500">Secondary brand color (CLEANING)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="color" 
                                   name="color_secondary" 
                                   value="' . ($settings['color_secondary'] ?? '#00bda4') . '" 
                                   class="w-12 h-12 rounded-lg cursor-pointer"
                                   onchange="updateColorPreview(this, \'secondary-preview\')">
                            <input type="text" 
                                   value="' . ($settings['color_secondary'] ?? '#00bda4') . '" 
                                   class="flex-1 px-4 py-2 border rounded-lg font-mono text-sm"
                                   onchange="updateColorInput(this, \'color_secondary\')">
                        </div>
                    </div>

                    <!-- Accent Color -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg" id="accent-preview" style="background-color: ' . ($settings['color_accent'] ?? '#7d2ea8') . '"></div>
                            <div>
                                <label class="block text-lg font-semibold">Accent Color</label>
                                <p class="text-sm text-gray-500">Highlights and special elements (Mop handle)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="color" 
                                   name="color_accent" 
                                   value="' . ($settings['color_accent'] ?? '#7d2ea8') . '" 
                                   class="w-12 h-12 rounded-lg cursor-pointer"
                                   onchange="updateColorPreview(this, \'accent-preview\')">
                            <input type="text" 
                                   value="' . ($settings['color_accent'] ?? '#7d2ea8') . '" 
                                   class="flex-1 px-4 py-2 border rounded-lg font-mono text-sm"
                                   onchange="updateColorInput(this, \'color_accent\')">
                        </div>
                    </div>

                    <!-- Neutral Color -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg border" id="neutral-preview" style="background-color: ' . ($settings['color_neutral'] ?? '#ffffff') . '"></div>
                            <div>
                                <label class="block text-lg font-semibold">Neutral Color</label>
                                <p class="text-sm text-gray-500">Background and subtle elements</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="color" 
                                   name="color_neutral" 
                                   value="' . ($settings['color_neutral'] ?? '#ffffff') . '" 
                                   class="w-12 h-12 rounded-lg cursor-pointer"
                                   onchange="updateColorPreview(this, \'neutral-preview\')">
                            <input type="text" 
                                   value="' . ($settings['color_neutral'] ?? '#ffffff') . '" 
                                   class="flex-1 px-4 py-2 border rounded-lg font-mono text-sm"
                                   onchange="updateColorInput(this, \'color_neutral\')">
                        </div>
                    </div>

                    <!-- Dark Color -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg" id="dark-preview" style="background-color: ' . ($settings['color_dark'] ?? '#1f1f1f') . '"></div>
                            <div>
                                <label class="block text-lg font-semibold">Dark Color</label>
                                <p class="text-sm text-gray-500">Text and shadows</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="color" 
                                   name="color_dark" 
                                   value="' . ($settings['color_dark'] ?? '#1f1f1f') . '" 
                                   class="w-12 h-12 rounded-lg cursor-pointer"
                                   onchange="updateColorPreview(this, \'dark-preview\')">
                            <input type="text" 
                                   value="' . ($settings['color_dark'] ?? '#1f1f1f') . '" 
                                   class="flex-1 px-4 py-2 border rounded-lg font-mono text-sm"
                                   onchange="updateColorInput(this, \'color_dark\')">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-semibold mb-6">Live Preview</h2>
                    
                    <!-- Header Preview -->
                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Header</h3>
                        <div class="h-16 rounded-lg flex items-center px-4" style="background-color: ' . ($settings['color_primary'] ?? '#f34d26') . '">
                            <div class="text-white font-bold text-xl">SCRUB</div>
                            <div class="ml-4 text-white/80 text-sm">CLEANING</div>
                        </div>
                    </div>

                    <!-- Button Preview -->
                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Buttons</h3>
                        <div class="flex flex-wrap gap-4">
                            <button class="px-4 py-2 rounded-lg text-white" style="background-color: ' . ($settings['color_primary'] ?? '#f34d26') . '">
                                Primary Button
                            </button>
                            <button class="px-4 py-2 rounded-lg text-white" style="background-color: ' . ($settings['color_secondary'] ?? '#00bda4') . '">
                                Secondary Button
                            </button>
                        </div>
                    </div>

                    <!-- Card Preview -->
                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Card</h3>
                        <div class="p-6 rounded-lg border" style="background-color: ' . ($settings['color_neutral'] ?? '#ffffff') . '; border-color: ' . ($settings['color_dark'] ?? '#1f1f1f') . '20">
                            <h4 class="text-lg font-semibold mb-2" style="color: ' . ($settings['color_dark'] ?? '#1f1f1f') . '">Card Title</h4>
                            <p class="text-sm" style="color: ' . ($settings['color_dark'] ?? '#1f1f1f') . '80">This is a sample card with the selected colors.</p>
                        </div>
                    </div>

                    <!-- Accent Elements -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Accent Elements</h3>
                        <div class="flex flex-wrap gap-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white" style="background-color: ' . ($settings['color_accent'] ?? '#7d2ea8') . '">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white" style="background-color: ' . ($settings['color_accent'] ?? '#7d2ea8') . '">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateColorPreview(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.style.backgroundColor = input.value;
    // Update the corresponding text input
    const textInput = input.parentElement.querySelector("input[type=\'text\']");
    textInput.value = input.value;
}

function updateColorInput(input, colorName) {
    // Update the corresponding color input
    const colorInput = input.parentElement.parentElement.querySelector("input[type=\'color\']");
    colorInput.value = input.value;
    // Update the preview
    const previewId = colorName.replace("color_", "") + "-preview";
    const preview = document.getElementById(previewId);
    preview.style.backgroundColor = input.value;
}
</script>';

// After theme settings are updated
log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated theme settings');

require_once 'layout.php';
