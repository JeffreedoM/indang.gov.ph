<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';
if (isset($_POST['submit'])) {
    /* For File Image */
    if (!empty($_FILES['image']['name'])) {
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileNameNew = uniqid('', true) . "." . strtolower($fileExt);
        $fileDestination = '../../../../admin/assets/images/uploads/barangay-logos/' . $fileNameNew;

        if (!empty($barangay['b_logo'])) {
            if ($barangay['b_logo'] !== 'logo.png') {
                // Delete the old file
                $fileToDelete = '../../../../admin/assets/images/uploads/barangay-logos/' . $barangay['b_logo'];
                unlink($fileToDelete);
            }
        }

        // Upload the new file
        move_uploaded_file($fileTmpName, $fileDestination);

        // Update the table_column value
        $stmt = $pdo->prepare('UPDATE barangay SET b_logo = :b_logo WHERE b_id = :barangayId');
        $stmt->execute([
            'b_logo' => $fileNameNew,
            'barangayId' => $barangayId
        ]);
    }

    header('Location: ../change-logo.php');
}
