<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../app/config/params.php';
require_once 'includes/functions.php';
$pdo = $connexion;
global $themeColors;

// Fetch all business hours
$stmt = $pdo->query("SELECT * FROM business_hours ORDER BY id ASC");
$hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['day'] as $id => $day) {
        $open_time = $_POST['open_time'][$id] ?? null;
        $close_time = $_POST['close_time'][$id] ?? null;
        $is_closed = isset($_POST['is_closed'][$id]) ? 1 : 0;
        if ($is_closed) {
            $open_time = null;
            $close_time = null;
        }
        $stmt = $pdo->prepare("UPDATE business_hours SET open_time=?, close_time=?, is_closed=? WHERE id=?");
        $stmt->execute([$open_time, $close_time, $is_closed, $id]);
    }
    $success = 'Business hours updated successfully!';
    // Refresh
    $stmt = $pdo->query("SELECT * FROM business_hours ORDER BY id ASC");
    $hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // After business hours are updated
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated business hours');
}

ob_start();
?>
<div class="max-w-3xl mx-auto p-4 sm:p-8">
    <h1 class="text-2xl sm:text-3xl font-extrabold mb-6" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">Business Hours</h1>
    <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center font-semibold">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    <div class="overflow-x-auto rounded-xl shadow-lg bg-white border border-gray-100">
        <form method="post">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white">
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Day</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Open</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Close</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Closed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($hours as $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-semibold text-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>]">
                                <?php echo $row['day']; ?>
                                <input type="hidden" name="day[<?php echo $row['id']; ?>]" value="<?php echo $row['day']; ?>">
                            </td>
                            <td class="px-4 py-3">
                                <input type="time" name="open_time[<?php echo $row['id']; ?>]" value="<?php echo $row['open_time']; ?>" class="px-2 py-1 border rounded w-full focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:ring-2 focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-sm bg-white" <?php echo $row['is_closed'] ? 'disabled' : ''; ?>>
                            </td>
                            <td class="px-4 py-3">
                                <input type="time" name="close_time[<?php echo $row['id']; ?>]" value="<?php echo $row['close_time']; ?>" class="px-2 py-1 border rounded w-full focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:ring-2 focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-sm bg-white" <?php echo $row['is_closed'] ? 'disabled' : ''; ?>>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" name="is_closed[<?php echo $row['id']; ?>]" value="1" class="accent-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] w-5 h-5" <?php echo $row['is_closed'] ? 'checked' : ''; ?> onchange="toggleTimeInputs(this)">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="flex justify-end mt-6 px-4 pb-4">
                <button type="submit" class="bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white px-8 py-2 rounded-lg hover:bg-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>] transition font-bold text-base shadow">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleTimeInputs(checkbox) {
        const row = checkbox.closest('tr');
        if (!row) return;
        const timeInputs = row.querySelectorAll('input[type="time"]');
        timeInputs.forEach(input => input.disabled = checkbox.checked);
    }
    // On page load, ensure all time inputs are correctly enabled/disabled
    window.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[type="checkbox"][name^="is_closed"]').forEach(cb => {
            toggleTimeInputs(cb);
        });
    });
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
