<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';

// Check if a specific record should be deleted
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Prepare and execute the DELETE statement
    $stmt = $pdo->prepare("DELETE FROM report_personnel_list WHERE pam_id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the record was deleted successfully
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('The record was deleted successfully.');</script>";
        header('location: view.php');
    } else {
        // echo "Error deleting record: " . $pdo->errorInfo()[2];

        echo "<script>alert('Error deleting record: The record was already deleted.');</script>";
    }

    // Close statement
    $stmt->closeCursor();
}
