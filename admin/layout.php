<?php
require_once __DIR__ . '/../app/controllers/SettingsController.php';
global $themeColors, $connexion;
$settingsController = new \App\Controllers\SettingsController($connexion);
$themeColors = $settingsController->getThemeColors();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- favicon  -->
    <link rel="icon" href="/assets/images/logo/cleanesta-logo.png" type="image/png">
    <?php include 'includes/theme.php'; ?>

    <style>
        :root {
            --color-primary: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;
            --color-secondary: <?php echo $themeColors['secondary'] ?? '#00bda4'; ?>;
            --color-accent: <?php echo $themeColors['accent'] ?? '#7d2ea8'; ?>;
            --color-neutral: <?php echo $themeColors['neutral'] ?? '#ffffff'; ?>;
            --color-dark: <?php echo $themeColors['dark'] ?? '#1f1f1f'; ?>;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--color-primary, #f34d26)',
                        secondary: 'var(--color-secondary, #00bda4)',
                        accent: 'var(--color-accent, #7d2ea8)',
                        neutral: 'var(--color-neutral, #ffffff)',
                        dark: 'var(--color-dark, #1f1f1f)',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white border-r border-gray-200 w-60 flex-shrink-0 flex flex-col transition-all duration-300 z-30 fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 md:relative" style="min-width:15rem;">
            <div class="flex items-center justify-center px-4 py-6 border-b">
                <span class="font-extrabold text-2xl text-primary tracking-wide">Admin Panel</span>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1">
                <?php
                $current_page = basename($_SERVER['PHP_SELF']);
                $nav_items = [
                    'dashboard.php' => ['icon' => 'chart-line', 'text' => 'Dashboard'],
                    'services.php' => ['icon' => 'broom', 'text' => 'Services'],
                    'reviews.php' => ['icon' => 'star', 'text' => 'Reviews'],
                    'areas.php' => ['icon' => 'map-marker-alt', 'text' => 'Service Areas'],
                    'bookings.php' => ['icon' => 'calendar-check', 'text' => 'Bookings'],
                    'admins.php' => ['icon' => 'users', 'text' => 'Admins'],
                    'staff.php' => ['icon' => 'user-clock', 'text' => 'Staff'],
                    'contact.php' => ['icon' => 'address-book', 'text' => 'Contact'],
                    'business_hours.php' => ['icon' => 'clock', 'text' => 'Business Hours'],
                    'settings.php' => ['icon' => 'cog', 'text' => 'Settings'],
                    'theme-settings.php' => ['icon' => 'palette', 'text' => 'Theme', 'link' => 'theme-settings.php']
                ];

                foreach ($nav_items as $page => $item) {
                    $is_active = $current_page === $page;
                    $active_class = $is_active ? 'bg-primary text-white' : 'text-gray-700 hover:bg-primary hover:text-white';
                    $link = $item['link'] ?? $page;
                    echo '<a href="' . $link . '" class="flex items-center px-4 py-2 rounded-lg transition ' . $active_class . '">
                            <i class="fas fa-' . $item['icon'] . ' mr-3"></i> ' . $item['text'] . '
                          </a>';
                }
                ?>
            </nav>
            <div class="mt-auto px-4 py-4">
                <a href="logout.php" class="flex items-center justify-center px-4 py-2 rounded bg-red-500 text-white text-center hover:bg-red-600 transition w-full">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </a>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-40 z-20 hidden md:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <?php include 'includes/header.php'; ?>
            <!-- Main Content Area -->
            <main class="flex-1 p-6 overflow-y-auto">
                <?php if (isset($content)) {
                    echo $content;
                } ?>
            </main>
        </div>
    </div>
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarOpen = document.getElementById('sidebarOpen');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarOpen) {
            sidebarOpen.onclick = () => {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            };
        }
        if (sidebarClose) {
            sidebarClose.onclick = () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            };
        }
        if (sidebarOverlay) {
            sidebarOverlay.onclick = () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            };
        }
        // Profile dropdown
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileBtn && profileDropdown) {
            profileBtn.onclick = (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            };
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>