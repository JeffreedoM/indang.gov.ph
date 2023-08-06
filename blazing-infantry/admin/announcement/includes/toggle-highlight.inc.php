<?php

include '../../../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announcementId'])) {
    $announcementId = $_POST['announcementId'];

    try {
        // Get the current value of is_highlighted for the announcement
        $stmt = $pdo->prepare('SELECT is_highlighted FROM announcement WHERE announcement_id = :announcementId');
        $stmt->bindParam(':announcementId', $announcementId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();

        // Toggle the value of is_highlighted
        $isHighlighted = $row['is_highlighted'] ? 0 : 1;

        // Update the value in the database
        $stmt = $pdo->prepare('UPDATE announcement SET is_highlighted = :isHighlighted WHERE announcement_id = :announcementId');
        $stmt->bindParam(':isHighlighted', $isHighlighted, PDO::PARAM_INT);
        $stmt->bindParam(':announcementId', $announcementId, PDO::PARAM_INT);
        $stmt->execute();

        // Send a response back to the front end
        echo 'Success';
    } catch (PDOException $e) {
        // Handle exceptions if necessary
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Invalid request method or missing announcementId
    echo 'Invalid request';
}
