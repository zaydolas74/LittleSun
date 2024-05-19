<?php
include_once(__DIR__ . '/classes/Permission.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $taskId = $_POST['task_id'];
    $checked = $_POST['checked'] == 'true' ? 1 : 0;

    if ($checked) {
        // Add permission
        Permission::addUserPermission($userId, $taskId);
    } else {
        // Remove permission
        Permission::removeUserPermission($userId, $taskId);
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
