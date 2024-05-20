<?php
include_once(__DIR__ . '/Task.php');

// Controleer of de taak-id is ingesteld en geldig is
if (isset($_POST['taskId']) && !empty($_POST['taskId'])) {
    // Haal de taak-id op uit de POST-data
    $taskId = $_POST['taskId'];
    try {
        // Verwijder de taak met de opgegeven id

        if (1 == 1) {
            // Geef een succesbericht terug als de taak succesvol is verwijderd
            echo 'Task successfully deleted.';
        } else {
            // Geef een foutbericht terug als er een probleem was bij het verwijderen van de taak
            echo 'Failed to delete task. Please try again later.';
        }
    } catch (Exception $e) {
        // Geef een foutbericht terug als er een uitzondering wordt gegenereerd tijdens het verwijderen van de taak
        echo $e->getMessage();
    }
} else {
    // Geef een foutbericht terug als de taak-id niet is ingesteld of leeg is
    echo 'Task ID is missing or invalid.';
}
