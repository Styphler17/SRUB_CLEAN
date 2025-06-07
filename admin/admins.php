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

// Handle Add Admin
if (isset($_POST['add_admin'])) {
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/admins/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['picture']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)) {
            $picture = $targetPath;
        }
    }
    
    $stmt = $pdo->prepare("INSERT INTO admins (username, email, password, role, picture, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([
        $_POST['username'],
        $_POST['email'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $_POST['role'],
        $picture
    ]);
    $admin_id = $pdo->lastInsertId();
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Created admin', 'Admin ID: ' . $admin_id);
    header('Location: admins.php');
    exit;
}
// Handle Edit Admin
if (isset($_POST['edit_admin'])) {
    $picture = $_POST['current_picture'] ?? null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/admins/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['picture']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)) {
            // Delete old picture if exists
            if ($picture && file_exists($picture)) {
                unlink($picture);
            }
            $picture = $targetPath;
        }
    }
    
    $stmt = $pdo->prepare("UPDATE admins SET username=?, email=?, role=?, picture=?, updated_at=NOW() WHERE id=?");
    $stmt->execute([
        $_POST['username'],
        $_POST['email'],
        $_POST['role'],
        $picture,
        $_POST['id']
    ]);
    $admin_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated admin', 'Admin ID: ' . $admin_id);
    header('Location: admins.php');
    exit;
}
// Handle Delete Admin
if (isset($_POST['delete_admin'])) {
    $stmt = $pdo->prepare("DELETE FROM admins WHERE id=?");
    $stmt->execute([$_POST['id']]);
    $admin_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Deleted admin', 'Admin ID: ' . $admin_id);
    header('Location: admins.php');
    exit;
}
// Fetch all admins
$stmt = $pdo->query("SELECT * FROM admins ORDER BY id DESC");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-[var(--color-primary)]">Admins</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">+ Add Admin</button>
</div>
<!-- Desktop Table -->
<div class="overflow-x-auto rounded-lg hidden sm:block">
    <table class="min-w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-3">ID</th>
                <th class="px-4 py-3">Picture</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3"><?php echo $admin['id']; ?></td>
                <td class="px-4 py-3">
                    <?php if ($admin['picture']): ?>
                            <img src="<?php echo str_replace('../', '/', $admin['picture']); ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-sm"><?php echo strtoupper(substr($admin['username'], 0, 1)); ?></span>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 font-semibold"><?php echo $admin['username']; ?></td>
                <td class="px-4 py-3"><?php echo $admin['email']; ?></td>
                <td class="px-4 py-3"><?php echo $admin['role']; ?></td>
                <td class="px-4 py-3 space-x-2">
                        <button onclick="openEditModal(<?php echo $admin['id']; ?>)" class="px-3 py-1 bg-[var(--color-secondary)] text-white rounded hover:bg-[var(--color-primary)] transition">Edit</button>
                    <form method="post" class="inline" onsubmit="return confirm('Delete this admin?')">
                        <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                        <button type="submit" name="delete_admin" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Mobile Card View -->
<div class="sm:hidden space-y-4">
    <?php foreach ($admins as $admin): ?>
    <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
        <div class="flex items-center gap-3">
            <?php if ($admin['picture']): ?>
                    <img src="<?php echo str_replace('../', '/', $admin['picture']); ?>" alt="Profile" class="w-12 h-12 rounded-full object-cover">
            <?php else: ?>
                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-lg"><?php echo strtoupper(substr($admin['username'], 0, 1)); ?></span>
                </div>
            <?php endif; ?>
            <div>
                    <span class="font-bold text-[var(--color-primary)]"><?php echo $admin['username']; ?></span>
                <span class="text-xs text-gray-500 block">ID: <?php echo $admin['id']; ?></span>
            </div>
        </div>
        <div class="text-sm text-gray-700">Email: <?php echo $admin['email']; ?></div>
        <div class="text-sm text-gray-700">Role: <?php echo $admin['role']; ?></div>
        <div class="flex gap-2 mt-2">
                <button onclick="openEditModal(<?php echo $admin['id']; ?>)" class="flex-1 px-3 py-2 bg-[var(--color-secondary)] text-white rounded">Edit</button>
            <form method="post" class="flex-1" onsubmit="return confirm('Delete this admin?')">
                <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                <button type="submit" name="delete_admin" class="w-full px-3 py-2 bg-red-500 text-white rounded">Delete</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<!-- Add Admin Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Add Admin</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Profile Picture</label>
                <input type="file" name="picture" accept="image/*" class="w-full px-4 py-2 border rounded" onchange="previewImage(event, 'add')">
                <div id="preview-add" class="mt-2 hidden">
                    <img src="" alt="Preview" class="w-20 h-20 rounded-full object-cover">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Username</label>
                <input type="text" name="username" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Role</label>
                <select name="role" class="w-full px-4 py-2 border rounded" required>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="add_admin" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Add</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Admin Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Edit Admin</h2>
        <form method="post" id="editForm" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <input type="hidden" name="current_picture" id="edit_current_picture">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Profile Picture</label>
                <input type="file" name="picture" accept="image/*" class="w-full px-4 py-2 border rounded" onchange="previewImage(event, 'edit')">
                <div id="preview-edit" class="mt-2">
                    <img src="" alt="Current" class="w-20 h-20 rounded-full object-cover">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Username</label>
                <input type="text" name="username" id="edit_username" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" id="edit_email" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Role</label>
                <select name="role" id="edit_role" class="w-full px-4 py-2 border rounded" required>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="edit_admin" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
function previewImage(event, type) {
    const input = event.target;
    const preview = document.getElementById('preview-' + type);
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEditModal(id) {
    var admin = <?php echo json_encode($admins); ?>.find(a => a.id == id);
    if (!admin) return;
    
    document.getElementById('edit_id').value = admin.id;
    document.getElementById('edit_username').value = admin.username;
    document.getElementById('edit_email').value = admin.email;
    document.getElementById('edit_role').value = admin.role;
    document.getElementById('edit_current_picture').value = admin.picture || '';
    
    const preview = document.getElementById('preview-edit');
    const img = preview.querySelector('img');
    if (admin.picture) {
            img.src = admin.picture.replace('../', '/');
        preview.classList.remove('hidden');
    } else {
        img.src = '';
        preview.classList.add('hidden');
    }
    
    document.getElementById('editModal').classList.remove('hidden');
}
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
