<?php
include_once(__DIR__ . '/classes/Task.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    try {
        $task = new Task();
        $taskId = $task->createTaskType($type); // Pas deze functie aan om alleen het type te maken
        echo json_encode(['success' => true, 'newId' => $taskId]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
