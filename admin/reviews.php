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

// Handle Add Review
if (isset($_POST['add_review'])) {
    $stmt = $pdo->prepare("INSERT INTO reviews (name, rating, comment, created_at, updated_at, created_by_admin) VALUES (?, ?, ?, NOW(), NOW(), ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['rating'],
        $_POST['comment'],
        $_SESSION['admin_id']
    ]);
    $review_id = $pdo->lastInsertId();
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Created review', 'Review ID: ' . $review_id);
    header('Location: reviews.php');
    exit;
}
// Handle Edit Review
if (isset($_POST['edit_review'])) {
    $stmt = $pdo->prepare("UPDATE reviews SET name=?, rating=?, comment=?, updated_at=NOW(), updated_by_admin=? WHERE id=?");
    $stmt->execute([
        $_POST['name'],
        $_POST['rating'],
        $_POST['comment'],
        $_SESSION['admin_id'],
        $_POST['id']
    ]);
    $review_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated review', 'Review ID: ' . $review_id);
    header('Location: reviews.php');
    exit;
}
// Handle Delete Review
if (isset($_POST['delete_review'])) {
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id=?");
    $stmt->execute([$_POST['id']]);
    $review_id = $_POST['id'];
    log_admin_activity($pdo, $_SESSION['admin_id'], 'Deleted review', 'Review ID: ' . $review_id);
    header('Location: reviews.php');
    exit;
}
// Fetch all reviews
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY id DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-[var(--color-primary)]">Reviews</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition w-full sm:w-auto">+ Add Review</button>
</div>
<!-- Desktop Table -->
<div class="overflow-x-auto rounded-lg hidden sm:block">
    <table class="min-w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-3">ID</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Rating</th>
                <th class="px-4 py-3">Comment</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3"><?php echo $review['id']; ?></td>
                    <td class="px-4 py-3 font-semibold"><?php echo $review['name'] ?: 'Anonymous'; ?></td>
                    <td class="px-4 py-3">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i < $review['rating'] ? 'text-[var(--color-secondary)]' : 'text-gray-300'; ?>"></i>
                        <?php endfor; ?>
                    </td>
                    <td class="px-4 py-3"><?php echo $review['comment']; ?></td>
                    <td class="px-4 py-3"><?php echo date('Y-m-d', strtotime($review['created_at'])); ?></td>
                    <td class="px-4 py-3 space-x-2">
                        <button onclick="openEditReviewModal(<?php echo $review['id']; ?>)" class="px-3 py-1 bg-[var(--color-secondary)] text-white rounded hover:bg-[var(--color-primary)] transition">Edit</button>
                        <form method="post" class="inline" onsubmit="return confirm('Delete this review?')">
                            <input type="hidden" name="id" value="<?php echo $review['id']; ?>">
                            <button type="submit" name="delete_review" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Mobile Card View -->
<div class="sm:hidden space-y-4">
    <?php foreach ($reviews as $review): ?>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <span class="font-bold text-[var(--color-primary)]"><?php echo $review['name'] ?: 'Anonymous'; ?></span>
                <span class="text-xs text-gray-500"><?php echo date('Y-m-d', strtotime($review['created_at'])); ?></span>
            </div>
            <div class="flex items-center gap-1">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class="fas fa-star <?php echo $i < $review['rating'] ? 'text-[var(--color-secondary)]' : 'text-gray-300'; ?>"></i>
                <?php endfor; ?>
            </div>
            <div class="text-sm text-gray-700"><?php echo $review['comment']; ?></div>
            <div class="flex gap-2 mt-2">
                <button onclick="openEditReviewModal(<?php echo $review['id']; ?>)" class="flex-1 px-3 py-2 bg-[var(--color-secondary)] text-white rounded">Edit</button>
                <form method="post" class="flex-1" onsubmit="return confirm('Delete this review?')">
                    <input type="hidden" name="id" value="<?php echo $review['id']; ?>">
                    <button type="submit" name="delete_review" class="w-full px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- Add Review Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Add Review</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded" placeholder="Anonymous">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Rating</label>
                <select name="rating" class="w-full px-4 py-2 border rounded" required>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Comment</label>
                <textarea name="comment" class="w-full px-4 py-2 border rounded" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="add_review" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Add</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Review Modal (populated by JS) -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-[var(--color-primary)]">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-[var(--color-primary)]">Edit Review</h2>
        <form method="post" id="editForm">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="edit_name" class="w-full px-4 py-2 border rounded" placeholder="Anonymous">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Rating</label>
                <select name="rating" id="edit_rating" class="w-full px-4 py-2 border rounded" required>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Comment</label>
                <textarea name="comment" id="edit_comment" class="w-full px-4 py-2 border rounded" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" name="edit_review" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Populate and show edit modal
    function openEditReviewModal(id) {
        var review = <?php echo json_encode($reviews); ?>.find(r => r.id == id);
        if (!review) return;
        document.getElementById('edit_id').value = review.id;
        document.getElementById('edit_name').value = review.name;
        document.getElementById('edit_rating').value = review.rating;
        document.getElementById('edit_comment').value = review.comment;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
