<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM incident_table WHERE incident_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("location: ../list_incident.php");
        exit();
    } else {
        die("Error: No rows affected.");
    }
}
