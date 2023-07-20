<?php

include '../../../includes/dbh.inc.php';

$announcement_id = $_GET['announcement_id'];

// Your SQL query to delete the row from the announcement table
$sql = "DELETE FROM announcement WHERE announcement_id = :id";
// Prepare the SQL statement
$stmt = $pdo->prepare($sql);
// Bind the parameter value for the :id placeholder
$stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);
// Execute the statement
$stmt->execute();

header('Location: ../announcement_list.php');
