<?php

include '../../../includes/deactivated.inc.php';
include '../../../includes/dbh.inc.php';

if (isset($_POST['submit'])) {
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];
    $objectives = $_POST['objectives'];

    // Prepare and execute the SQL query to insert the data
    $sql = "UPDATE barangay_configuration SET mission = :mission, vision = :vision, objectives = :objectives WHERE barangay_id = :barangayId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'barangay_id' => $barangayId,
        'mission' => $mission,
        'vision' => $vision,
        'objectives' => $objectives
    ]);

    header('Location: ../goals.php');
}
