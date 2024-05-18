<?php
include_once(__DIR__ . '/classes/Task.php');
include_once("bootstrap.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    try {
        $task = new Task();
        $task->editTask($id, $type);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
