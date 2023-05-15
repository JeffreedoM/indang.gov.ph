<?php

include '../../../includes/dbh.inc.php';

$id = $_GET['id'];


// Start a transaction to ensure atomicity
$pdo->beginTransaction();

try {
    // Get the row to be deleted from the "officials" table
    $stmt = $pdo->prepare("SELECT * FROM officials WHERE resident_id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "No row found with ID $id.";
        exit;
    }

    // Insert the row into the "past_officials" table
    $insertStmt = $pdo->prepare("INSERT INTO past_officials (resident_id, position, date_start, date_end)
                                 VALUES (:resident_id, :position, :date_start, :date_end)");
    $insertParams = [
        'resident_id' => $row['resident_id'],
        'position' => $row['position'],
        'date_start' => $row['date_start'],
        'date_end' => $row['date_end'],
    ];
    $insertStmt->execute($insertParams);

    // Delete the row from the "officials" table
    $deleteStmt = $pdo->prepare("DELETE FROM officials WHERE resident_id = :id");
    $deleteParams = [
        'id' => $id,
    ];
    $deleteStmt->execute($deleteParams);

    // Commit the transaction
    $pdo->commit();

    // echo "Row with ID $id was moved to the past_officials table and deleted from the officials table.";
    header('Location: ../officials-table.php?message=success');
} catch (PDOException $e) {
    // Roll back the transaction if an error occurs
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
