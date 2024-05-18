<?php
include_once(__DIR__ . '/classes/Task.php');

// Controleer of de POST-variabele is ingesteld
if (isset($_POST['task']) && !empty($_POST['task'])) {
    // Haal de ingediende taak op uit de POST-variabele
    $newTask = $_POST['task'];

    try {
        // Maak een nieuwe taak aan met behulp van de Task-klasse
        $taskObject = new Task();
        $taskId = $taskObject->createTaskType($newTask);

        // Controleer of de taak succesvol is toegevoegd
        if ($taskId) {
            // Stuur een succesbericht terug
            echo "Task is succesvol toegevoegd.";
        } else {
            // Stuur een foutbericht terug als er een probleem is opgetreden bij het toevoegen van de taak
            echo "Er is een fout opgetreden bij het toevoegen van de taak.";
        }
    } catch (Exception $e) {
        // Stuur een foutbericht terug als er een fout is opgetreden tijdens het toevoegen van de taak
        echo $e->getMessage();
    }
} else {
    // Stuur een foutbericht terug als de POST-variabele niet is ingesteld of leeg is
    echo "Er is geen taak gegeven om toe te voegen.";
}
