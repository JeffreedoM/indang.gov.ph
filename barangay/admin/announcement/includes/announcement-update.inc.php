<?php

include '../../../includes/dbh.inc.php';

if (isset($_POST['update_announcement'])) {
    $announcement_id = $_POST['announcement_id'];
    $announcement_title = $_POST['announcement_title'];
    $announcement_what = $_POST['announcement_what'];
    $announcement_where = $_POST['announcement_where'];
    $announcement_when = $_POST['announcement_when'];
    $receiver = $_POST['announcement_receiver'];
    $announcement_message = $_POST['announcement_message'];

    $sql = "UPDATE announcement 
            SET announcement_title = :title,
                announcement_what = :what,
                announcement_where = :where,
                announcement_when = :when,
                receiver = :receiver,
                announcement_message = :message
            WHERE announcement_id = :id";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameter values using an array
    $params = array(
        ':title' => $announcement_title,
        ':what' => $announcement_what,
        ':where' => $announcement_where,
        ':when' => $announcement_when,
        ':receiver' => $receiver,
        ':message' => $announcement_message,
        ':id' => $announcement_id
    );

    // Execute the statement with the parameter array
    $stmt->execute($params);

    /* For announcement Image */
    // Fetch the current announcement_photo from the database
    $fetchPhotoQuery = "SELECT announcement_photo FROM announcement WHERE announcement_id = :id";
    $stmtFetchPhoto = $pdo->prepare($fetchPhotoQuery);
    $stmtFetchPhoto->bindParam(':id', $announcement_id, PDO::PARAM_INT);
    $stmtFetchPhoto->execute();

    // Get the current photo path from the database
    $row = $stmtFetchPhoto->fetch(PDO::FETCH_ASSOC);
    $previousImage = $row['announcement_photo'];

    // Check if announcement_photo file is uploaded
    if (!empty($_FILES['announcement_photo']['name'])) {
        // For announcement_photo
        $fileName = $_FILES['announcement_photo']['name'];
        $fileTmpName = $_FILES['announcement_photo']['tmp_name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileNameNew = uniqid('', true) . "." . strtolower($fileExt);
        $fileDestination = '../uploads/' . $fileNameNew;

        // Upload the announcement_photo
        move_uploaded_file($fileTmpName, $fileDestination);
        $announcement_photo = $fileNameNew;
        echo 'New announcement photo uploaded successfully.';

        // Delete the previous image if it exists
        if (!empty($previousImage)) {
            $previousImagePath = '../uploads/' . $previousImage;
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
                echo 'Previous announcement photo deleted successfully.';
            }
        }
    } else {
        $announcement_photo = $previousImage; // Use the previous image if no new image is uploaded
        echo 'No new announcement photo uploaded.';
    }

    $sql = "UPDATE announcement 
            SET announcement_photo = :photo
            WHERE announcement_id = :id";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameter values using an array
    $params = array(
        ':photo' => $announcement_photo,
        ':id' => $announcement_id
    );

    // Execute the statement with the parameter array
    $stmt->execute($params);

    header('Location: ../announcement_update.php?announcement_id=' . $announcement_id);
}
