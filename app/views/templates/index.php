<?php
// Load theme colors globally for all components
require_once __DIR__ . '/../../controllers/SettingsController.php';
require_once __DIR__ . '/../../models/ContactInfo.php';
global $themeColors, $connexion;
$settingsController = new \App\Controllers\SettingsController($connexion);
$themeColors = $settingsController->getThemeColors();
$contactModel = new \App\Models\ContactInfo($connexion);
$contactInfo = $contactModel->getInfo();
?>
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <?php include_once __DIR__ . '/partials/_head.php'; ?>
</head>

<body class="relative min-h-screen flex flex-col bg-gradient-to-br from-[var(--color-neutral)] via-gray-50 to-[var(--color-secondary)]/10 overflow-x-hidden">
    <!-- Animated background shapes -->
    <div class="pointer-events-none select-none fixed top-0 left-0 w-full h-full z-0">
        <!-- Primary color shape -->
        <div class="absolute top-[-80px] left-[-80px] w-96 h-96 bg-[var(--color-primary)] opacity-10 rounded-full blur-3xl animate-float-slow"></div>
        <!-- Secondary color shape -->
        <div class="absolute bottom-[-100px] right-[-100px] w-[28rem] h-[28rem] bg-[var(--color-secondary)] opacity-10 rounded-full blur-3xl animate-float-slow-delayed"></div>
        <!-- Accent color shape -->
        <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-[var(--color-accent)] opacity-5 rounded-full blur-2xl animate-pulse"></div>
        <!-- Additional floating elements -->
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-[var(--color-primary)] opacity-5 rounded-full blur-2xl animate-float-medium"></div>
        <div class="absolute bottom-1/3 left-1/3 w-80 h-80 bg-[var(--color-secondary)] opacity-5 rounded-full blur-2xl animate-float-medium-delayed"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <?php include_once __DIR__ . '/partials/_header.php'; ?>

        <?php include_once __DIR__ . '/partials/_main.php'; ?>

        <?php include_once __DIR__ . '/partials/_footer.php'; ?>
    </div>

    <!-- Custom JS -->
    <style>
        @keyframes float-slow {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.1;
            }

            25% {
                transform: translate(20px, -20px) scale(1.05);
                opacity: 0.15;
            }

            50% {
                transform: translate(0, -40px) scale(1.1);
                opacity: 0.2;
            }

            75% {
                transform: translate(-20px, -20px) scale(1.05);
                opacity: 0.15;
            }
        }

        @keyframes float-medium {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.05;
            }

            50% {
                transform: translate(30px, 30px) scale(1.08);
                opacity: 0.08;
            }
        }

        .animate-float-slow {
            animation: float-slow 15s ease-in-out infinite;
        }

        .animate-float-slow-delayed {
            animation: float-slow 15s ease-in-out 5s infinite;
        }

        .animate-float-medium {
            animation: float-medium 12s ease-in-out infinite;
        }

        .animate-float-medium-delayed {
            animation: float-medium 12s ease-in-out 6s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.05;
                transform: scale(1);
            }

            50% {
                opacity: 0.08;
                transform: scale(1.05);
            }
        }

        .animate-pulse {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</body>

</html>