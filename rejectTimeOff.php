<?php
include_once(__DIR__ . '/classes/TimeOff.php');

if (isset($_GET['id'])) {
    $timeOffId = $_GET['id'];
    $timeOff = new TimeOff();
    $success = $timeOff->declineTimeOffRequest($timeOffId);
    if ($success) {
        header('Location: timeOffManager.php');
        exit();
    } else {
        echo "Er is een fout opgetreden bij het afwijzen van het tijd-offverzoek.";
    }
} else {
    echo "Tijd-off ID is niet opgegeven.";
}
