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

// Fetch all contact info
$stmt = $pdo->query("SELECT * FROM contact_info ORDER BY id ASC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle add/edit/delete
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
            $whatsapp = $_POST['whatsapp_link'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_numbers = json_encode(array_filter(explode("\n", $_POST['phone_numbers'] ?? '')));
            $google_maps_embed = $_POST['google_maps_embed'] ?? '';
            if ($_POST['action'] === 'add') {
                $stmt = $pdo->prepare("INSERT INTO contact_info (whatsapp_link, email, phone_numbers, google_maps_embed, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                $stmt->execute([$whatsapp, $email, $phone_numbers, $google_maps_embed]);
            } else {
                $id = $_POST['id'] ?? 0;
                $stmt = $pdo->prepare("UPDATE contact_info SET whatsapp_link=?, email=?, phone_numbers=?, google_maps_embed=?, updated_at=NOW() WHERE id=?");
                $stmt->execute([$whatsapp, $email, $phone_numbers, $google_maps_embed, $id]);
            }
            $success = 'Contact info ' . ($_POST['action'] === 'add' ? 'added' : 'updated') . ' successfully!';
            log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated contact info');
        } elseif ($_POST['action'] === 'delete') {
            $id = $_POST['id'] ?? 0;
            $stmt = $pdo->prepare("DELETE FROM contact_info WHERE id=?");
            $stmt->execute([$id]);
            $success = 'Contact info deleted successfully!';
        }
    }
    // Refresh data
    $stmt = $pdo->query("SELECT * FROM contact_info ORDER BY id ASC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

ob_start();
?>
<div class="max-w-4xl mx-auto p-4 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">Contact Info Management</h1>
        <button onclick="openModal('add')" class="bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white py-2 px-4 rounded-lg hover:bg-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>] transition w-full sm:w-auto font-semibold">Add Contact</button>
    </div>
    <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    <div class="grid gap-6 md:grid-cols-2">
        <?php foreach ($contacts as $contact): ?>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col gap-3 border border-gray-100 hover:shadow-lg transition">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold text-lg" style="color: <?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>;">Contact #<?php echo $contact['id']; ?></span>
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('edit', <?php echo $contact['id']; ?>)" class="text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] hover:text-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>] transition" title="Edit"><i class="fas fa-edit"></i></button>
                        <form method="post" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="flex items-center text-gray-700"><i class="fas fa-envelope mr-2 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></i> <span><?php echo $contact['email'] ?? ''; ?></span></div>
                <div class="flex items-center text-gray-700"><i class="fab fa-whatsapp mr-2 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></i> <span><?php echo $contact['whatsapp_link'] ?? ''; ?></span></div>
                <?php foreach (json_decode($contact['phone_numbers'] ?? '[]', true) as $phone): ?>
                    <div class="flex items-center text-gray-700"><i class="fas fa-phone mr-2 text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]"></i> <span><?php echo $phone; ?></span></div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow p-8 max-w-md w-full">
            <h2 id="modalTitle" class="text-xl font-bold mb-4" style="color: <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;">Add Contact</h2>
            <form method="post" id="contactForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="formId" value="">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 text-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>]">WhatsApp Link</label>
                    <input type="text" name="whatsapp_link" id="whatsappLink" class="w-full px-4 py-2 border rounded-lg focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 text-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>]">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 text-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>]">Phone Numbers (one per line)</label>
                    <textarea name="phone_numbers" id="phoneNumbers" rows="3" class="w-full px-4 py-2 border rounded-lg focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg">Cancel</button>
                    <button type="submit" class="bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white px-4 py-2 rounded-lg hover:bg-[<?php echo $themeColors['secondary'] ?? '#2c3e50'; ?>] transition">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openModal(action, id = '') {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = action === 'add' ? 'Add Contact' : 'Edit Contact';
        document.getElementById('formAction').value = action;
        document.getElementById('formId').value = '';
        document.getElementById('whatsappLink').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phoneNumbers').value = '';
        document.getElementById('googleMapsEmbed').value = '';
        if (action === 'edit' && id) {
            var contacts = <?php echo json_encode($contacts); ?>;
            var contact = contacts.find(function(c) {
                return c.id == id;
            });
            if (contact) {
                document.getElementById('formId').value = contact.id;
                document.getElementById('whatsappLink').value = contact.whatsapp_link ?? '';
                document.getElementById('email').value = contact.email ?? '';
                document.getElementById('phoneNumbers').value = (JSON.parse(contact.phone_numbers ?? '[]') || []).join('\n');
                document.getElementById('googleMapsEmbed').value = contact.google_maps_embed ?? '';
            }
        }
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
