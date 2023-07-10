<?php
include '../../../includes/dbh.inc.php';

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $index = $_GET['narr_index'];

    $stmt = $pdo->prepare("SELECT narrative FROM incident_table WHERE incident_id = :incident_id");
    $stmt->bindParam(':incident_id', $id);
    $stmt->execute();
    $incident = $stmt->fetch();
    $narrative = json_decode($incident['narrative']);

    print_r($narrative);
    unset($narrative[$index]);
    print_r($narrative);

    $newNarrative = json_encode($narrative); // Convert the modified narrative back to JSON format
    $stmt = $pdo->prepare("UPDATE incident_table SET narrative = :narrative WHERE incident_id = :incident_id");
    $stmt->bindParam(':narrative', $newNarrative);
    $stmt->bindParam(':incident_id', $id);
    $stmt->execute();

    header('location: ../action_button/action_edit.php?update_id=' . $id);
}
