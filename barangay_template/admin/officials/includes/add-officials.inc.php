<?php
include '../../../includes/deactivated.inc.php';
include '../../../includes/dbh.inc.php';

if (isset($_POST['position'])) {
    $position = $_POST['position'];

    // Prepare a SELECT statement to check if the position is already occupied
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM officials 
    JOIN resident ON officials.resident_id = resident.resident_id 
    JOIN barangay ON resident.barangay_id = barangay.b_id WHERE position = :position AND barangay.b_id = :barangayId');
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':barangayId', $barangayId);
    $stmt->execute();

    // Fetch the result of the SELECT statement
    $count = $stmt->fetchColumn();

    // Return a JSON object indicating whether or not the position is already occupied
    echo json_encode(array('occupied' => ($count > 0)));
}

if (isset($_POST['submit'])) {
    $resident_id = $_POST['resident_id'];
    $position = $_POST['position'];
    $date_start = $_POST['date-start'];
    $date_end = $_POST['date-end'];

    // Convert date format to YYYY-MM-DD
    $date_start = date('Y-m-d', strtotime($date_start));
    $date_end = date('Y-m-d', strtotime($date_end));

    // Prepare the SQL statement for inserting data into the officials table
    $sql = "INSERT INTO officials (resident_id, position, date_start, date_end) VALUES (:resident_id, :position, :date_start, :date_end)";

    // Bind the values to the placeholders in the SQL statement using an array
    $params = array(
        ':resident_id' => $resident_id,
        ':position' => $position,
        ':date_start' => $date_start,
        ':date_end' => $date_end
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../add-officials.php?message=success');
}
