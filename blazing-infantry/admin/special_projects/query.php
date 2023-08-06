<?php
include '../../includes/dbh.inc.php';
include '../../includes/deactivated.inc.php';

if (isset($_POST['submit'])) {
    $project_name = $_POST['project_name'];
    $project_date = $_POST['project_date'];
    $project_description = $_POST['project_description'];
    $project_requirements = $_POST['project_requirements'];
    $project_host = $_POST['project_host'];
    $project_other_host = $_POST['project_other_host'];

    $query = "INSERT INTO special_project (barangay_id, project_name, project_date, project_description, project_requirements,project_host,project_other_host)
        VALUES (?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$barangayId, $project_name, $project_date, $project_description, $project_requirements, $project_host, $project_other_host]);
    header("Location: ../special_projects/index.php");
}

if (isset($_POST['submit_edit'])) {
    $project_id = $_POST['project_id'];
    $project_name = $_POST['project_name'];
    $project_date = $_POST['project_date'];
    $project_description = $_POST['project_description'];
    $project_requirements = $_POST['project_requirements'];
    $project_host = $_POST['project_host'];
    $project_other_host = $_POST['project_other_host'];

    $query = "UPDATE special_project 
        SET project_name=?, project_date=?, project_description=?, project_requirements=?, project_host=?,project_other_host=?
        WHERE project_id=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$project_name, $project_date, $project_description, $project_requirements, $project_host, $project_other_host, $project_id]);
    header("Location: ../special_projects/index.php");
}
