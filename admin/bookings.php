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

// Handle Add Booking
if (isset($_POST['add_booking'])) {
    $stmt = $pdo->prepare("INSERT INTO bookings (service_id, booking_date, start_time, end_time, status, total_price, special_instructions, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([
        $_POST['service_id'],
        $_POST['booking_date'],
        $_POST['start_time'] ?? '00:00:00',
        $_POST['end_time'] ?? '00:00:00',
        $_POST['status'],
        $_POST['total_price'] ?? 0.00,
        $_POST['special_instructions'] ?? null
    ]);
    $booking_id = $pdo->lastInsertId();
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Created booking', 'Booking ID: ' . $booking_id);
    header('Location: bookings.php');
    exit;
}
// Handle Edit Booking
if (isset($_POST['edit_booking'])) {
    $stmt = $pdo->prepare("UPDATE bookings SET service_id=?, booking_date=?, start_time=?, end_time=?, status=?, total_price=?, special_instructions=?, updated_at=NOW() WHERE id=?");
    $stmt->execute([
        $_POST['service_id'],
        $_POST['booking_date'],
        $_POST['start_time'] ?? '00:00:00',
        $_POST['end_time'] ?? '00:00:00',
        $_POST['status'],
        $_POST['total_price'] ?? 0.00,
        $_POST['special_instructions'] ?? null,
        $_POST['id']
    ]);
    $booking_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated booking', 'Booking ID: ' . $booking_id);
    header('Location: bookings.php');
    exit;
}
// Handle Delete Booking
if (isset($_POST['delete_booking'])) {
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id=?");
    $stmt->execute([$_POST['id']]);
    $booking_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Deleted booking', 'Booking ID: ' . $booking_id);
    header('Location: bookings.php');
    exit;
}
// Fetch all bookings
$stmt = $pdo->query("SELECT * FROM bookings ORDER BY id DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-[var(--color-primary)]">Bookings</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">+ Add Booking</button>
</div>
<!-- Desktop Table -->
<div class="overflow-x-auto rounded-lg hidden sm:block">
    <table class="min-w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-3">ID</th>
                <th class="px-4 py-3">Service</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Start Time</th>
                <th class="px-4 py-3">End Time</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3"><?php echo $booking['id']; ?></td>
                    <td class="px-4 py-3 font-semibold"><?php echo $booking['service_id']; ?></td>
                    <td class="px-4 py-3"><?php echo $booking['booking_date']; ?></td>
                    <td class="px-4 py-3"><?php echo $booking['start_time']; ?></td>
                    <td class="px-4 py-3"><?php echo $booking['end_time']; ?></td>
                    <td class="px-4 py-3">$<?php echo number_format($booking['total_price'], 2); ?></td>
                    <td class="px-4 py-3">
                        <?php if ($booking['status'] == 'confirmed'): ?>
                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Confirmed</span>
                        <?php elseif ($booking['status'] == 'pending'): ?>
                            <span class="inline-block px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Pending</span>
                        <?php elseif ($booking['status'] == 'completed'): ?>
                            <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Completed</span>
                        <?php else: ?>
                            <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Cancelled</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <button onclick="openEditModal(<?php echo $booking['id']; ?>)" class="px-3 py-1 bg-secondary text-white rounded hover:bg-primary transition">Edit</button>
                        <form method="post" class="inline" onsubmit="return confirm('Delete this booking?')">
                            <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" name="delete_booking" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Mobile Card View -->
<div class="sm:hidden space-y-4">
    <?php foreach ($bookings as $booking): ?>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <span class="font-bold text-[var(--color-primary)]">Booking #<?php echo $booking['id']; ?></span>
                <span class="text-xs <?php
                                        if ($booking['status'] == 'confirmed') echo 'bg-green-100 text-green-700';
                                        elseif ($booking['status'] == 'pending') echo 'bg-yellow-100 text-yellow-700';
                                        elseif ($booking['status'] == 'completed') echo 'bg-blue-100 text-blue-700';
                                        else echo 'bg-red-100 text-red-700';
                                        ?> px-2 py-1 rounded">
                    <?php echo ucfirst($booking['status']); ?>
                </span>
            </div>
            <div class="flex justify-between text-xs text-gray-500">
                <span>Service: <?php echo $booking['service_id']; ?></span>
                <span>$<?php echo number_format($booking['total_price'], 2); ?></span>
            </div>
            <div class="text-xs text-gray-500">
                <?php echo $booking['booking_date']; ?> | <?php echo $booking['start_time']; ?> - <?php echo $booking['end_time']; ?>
            </div>
            <?php if ($booking['special_instructions']): ?>
                <div class="text-xs text-gray-500 italic">
                    Note: <?php echo $booking['special_instructions']; ?>
                </div>
            <?php endif; ?>
            <div class="flex gap-2 mt-2">
                <button onclick="openEditModal(<?php echo $booking['id']; ?>)" class="flex-1 px-3 py-2 bg-secondary text-white rounded">Edit</button>
                <form method="post" class="flex-1" onsubmit="return confirm('Delete this booking?')">
                    <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                    <button type="submit" name="delete_booking" class="w-full px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- Add Booking Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Add Booking</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Service</label>
                <input type="text" name="service_id" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Date</label>
                <input type="date" name="booking_date" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Start Time</label>
                <input type="time" name="start_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">End Time</label>
                <input type="time" name="end_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Total Price</label>
                <input type="number" step="0.01" name="total_price" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Special Instructions</label>
                <textarea name="special_instructions" class="w-full px-4 py-2 border rounded" rows="3"></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="add_booking" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Add</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Booking Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Edit Booking</h2>
        <form method="post" id="editForm">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Service</label>
                <input type="text" name="service_id" id="edit_service_id" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Date</label>
                <input type="date" name="booking_date" id="edit_booking_date" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Start Time</label>
                <input type="time" name="start_time" id="edit_start_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">End Time</label>
                <input type="time" name="end_time" id="edit_end_time" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Total Price</label>
                <input type="number" step="0.01" name="total_price" id="edit_total_price" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Special Instructions</label>
                <textarea name="special_instructions" id="edit_special_instructions" class="w-full px-4 py-2 border rounded" rows="3"></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Status</label>
                <select name="status" id="edit_status" class="w-full px-4 py-2 border rounded" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="edit_booking" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Populate and show edit modal
    function openEditModal(id) {
        var booking = <?php echo json_encode($bookings); ?>.find(b => b.id == id);
        if (!booking) return;
        document.getElementById('edit_id').value = booking.id;
        document.getElementById('edit_service_id').value = booking.service_id;
        document.getElementById('edit_booking_date').value = booking.booking_date;
        document.getElementById('edit_start_time').value = booking.start_time;
        document.getElementById('edit_end_time').value = booking.end_time;
        document.getElementById('edit_total_price').value = booking.total_price;
        document.getElementById('edit_special_instructions').value = booking.special_instructions;
        document.getElementById('edit_status').value = booking.status;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
