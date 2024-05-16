
<?php

include_once(__DIR__ . '/Task.php');

    if (isset($_GET['id'])) {
        $task= new Task();
        $task->deleteTask($_GET['id']);
        header('Location: taskTypes.php');
        exit();
    } 
    else {
        echo "Task ID is not set.";
    }

