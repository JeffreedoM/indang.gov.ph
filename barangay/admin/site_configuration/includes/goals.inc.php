<?php

include '../../../includes/deactivated.inc.php';
include '../../../includes/dbh.inc.php';

if (isset($_POST['submit'])) {
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];
    $objectives = $_POST['objectives'];

    // Prepare and execute the SQL query to insert the data
    $sql = "UPDATE barangay_configuration SET mission = :mission, vision = :vision, objectives = :objectives WHERE barangay_id = :barangay_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'barangay_id' => $barangayId,
        'mission' => nl2br($mission),
        'vision' => nl2br($vision),
        'objectives' => nl2br($objectives)
    ]);

    header('Location: ../goals.php');
}
