<?php

include 'dbh.inc.php';
$municipality = $pdo->query("SELECT municipality_name FROM superadmin_config")->fetch();
$municipality_name = $municipality['municipality_name'];
$municipality = $pdo->query("SELECT municipality_link FROM superadmin_config")->fetch();
$municipality_link = $municipality['municipality_link'];
// $brgyFolderName = strtolower(str_replace(" ", "-", trim($brgyName)));
if (isset($_POST['submit'])) {
    $barangayId = $_POST['barangayId'];
    $brgyName = $_POST['brgy-name'];
    $brgyAddress = $_POST['brgy-address'];

    // get current barangay data
    $currentBrgy =  $pdo->query("SELECT * FROM barangay WHERE b_id = '$barangayId'")->fetch();
    $currentBrgyName = $currentBrgy['b_name'];
    $currentBrgyFolderName = strtolower(str_replace(" ", "-", trim($currentBrgyName)));

    // new barangay folder name
    $newbrgyFolderName = strtolower(str_replace(" ", "-", trim($brgyName)));
    $rootDirectory = $_SERVER['DOCUMENT_ROOT'] . '/' . $municipality_link; // Set the root directory path

    // Rename the directory
    if (rename($rootDirectory . '/' . $currentBrgyFolderName, $rootDirectory . '/' . $newbrgyFolderName)) {
        echo 'Directory renamed successfully.';
    } else {
        echo 'Error renaming the directory.';
    }

    // for Barangay link
    $brgyLink = "$municipality_link/$newbrgyFolderName";

    /* For File Image */
    if (!empty($_FILES['image']['name'])) {
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileNameNew = uniqid('', true) . "." . strtolower($fileExt);
        $fileDestination = '../assets/images/uploads/barangay-logos/' . $fileNameNew;

        if (!empty($currentBrgy['b_logo'])) {
            // Delete the old file
            $fileToDelete = '../assets/images/uploads/barangay-logos/' . $currentBrgy['b_logo'];
            unlink($fileToDelete);
        }

        // Upload the new file
        move_uploaded_file($fileTmpName, $fileDestination);

        // Update the barangay logo
        $stmt = $pdo->prepare('UPDATE barangay SET b_logo = :b_logo WHERE b_id = :barangayId');
        $stmt->execute([
            'b_logo' => $fileNameNew,
            'barangayId' => $barangayId
        ]);
    }
    // Update the barangay table name and address
    $stmt = $pdo->prepare('UPDATE barangay SET b_name = :b_name, b_address = :b_address, b_link = :b_link WHERE b_id = :barangayId');
    $stmt->execute([
        'b_name' => $brgyName,
        'b_address' => $brgyAddress,
        'b_link' => $brgyLink,
        'barangayId' => $barangayId
    ]);

    header("Location: ../barangay-edit.php?id=$barangayId");
}
