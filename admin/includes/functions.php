<?php

function log_admin_activity($pdo, $admin_id, $action, $details = null)
{
    $stmt = $pdo->prepare("INSERT INTO admin_activity_log (admin_id, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$admin_id, $action, $details]);
}
