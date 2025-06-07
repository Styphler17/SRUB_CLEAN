<?php
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit;

global $themeColors;

log_admin_activity($pdo, $_SESSION['admin_id'], 'Logged out');
