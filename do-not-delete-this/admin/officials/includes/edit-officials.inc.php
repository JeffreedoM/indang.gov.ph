<?php

include '../../../includes/dbh.inc.php';

if (isset($_POST['edit-official'])) {
    $resident_id = $_POST['resident_id'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];

    $sql = "UPDATE officials 
            SET date_start = :date_start, date_end = :date_end
            WHERE resident_id = :resident_id";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Create an associative array with parameter names and their corresponding values
    $params = array(
        ':date_start' => $date_start,
        ':date_end' => $date_end,
        ':resident_id' => $resident_id,
    );

    // Execute the statement with the parameter array
    $stmt->execute($params);

    header('Location: ../officials-table.php?edit=success');
}
