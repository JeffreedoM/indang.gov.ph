<?php
include '../../../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        // Prepare the query to check if the username exists
        $query = "SELECT COUNT(*) FROM accounts WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the result
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Username exists
            echo 'exists';
        } else {
            // Username does not exist
            echo 'does not exist';
        }
    } else {
        // Username not provided
        echo 'error';
    }
} else {
    // Invalid request method
    echo 'error';
}
