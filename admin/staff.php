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

// Handle Add Staff Availability
if (isset($_POST['add_staff'])) {
    $stmt = $pdo->prepare("INSERT INTO staff_availability (day_of_week, start_time, end_time, is_available, created_at, updated_at, created_by_admin) VALUES (?, ?, ?, ?, NOW(), NOW(), ?)");
    $stmt->execute([
        $_POST['day_of_week'],
        $_POST['start_time'],
        $_POST['end_time'],
        isset($_POST['is_available']) ? 1 : 0,
        $_SESSION['admin_id']
    ]);
    $staff_id = $pdo->lastInsertId();
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Created staff', 'Staff ID: ' . $staff_id);
    header('Location: staff.php');
    exit;
}
// Handle Edit Staff Availability
if (isset($_POST['edit_staff'])) {
    $stmt = $pdo->prepare("UPDATE staff_availability SET day_of_week=?, start_time=?, end_time=?, is_available=?, updated_at=NOW(), updated_by_admin=? WHERE id=?");
    $stmt->execute([
        $_POST['day_of_week'],
        $_POST['start_time'],
        $_POST['end_time'],
        isset($_POST['is_available']) ? 1 : 0,
        $_SESSION['admin_id'],
        $_POST['id']
    ]);
    $staff_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated staff', 'Staff ID: ' . $staff_id);
    header('Location: staff.php');
    exit;
}
// Handle Delete Staff Availability
if (isset($_POST['delete_staff'])) {
    $stmt = $pdo->prepare("DELETE FROM staff_availability WHERE id=?");
    $stmt->execute([$_POST['id']]);
    $staff_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Deleted staff', 'Staff ID: ' . $staff_id);
    header('Location: staff.php');
    exit;
}
// Fetch all staff availability
$stmt = $pdo->query("SELECT * FROM staff_availability ORDER BY id DESC");
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sort staff by day of week
function getDayOrder($day)
{
    $order = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
    return $order[$day] ?? 8;
}
usort($staff, function ($a, $b) {
    return getDayOrder($a['day_of_week']) - getDayOrder($b['day_of_week']);
});

// Filter staff by day if a filter is set
$filter_day = isset($_GET['filter_day']) ? $_GET['filter_day'] : '';
if ($filter_day) {
    $staff = array_filter($staff, function ($s) use ($filter_day) {
        return $s['day_of_week'] === $filter_day;
    });
}

// Function to get background color class based on day
function getDayColorClass($day)
{
    $colors = [
        'Monday' => 'bg-blue-50',
        'Tuesday' => 'bg-green-50',
        'Wednesday' => 'bg-yellow-50',
        'Thursday' => 'bg-purple-50',
        'Friday' => 'bg-pink-50',
        'Saturday' => 'bg-orange-50',
        'Sunday' => 'bg-red-50'
    ];
    return $colors[$day] ?? 'bg-white';
}

ob_start();
?>
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-[var(--color-primary)]">Staff Availability</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">+ Add Staff</button>
</div>

<!-- Filter Dropdown -->
<div class="mb-4">
    <form method="get" class="flex items-center gap-2">
        <label for="filter_day" class="font-medium">Filter by Day:</label>
        <select name="filter_day" id="filter_day" class="px-4 py-2 border rounded" onchange="this.form.submit()">
            <option value="">All Days</option>
            <option value="Monday" <?php echo $filter_day === 'Monday' ? 'selected' : ''; ?>>Monday</option>
            <option value="Tuesday" <?php echo $filter_day === 'Tuesday' ? 'selected' : ''; ?>>Tuesday</option>
            <option value="Wednesday" <?php echo $filter_day === 'Wednesday' ? 'selected' : ''; ?>>Wednesday</option>
            <option value="Thursday" <?php echo $filter_day === 'Thursday' ? 'selected' : ''; ?>>Thursday</option>
            <option value="Friday" <?php echo $filter_day === 'Friday' ? 'selected' : ''; ?>>Friday</option>
            <option value="Saturday" <?php echo $filter_day === 'Saturday' ? 'selected' : ''; ?>>Saturday</option>
            <option value="Sunday" <?php echo $filter_day === 'Sunday' ? 'selected' : ''; ?>>Sunday</option>
        </select>
    </form>
