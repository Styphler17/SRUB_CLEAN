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

// Handle Add Area
if (isset($_POST['add_area'])) {
    $stmt = $pdo->prepare("INSERT INTO service_areas (area_name, zip_code, is_active, created_at, updated_at, created_by_admin) VALUES (?, ?, ?, NOW(), NOW(), ?)");
    $stmt->execute([
        $_POST['area_name'],
        $_POST['zip_code'],
        isset($_POST['is_active']) ? 1 : 0,
        $_SESSION['admin_id']
    ]);
    $area_id = $pdo->lastInsertId();
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Created area', 'Area ID: ' . $area_id);
    header('Location: areas.php');
    exit;
}
// Handle Edit Area
if (isset($_POST['edit_area'])) {
    $stmt = $pdo->prepare("UPDATE service_areas SET area_name=?, zip_code=?, is_active=?, updated_at=NOW(), updated_by_admin=? WHERE id=?");
    $stmt->execute([
        $_POST['area_name'],
        $_POST['zip_code'],
        isset($_POST['is_active']) ? 1 : 0,
        $_SESSION['admin_id'],
        $_POST['id']
    ]);
    $area_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated area', 'Area ID: ' . $area_id);
    header('Location: areas.php');
    exit;
}
// Handle Delete Area
if (isset($_POST['delete_area'])) {
    $stmt = $pdo->prepare("DELETE FROM service_areas WHERE id=?");
    $stmt->execute([$_POST['id']]);
    $area_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Deleted area', 'Area ID: ' . $area_id);
    header('Location: areas.php');
    exit;
}
// Fetch all service areas
$stmt = $pdo->query("SELECT * FROM service_areas ORDER BY id DESC");
$areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-[var(--color-primary)]">Service Areas</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">+ Add Area</button>
</div>
<!-- Desktop Table -->
<div class="overflow-x-auto rounded-lg hidden sm:block">
    <table class="min-w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-3">ID</th>
                <th class="px-4 py-3">Area Name</th>
                <th class="px-4 py-3">ZIP Code</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3"><?php echo $area['id']; ?></td>
                    <td class="px-4 py-3 font-semibold"><?php echo $area['area_name']; ?></td>
                    <td class="px-4 py-3"><?php echo $area['zip_code']; ?></td>
                    <td class="px-4 py-3">
                        <?php if ($area['is_active']): ?>
                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Active</span>
                        <?php else: ?>
                            <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <button onclick="openEditModal(<?php echo $area['id']; ?>)" class="px-3 py-1 bg-secondary text-white rounded hover:bg-primary transition">Edit</button>
                        <form method="post" class="inline" onsubmit="return confirm('Delete this area?')">
                            <input type="hidden" name="id" value="<?php echo $area['id']; ?>">
                            <button type="submit" name="delete_area" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Mobile Card View -->
<div class="sm:hidden space-y-4">
    <?php foreach ($areas as $area): ?>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <span class="font-bold text-[var(--color-primary)]"><?php echo $area['area_name']; ?></span>
                <span class="text-xs <?php echo $area['is_active'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> px-2 py-1 rounded">
                    <?php echo $area['is_active'] ? 'Active' : 'Inactive'; ?>
                </span>
            </div>
            <div class="flex justify-between text-xs text-gray-500">
                <span>ZIP: <?php echo $area['zip_code']; ?></span>
                <span>ID: <?php echo $area['id']; ?></span>
            </div>
            <div class="flex gap-2 mt-2">
                <button onclick="openEditModal(<?php echo $area['id']; ?>)" class="flex-1 px-3 py-2 bg-secondary text-white rounded">Edit</button>
                <form method="post" class="flex-1" onsubmit="return confirm('Delete this area?')">
                    <input type="hidden" name="id" value="<?php echo $area['id']; ?>">
                    <button type="submit" name="delete_area" class="w-full px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- Add Area Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-primary">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Add Area</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Area Name</label>
                <input type="text" name="area_name" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">ZIP Code</label>
                <input type="text" name="zip_code" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="mr-2" checked>
                <label for="is_active" class="font-medium">Active</label>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="add_area" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Add</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Area Modal (populated by JS) -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-primary">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Edit Area</h2>
        <form method="post" id="editForm">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Area Name</label>
                <input type="text" name="area_name" id="edit_area_name" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">ZIP Code</label>
                <input type="text" name="zip_code" id="edit_zip_code" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="edit_is_active" class="mr-2">
                <label for="edit_is_active" class="font-medium">Active</label>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="edit_area" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Populate and show edit modal
    function openEditModal(id) {
        var area = <?php echo json_encode($areas); ?>.find(a => a.id == id);
        if (!area) return;
        document.getElementById('edit_id').value = area.id;
        document.getElementById('edit_area_name').value = area.area_name;
        document.getElementById('edit_zip_code').value = area.zip_code;
        document.getElementById('edit_is_active').checked = area.is_active == 1;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
