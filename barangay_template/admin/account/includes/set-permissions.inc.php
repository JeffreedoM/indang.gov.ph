<?php

include '../../../includes/dbh.inc.php';

if (isset($_POST['submit_permissions'])) {
    $officialId = $_POST['official_id'];
    $allowedModules = isset($_POST['selectedModules']) ? $_POST['selectedModules'] : [];

    $allowedModulesJson = json_encode($allowedModules);

    // Update the accounts table to set the allowed_modules for the user
    $stmt = $pdo->prepare("UPDATE accounts SET allowed_modules = ? WHERE official_id = ?");
    $stmt->execute([$allowedModulesJson, $officialId]);

    // Redirect or display a success message
    header('Location: ../index.php?message=success');
}
