<?php

include '../../../includes/deactivated.inc.php';
include '../../../includes/dbh.inc.php';

if (isset($_POST['submit'])) {
    $history = $_POST['history'];

    // Prepare and execute the SQL query to update the data
    $sql = 'UPDATE barangay_configuration SET history = :history WHERE barangay_id = :barangay_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'history' => $history,
        'barangay_id' => $barangayId
    ]);

    header('Location: ../history.php');
}
