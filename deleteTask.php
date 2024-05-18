<?php
include_once(__DIR__ . '/classes/Task.php');

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];
    Task::deleteTask($taskId);
    header('Location: taskTypes.php');
    exit();
} else {
    echo 'Taak-ID niet opgegeven';
}