</div>

<!-- Desktop Table -->
<div class="overflow-x-auto rounded-lg hidden sm:block">
    <table class="min-w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-3">ID</th>
                <th class="px-4 py-3">Day</th>
                <th class="px-4 py-3">Start Time</th>
                <th class="px-4 py-3">End Time</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staff as $s): ?>
                <tr class="border-b hover:bg-gray-50 <?php echo getDayColorClass($s['day_of_week']); ?>">
                    <td class="px-4 py-3"><?php echo $s['id']; ?></td>
                    <td class="px-4 py-3 font-semibold"><?php echo $s['day_of_week']; ?></td>
                    <td class="px-4 py-3"><?php echo $s['start_time']; ?></td>
                    <td class="px-4 py-3"><?php echo $s['end_time']; ?></td>
                    <td class="px-4 py-3">
                        <?php if ($s['is_available']): ?>
                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Available</span>
                        <?php else: ?>
                            <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Unavailable</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <button onclick="openEditModal(<?php echo $s['id']; ?>)" class="px-3 py-1 bg-secondary text-white rounded hover:bg-primary transition">Edit</button>
                        <form method="post" class="inline" onsubmit="return confirm('Delete this staff availability?')">
                            <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                            <button type="submit" name="delete_staff" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="sm:hidden space-y-4">
    <?php foreach ($staff as $s): ?>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2 <?php echo getDayColorClass($s['day_of_week']); ?>">
            <div class="flex justify-between items-center">
                <span class="font-bold text-[var(--color-primary)]"><?php echo $s['day_of_week']; ?></span>
                <span class="text-xs <?php echo $s['is_available'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> px-2 py-1 rounded">
                    <?php echo $s['is_available'] ? 'Available' : 'Unavailable'; ?>
                </span>
            </div>
            <div class="flex justify-between text-xs text-gray-500">
                <span>Start: <?php echo $s['start_time']; ?></span>
                <span>End: <?php echo $s['end_time']; ?></span>
            </div>
            <div class="flex gap-2 mt-2">
                <button onclick="openEditModal(<?php echo $s['id']; ?>)" class="flex-1 px-3 py-2 bg-secondary text-white rounded">Edit</button>
                <form method="post" class="flex-1" onsubmit="return confirm('Delete this staff availability?')">
                    <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                    <button type="submit" name="delete_staff" class="w-full px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Add Staff Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Add Staff Availability</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Day of Week</label>
                <select name="day_of_week" class="w-full px-4 py-2 border rounded" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Start Time</label>
                <input type="time" name="start_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">End Time</label>
                <input type="time" name="end_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_available" id="is_available" class="mr-2" checked>
                <label for="is_available" class="font-medium">Available</label>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="add_staff" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Staff Modal (populated by JS) -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Edit Staff Availability</h2>
        <form method="post" id="editForm">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Day of Week</label>
                <select name="day_of_week" id="edit_day_of_week" class="w-full px-4 py-2 border rounded" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Start Time</label>
                <input type="time" name="start_time" id="edit_start_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">End Time</label>
                <input type="time" name="end_time" id="edit_end_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_available" id="edit_is_available" class="mr-2">
                <label for="edit_is_available" class="font-medium">Available</label>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="edit_staff" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Populate and show edit modal
    function openEditModal(id) {
        var staff = <?php echo json_encode($staff); ?>.find(s => s.id == id);
        if (!staff) return;
        document.getElementById('edit_id').value = staff.id;
        document.getElementById('edit_day_of_week').value = staff.day_of_week;
        document.getElementById('edit_start_time').value = staff.start_time;
        document.getElementById('edit_end_time').value = staff.end_time;
        document.getElementById('edit_is_available').checked = staff.is_available == 1;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
