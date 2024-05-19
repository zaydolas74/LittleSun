<?php
include_once(__DIR__ . '/classes/Permission.php');
include_once(__DIR__ . '/classes/Task.php');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $tasks = Permission::getTaskIdByUserId($user_id);
    $task_list = [];
    foreach ($tasks as $task) {
        $task_details = Task::getTaskById($task['taskId']); // Assuming you have a method to fetch task details by ID
        $task_list[] = $task_details;
    }
    echo json_encode($task_list);
}
