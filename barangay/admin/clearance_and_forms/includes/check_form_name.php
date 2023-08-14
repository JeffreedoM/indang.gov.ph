<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

if (isset($_POST['check_form_name'])) {
    $formName = $_POST['form_name'];

    // Perform a PDO query to check if the form name exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM forms WHERE form_name = :formName AND barangay_id = :barangayId");
    $stmt->bindParam(':formName', $formName);
    $stmt->bindParam(':barangayId', $barangayId);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // Return the count as JSON
    echo json_encode(array('count' => $count));
}
