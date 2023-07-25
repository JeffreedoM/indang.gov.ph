<?php
include_once '../../../includes/dbh.inc.php';
include_once '../../../includes/session.inc.php';
include_once '../../../includes/deactivated.inc.php';

$view_id = $_GET['view_id'];

//deleting the incident_offender
if (isset($_GET['del_off_id'])) {
    $id = $_GET['del_off_id'];

    $sql = "DELETE FROM incident_offender WHERE offender_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("location: action_view.php?view_id=$view_id");
        exit();
    } else {
        die("Error: No rows affected.");
    }
}
//deleting the incident_complainant
if (isset($_GET['del_comp_id'])) {

    $id = $_GET['del_comp_id'];

    $sql = "DELETE FROM incident_complainant WHERE complainant_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("location: action_view.php?view_id=$view_id");
        exit();
    } else {
        die("Error: No rows affected.");
    }
}
