<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

$form_id = $_GET['form_id'];

$stmt = $pdo->prepare("DELETE FROM forms WHERE form_id = :formId");
$stmt->bindParam(':formId', $form_id, PDO::PARAM_INT); // Bind the parameter

if ($stmt->execute()) {
    echo "Record deleted successfully.";
    header('Location: ../form-list.php?delete=success');
} else {
    echo "Error deleting record.";
    header('Location: ../form-list.php?delete=error');
}
