<?php

include 'dbh.inc.php';


if (isset($_POST['reset-password'])) {
    $barangay_id = $_POST['barangay_id'];

    try {
        $query = "SELECT *
            FROM accounts a
            JOIN officials o ON a.official_id = o.official_id
            JOIN resident r ON o.resident_id = r.resident_id
            JOIN barangay b ON r.barangay_id = b.b_id
            WHERE b.b_id = :barangay_id";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
        $statement->execute();
        $barangay = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }

    echo 'Current Hashed Password: ' . $barangay['password'] . '<br>';
    echo 'Default Password: ', $barangay['default_password'];

    /* Get the current hashed password */
    $current_password = $barangay['default_password'];
    $newPassword = password_hash($current_password, PASSWORD_DEFAULT);

    echo $current_password . '<br>';
    echo $newPassword . '<br>';

    /* Resetting to default password */
    try {
        $query = "UPDATE accounts a
                  JOIN officials o ON a.official_id = o.official_id
                  JOIN resident r ON o.resident_id = r.resident_id
                  JOIN barangay b ON r.barangay_id = b.b_id
                  SET a.password = :new_password
                  WHERE b.b_id = :barangay_id";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
        $statement->bindParam(':new_password', $newPassword, PDO::PARAM_STR);
        $statement->execute();

        header("Location: ../barangay-edit.php?id=$barangay_id&reset=success");
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }

    echo 'Current Hashed Password: ' . $barangay['password'] . '<br>';
    echo 'Default Password: ', $barangay['default_password'];
}
