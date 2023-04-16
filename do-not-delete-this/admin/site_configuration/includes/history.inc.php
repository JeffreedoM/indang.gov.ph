<?php

include '../../../includes/deactivated.inc.php';
include '../../../includes/dbh.inc.php';

if (isset($_POST['submit'])) {
    $history = $_POST['history'];

    // Prepare and execute the SQL query to insert the data
    $sql = 'INSERT INTO barangay_configuration (barangay_id, history) VALUES (:barangay_id, :history)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'barangay_id' => $barangayId,
        'history' => $history
    ]);

    header('Location: ../history.php');
}
