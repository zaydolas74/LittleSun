
<?php
// Start session and include necessary files
session_start();
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Task.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $task = new Task();
    $user_id = $_POST['user'];
    $task_id = $_POST['task'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    echo $date;
}

?>
