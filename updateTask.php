<?php
include_once(__DIR__ . '/classes/Task.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskId = $_POST['id'];
    $newType = $_POST['type'];

    $task = new Task();
    $task->editTask($taskId, $newType);
}

header('Location: taskTypes.php');
exit();

?>
