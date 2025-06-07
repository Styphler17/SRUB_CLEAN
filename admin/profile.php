<?php
require_once 'includes/auth.php';
require_once '../app/config/params.php';
require_once 'includes/functions.php';
$pdo = $connexion;

global $themeColors;

// Get current admin data
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$admin = $stmt->fetch();

// Handle profile update
if (isset($_POST['update_profile'])) {
    $picture = $admin['picture'];
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

    $stmt = $pdo->prepare("UPDATE admins SET username=?, email=?, picture=?, updated_at=NOW() WHERE id=?");
    $stmt->execute([
        $_POST['username'],
        $_POST['email'],
        $picture,
        $_SESSION['admin_id']
    ]);

    // Update session data
    $_SESSION['admin_username'] = $_POST['username'];
    $_SESSION['admin_email'] = $_POST['email'];

    log_admin_activity($pdo, $_SESSION['admin_id'], 'Updated profile', 'Changed username/email/profile picture');

    header('Location: profile.php?success=1');
    exit;
}

// Handle password change
if (isset($_POST['change_password'])) {
    if (password_verify($_POST['current_password'], $admin['password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $stmt = $pdo->prepare("UPDATE admins SET password=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([
                password_hash($_POST['new_password'], PASSWORD_DEFAULT),
                $_SESSION['admin_id']
            ]);
            log_admin_activity($pdo, $_SESSION['admin_id'], 'Changed password');
            header('Location: profile.php?success=2');
            exit;
        } else {
            $password_error = "New passwords do not match";
        }
    } else {
        $password_error = "Current password is incorrect";
    }
}

ob_start();
?>
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="glass-bg-admin rounded-2xl shadow-2xl p-6 md:p-10 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-[var(--color-primary)] mb-8 text-center">Profile Settings</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="mb-4 p-4 rounded-lg <?php echo $_GET['success'] == 1 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'; ?> text-center">
                <?php echo $_GET['success'] == 1 ? 'Profile updated successfully!' : 'Password changed successfully!'; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($password_error)): ?>
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-center">
                <?php echo $password_error; ?>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-10">
            <!-- Profile Information -->
            <div>
                <h2 class="text-xl font-semibold mb-4 text-[var(--color-secondary)]">Profile Information</h2>
                <form method="post" enctype="multipart/form-data" class="space-y-5">
                    <div>
                        <label class="block mb-1 font-medium">Profile Picture</label>
                        <div class="flex items-center gap-4 mb-2">
                            <?php if ($admin['picture']): ?>
                                <img src="<?php echo str_replace('../', '/', $admin['picture']); ?>" alt="Profile" class="w-20 h-20 rounded-full object-cover border-4 border-[var(--color-primary)] shadow">
                            <?php else: ?>
                                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center border-4 border-[var(--color-primary)]">
                                    <span class="text-gray-500 text-2xl"><?php echo strtoupper(substr($admin['username'], 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <input type="file" name="picture" accept="image/*" class="w-full px-4 py-2 border rounded bg-white/70" onchange="previewImage(event)">
                                <div id="preview" class="mt-2 hidden">
                                    <img src="" alt="Preview" class="w-20 h-20 rounded-full object-cover border-4 border-[var(--color-primary)] shadow">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Username</label>
                        <input type="text" name="username" value="<?php echo $admin['username']; ?>" class="w-full px-4 py-2 border rounded bg-white/70" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" value="<?php echo $admin['email']; ?>" class="w-full px-4 py-2 border rounded bg-white/70" required>
                    </div>
                    <div>
                        <button type="submit" name="update_profile" class="px-4 py-2 bg-[var(--color-primary)] text-white rounded hover:bg-[var(--color-secondary)] transition font-semibold w-full shadow">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div>
                <h2 class="text-xl font-semibold mb-4 text-[var(--color-secondary)]">Change Password</h2>
                <form method="post" class="space-y-5">
                    <div>
                        <label class="block mb-1 font-medium">Current Password</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border rounded bg-white/70 pr-12" required>
                            <button type="button" class="eye-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[var(--color-primary)] focus:outline-none" tabindex="-1" onclick="togglePassword('current_password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">New Password</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border rounded bg-white/70 pr-12" required>
                            <button type="button" class="eye-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[var(--color-primary)] focus:outline-none" tabindex="-1" onclick="togglePassword('new_password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border rounded bg-white/70 pr-12" required>
                            <button type="button" class="eye-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[var(--color-primary)] focus:outline-none" tabindex="-1" onclick="togglePassword('confirm_password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button type="submit" name="change_password" class="px-4 py-2 bg-[var(--color-secondary)] text-white rounded hover:bg-[var(--color-primary)] transition font-semibold w-full shadow">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .glass-bg-admin {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        border: 1.5px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
    }
</style>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
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
    // Eye toggle for password fields
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            btn.querySelector('svg').innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.292m1.528-1.528A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.132M15 12a3 3 0 11-6 0 3 3 0 016 0z" />\n<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 3l18 18\" />`;
        } else {
            input.type = 'password';
            btn.querySelector('svg').innerHTML = `<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\" />\n<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\" />`;
        }
    }
</script>
<?php
$content = ob_get_clean();
include 'layout.php';
