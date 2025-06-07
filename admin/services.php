<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../app/config/params.php';
require_once 'includes/functions.php';
$pdo = $connexion;

// Handle Add Service
if (isset($_POST['add_service'])) {
    $stmt = $pdo->prepare("INSERT INTO services (name, description, base_price, duration_minutes, is_active, created_at, updated_at, image, price, duration, features, benefits, created_by_admin) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), '', 0.00, '', '[]', '[]', ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['description'],
        $_POST['base_price'],
        $_POST['duration_minutes'],
        isset($_POST['is_active']) ? 1 : 0,
        $_SESSION['admin_id']
    ]);
    $service_id = $pdo->lastInsertId();
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Created service', 'Service ID: ' . $service_id);
    header('Location: services.php');
    exit;
}
// Handle Edit Service
if (isset($_POST['edit_service'])) {
    $stmt = $pdo->prepare("UPDATE services SET name=?, description=?, base_price=?, duration_minutes=?, is_active=?, updated_at=NOW(), updated_by_admin=? WHERE id=?");
    $stmt->execute([
        $_POST['name'],
        $_POST['description'],
        $_POST['base_price'],
        $_POST['duration_minutes'],
        isset($_POST['is_active']) ? 1 : 0,
        $_SESSION['admin_id'],
        $_POST['id']
    ]);
    $service_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated service', 'Service ID: ' . $service_id);
    header('Location: services.php');
    exit;
}
// Handle Delete Service
if (isset($_POST['delete_service'])) {
    $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
    $stmt->execute([$_POST['id']]);
    $service_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Deleted service', 'Service ID: ' . $service_id);
    header('Location: services.php');
    exit;
}
// Fetch all services
$stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
global $themeColors;
?>
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-[var(--color-primary)]">Services</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">+ Add Service</button>
</div>
<!-- Desktop Table -->
<div class="overflow-x-auto rounded-lg hidden sm:block">
    <table class="min-w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-2 sm:px-4 py-3">ID</th>
                <th class="px-2 sm:px-4 py-3">Name</th>
                <th class="px-2 sm:px-4 py-3">Price</th>
                <th class="px-2 sm:px-4 py-3">Duration</th>
                <th class="px-2 sm:px-4 py-3">Status</th>
                <th class="px-2 sm:px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-2 sm:px-4 py-3"><?php echo $service['id']; ?></td>
                    <td class="px-2 sm:px-4 py-3 font-semibold"><?php echo $service['name']; ?></td>
                    <td class="px-2 sm:px-4 py-3">$<?php echo number_format($service['base_price'], 2); ?></td>
                    <td class="px-2 sm:px-4 py-3"><?php echo $service['duration_minutes']; ?> min</td>
                    <td class="px-2 sm:px-4 py-3">
                        <?php if ($service['is_active']): ?>
                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Active</span>
                        <?php else: ?>
                            <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-2 sm:px-4 py-3 space-x-2">
                        <button onclick="openEditModal(<?php echo $service['id']; ?>)" class="px-3 py-1 bg-[var(--color-secondary)] text-white rounded hover:bg-[var(--color-primary)] transition">Edit</button>
                        <form method="post" class="inline" onsubmit="return confirm('Delete this service?')">
                            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                            <button type="submit" name="delete_service" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Mobile Card View -->
<div class="sm:hidden space-y-4">
    <?php foreach ($services as $service): ?>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <span class="font-bold text-[var(--color-primary)]"><?php echo $service['name']; ?></span>
                <span class="text-xs <?php echo $service['is_active'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> px-2 py-1 rounded">
                    <?php echo $service['is_active'] ? 'Active' : 'Inactive'; ?>
                </span>
            </div>
            <div class="text-sm text-gray-700"><?php echo $service['description']; ?></div>
            <div class="flex justify-between text-xs text-gray-500">
                <span>Price: $<?php echo number_format($service['base_price'], 2); ?></span>
                <span>Duration: <?php echo $service['duration_minutes']; ?> min</span>
            </div>
            <div class="flex gap-2 mt-2">
                <button onclick="openEditModal(<?php echo $service['id']; ?>)" class="flex-1 px-3 py-2 bg-[var(--color-secondary)] text-white rounded">Edit</button>
                <form method="post" class="flex-1" onsubmit="return confirm('Delete this service?')">
                    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                    <button type="submit" name="delete_service" class="w-full px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- Add Service Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-4 sm:p-8 rounded-xl shadow-lg w-full max-w-lg relative mx-2">
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)] text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Add Service</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Base Price</label>
                <input type="number" step="0.01" name="base_price" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Duration (minutes)</label>
                <input type="number" name="duration_minutes" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="mr-2" checked>
                <label for="is_active" class="font-medium">Active</label>
            </div>
            <div class="flex flex-col sm:flex-row justify-end gap-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 w-full sm:w-auto">Cancel</button>
                <button type="submit" name="add_service" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">Add</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Service Modal (populated by JS) -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-4 sm:p-8 rounded-xl shadow-lg w-full max-w-lg relative mx-2">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)] text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Edit Service</h2>
        <form method="post" id="editForm">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="edit_name" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" id="edit_description" class="w-full px-4 py-2 border rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Base Price</label>
                <input type="number" step="0.01" name="base_price" id="edit_base_price" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Duration (minutes)</label>
                <input type="number" name="duration_minutes" id="edit_duration_minutes" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="edit_is_active" class="mr-2">
                <label for="edit_is_active" class="font-medium">Active</label>
            </div>
            <div class="flex flex-col sm:flex-row justify-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 w-full sm:w-auto">Cancel</button>
                <button type="submit" name="edit_service" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Populate and show edit modal
    function openEditModal(id) {
        var service = <?php echo json_encode($services); ?>.find(s => s.id == id);
        if (!service) return;
        document.getElementById('edit_id').value = service.id;
        document.getElementById('edit_name').value = service.name;
        document.getElementById('edit_description').value = service.description;
        document.getElementById('edit_base_price').value = service.base_price;
        document.getElementById('edit_duration_minutes').value = service.duration_minutes;
        document.getElementById('edit_is_active').checked = service.is_active == 1;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
