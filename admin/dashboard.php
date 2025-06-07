<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../app/config/params.php'; // This sets up $connexion
$pdo = $connexion;

global $themeColors;

// Fetch stats
$stats = [];
$tables = [
    'services' => 'Services',
    'reviews' => 'Reviews',
    'bookings' => 'Bookings',
    'service_areas' => 'Service Areas',
    'admins' => 'Admins'
];
foreach ($tables as $table => $label) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
    $stats[$label] = $stmt->fetchColumn();
}

// Dashboard content
ob_start();
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/admin/assets/css/custom-min.css">

<div class="mb-8">
    <div class="glass-bg-admin rounded-2xl shadow-2xl p-6 md:p-10 mb-6 flex flex-col gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-[var(--color-primary)] mb-2">Welcome, <?php echo $_SESSION['admin_username'] ?? 'Admin'; ?>!</h1>
            <p class="text-gray-600 text-base md:text-lg">Here are your site stats and recent activity.</p>
        </div>
        <div class="quick-actions-row">
            <a href="services.php" class="quick-action-btn"><i class="fas fa-broom"></i> Services</a>
            <a href="bookings.php" class="quick-action-btn"><i class="fas fa-calendar-check"></i> Bookings</a>
            <a href="reviews.php" class="quick-action-btn"><i class="fas fa-star"></i> Reviews</a>
            <a href="areas.php" class="quick-action-btn"><i class="fas fa-map-marker-alt"></i> Areas</a>
            <a href="admins.php" class="quick-action-btn"><i class="fas fa-user-shield"></i> Admins</a>
        </div>
    </div>
</div>
<!-- stats cards -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="rounded-xl shadow flex items-center gap-4 p-6 bg-white">
        <span class="flex items-center justify-center w-14 h-14 rounded-full bg-[var(--color-primary)] text-[var(--color-neutral)] text-2xl"><i class="fas fa-broom"></i></span>
        <div>
            <div class="text-3xl font-extrabold text-[var(--color-primary)]"><?php echo $stats['Services']; ?></div>
            <div class="text-gray-600 text-sm font-semibold">Services</div>
        </div>
    </div>
    <div class="rounded-xl shadow flex items-center gap-4 p-6 bg-white">
        <span class="flex items-center justify-center w-14 h-14 rounded-full bg-[var(--color-accent)] text-[var(--color-neutral)] text-2xl"><i class="fas fa-star"></i></span>
        <div>
            <div class="text-3xl font-extrabold text-[var(--color-accent)]"><?php echo $stats['Reviews']; ?></div>
            <div class="text-gray-600 text-sm font-semibold">Reviews</div>
        </div>
    </div>
    <div class="rounded-xl shadow flex items-center gap-4 p-6 bg-white">
        <span class="flex items-center justify-center w-14 h-14 rounded-full bg-[var(--color-accent)] text-[var(--color-neutral)] text-2xl"><i class="fas fa-calendar-check"></i></span>
        <div>
            <div class="text-3xl font-extrabold text-[var(--color-accent)]"><?php echo $stats['Bookings']; ?></div>
            <div class="text-gray-600 text-sm font-semibold">Bookings</div>
        </div>
    </div>
    <div class="rounded-xl shadow flex items-center gap-4 p-6 bg-white">
        <span class="flex items-center justify-center w-14 h-14 rounded-full bg-[var(--color-secondary)] text-[var(--color-neutral)] text-2xl"><i class="fas fa-map-marker-alt"></i></span>
        <div>
            <div class="text-3xl font-extrabold text-[var(--color-secondary)]"><?php echo $stats['Service Areas']; ?></div>
            <div class="text-gray-600 text-sm font-semibold">Service Areas</div>
        </div>
    </div>
    <div class="rounded-xl shadow flex items-center gap-4 p-6 bg-white">
        <span class="flex items-center justify-center w-14 h-14 rounded-full bg-[var(--color-primary)] text-[var(--color-neutral)] text-2xl"><i class="fas fa-user-shield"></i></span>
        <div>
            <div class="text-3xl font-extrabold text-[var(--color-primary)]"><?php echo $stats['Admins']; ?></div>
            <div class="text-gray-600 text-sm font-semibold">Admins</div>
        </div>
    </div>
</div>

<div class="mt-12">
    <h2 class="text-xl font-bold text-[var(--color-secondary)] mb-4">Recent Admin Activities</h2>
    <?php
    // Fetch recent admin activities (last 10)
    $activityStmt = $pdo->prepare("SELECT l.*, a.username FROM admin_activity_log l JOIN admins a ON l.admin_id = a.id ORDER BY l.created_at DESC LIMIT 10");
    $activityStmt->execute();
    $activities = $activityStmt->fetchAll();
    ?>
    <!-- Desktop Table -->
    <div class="overflow-x-auto w-full hidden sm:block">
        <table class="min-w-full bg-white rounded-xl shadow text-sm">
            <thead>
                <tr class="bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
                    <th class="px-2 sm:px-4 py-2 sm:py-2 text-left text-xs sm:text-sm">Admin</th>
                    <th class="px-2 sm:px-4 py-2 sm:py-2 text-left text-xs sm:text-sm">Action</th>
                    <th class="px-2 sm:px-4 py-2 sm:py-2 text-left text-xs sm:text-sm">Details</th>
                    <th class="px-2 sm:px-4 py-2 sm:py-2 text-left text-xs sm:text-sm">Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($activities): ?>
                    <?php foreach ($activities as $activity): ?>
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="px-2 sm:px-4 py-2 sm:py-2 font-semibold text-[var(--color-secondary)] break-all max-w-[120px] sm:max-w-none"><?php echo $activity['username']; ?></td>
                            <td class="px-2 sm:px-4 py-2 sm:py-2 break-all max-w-[120px] sm:max-w-none"><?php echo $activity['action']; ?></td>
                            <td class="px-2 sm:px-4 py-2 sm:py-2 text-gray-600 break-all max-w-[140px] sm:max-w-xs truncate" title="<?php echo $activity['details']; ?>"><?php echo $activity['details']; ?></td>
                            <td class="px-2 sm:px-4 py-2 sm:py-2 text-gray-500 whitespace-nowrap"><?php echo date('Y-m-d H:i', strtotime($activity['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-2 sm:px-4 py-6 text-center text-gray-400">No recent admin activities found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Mobile Card/List -->
    <div class="sm:hidden space-y-4">
        <?php if ($activities): ?>
            <?php foreach ($activities as $activity): ?>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border-l-4 border-[var(--color-accent)]">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-[var(--color-secondary)] text-base"><?php echo $activity['username']; ?></span>
                        <span class="text-xs text-gray-400 ml-auto"><?php echo date('M d, H:i', strtotime($activity['created_at'])); ?></span>
                    </div>
                    <div class="text-sm font-medium text-[var(--color-primary)]"><?php echo $activity['action']; ?></div>
                    <div class="text-xs text-gray-600 break-all"><?php echo $activity['details']; ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-gray-400 py-6 bg-white rounded-xl shadow">No recent admin activities found.</div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
